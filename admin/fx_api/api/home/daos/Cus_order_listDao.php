<?php

namespace api\home;

class Cus_order_listDao extends Dao {
    /*     * 执行自定义增删改语句 */

    public $table = 'Cus_order_list';
    public $fields = '*';

    public function __construct() {
        parent::__construct();
        $this->fields = 'id as cus_id, order_id, order_sn, buyer_id, supplier_id, shop_id as platform, refund_amount, remark, shipping_fee, other_order_sn, ';
        $this->fields.='cus_type, refund_reason, shipping_code as freight_code, company_name as freight_company, refund_status, return_status, other_shop as platform_name, ';
        $this->fields.=' addtime as add_time, close_time, return_time, refund_money_time';
    }

    public function lists($user_id, $page, $return_status, $refund_status) {   //售后列表
        $per_page = Config('page_num');
        $a = ($page - 1) * $per_page;   //起始页
        $b = $page * $per_page;    //结束页
        $limit = "$a, $b";

        $condition = "( return_status=$return_status or refund_status=$refund_status)";


        $sql = 'select ' . $this->fields . ' from ' . $this->table . ' where buyer_id=:id  and ' . $condition . ' limit ' . $limit;
        $param = ['id' => $user_id];
        $aftersale = $this->query($sql, $param);

        if (!$aftersale) {                  //主订单信息没有找到
            return [];
        }

        $cus_ids = '(';                        //查询商品
        foreach ($aftersale as &$v) {
            $cus_ids.=$v['cus_id'] . ',';
            $v['goods'] = [];
        }
        $cus_ids = rtrim($cus_ids, ',');
        $cus_ids.=')';

        $fields = 'b.cus_id as id,b.goods_id, b.goods_name, b.img_path, b.goods_num, b.price  ';
        $sql = 'select ' . $fields . ' from cus_order_goods_list as b where 1=:placeholder and cus_id in ' . $cus_ids;
        $param = ['placeholder' => 1];
        $goods = $this->query($sql, $param);

        if (is_array($goods)) {
            $goods_ids = '(';                                     //查询sku
            foreach ($goods as &$v) {
                $goods_ids.=$v['goods_id'] . ',';
                $v['sku'] = [];
                // $v['img_path']=imgUrl($v['img_path'], 'goods');
            }
            $goods_ids = rtrim($goods_ids, ',');
            $goods_ids.=')';
            $fields = 'c.goods_id, c.sku_str_zh';
            $sql = 'select ' . $fields . ' from goods_sku_comb as c where 1=:placeholder and goods_id in ' . $goods_ids;
            $param = ['placeholder' => 1];
            $skus = $this->query($sql, $param);

            if ($skus) {                                    //合并sku和商品
                foreach ($goods as &$v) {
                    foreach ($skus as $k => &$v2) {
                        if ($v['goods_id'] == $v2['goods_id']) {
                            $v['sku'][] = $v2;
                        }
                    }
                }
            }

            foreach ($aftersale as &$v) {                   //合并商品和主信息
                $v['goods'] = [];
                foreach ($goods as $k => &$v2) {
                    if ($v['cus_id'] == $v2['id']) {
                        $v['goods'][] = $v2;
                        unset($v['goods'][$k]['id']);
                        // $v['goods'][$k]['sku']=[];                //商品sku属性
                    }
                }
            }
        }
        return $aftersale;
    }

    public function getRelationInfo($order_id, $user_id, $reason_code) {                  //查询关联数据用于写入

        $sql = 'select count(*) from ' . $this->table . ' where order_id=:order and buyer_id=:id';
        $param = ['order' => $order_id, 'id' => $user_id];
        $r = $this->query($sql, $param, 'fetch_string');                         //检查，确保一个订单只能一条售后
        if ($r > 0) {                                                           //不可申请售后
            return false;
        }

        $fields = 'a.order_id, a.order_sn, a.buyer_id, a.buyer_name, a.shop_id, a.supplier_id, a.pay_amount as refund_amount, a.shipping_id as shipping_no, a.qq as distributors_qq, a.order_state, a.other_shop, a.other_order_sn, a.finnshed_time as finished, a.cost_price, a.shipping_fee, ';
        $fields.='b.contact_name as receiver_name, b.contact_address as  receiver_address, b.tel as receiver_mobile';
        $sql = 'select ' . $fields . ' from order_list as a left join order_contact as b on a.order_id=b.order_id where a.order_id=:order and a.buyer_id=:id limit 1';
        $param = ['order' => $order_id, 'id' => $user_id];

        $r = $this->query($sql, $param, 'fetch_row');
        // dump(\Sql::get());
        //检查是否过期
        // dump($r);die;
        $expire=$r && $r['order_state'] == \order_status::success && ($r['finished']+7*23*3600 < time());

        // dump($expire);die;
        if (!$r ||  $r['order_state'] == \order_status::wait_pay || $r['order_state'] == \order_status::wait_confirm_pay || $r['order_state'] == \order_status::close || $r['order_state'] == \order_status::error) {         //如果没有结果或者是待付款状态返回失败，意味着不可添加售后状态
            return false;
        }


        //检查退货理由是否正确
        $is_right_reason1 = false;
        $is_right_reason2 = false;
        if ($r['order_state'] == \order_status::wait_send_goods) {                //待发货下发起， 退款流程
            $is_right_reason1 = $reason_code == \aftersale_remark::buy_error || $reason_code == \aftersale_remark::do_not_want;
            $show_refund=$r['cost_price'];          //  //用于分销商的价格
        }
        if ($r['order_state'] == \order_status::wait_receive_goods || $r['order_state'] == \order_status::success) {          //待收货和已完成下发起，退货流程
            $is_right_reason2 = $reason_code != \aftersale_remark::buy_error && $reason_code != \aftersale_remark::do_not_want;
            //生成分销商的退款价格
            if ($reason_code==\aftersale_remark::seven_day_no_reason) {         //扣除运费
                $show_refund=$r['cost_price']-$r['shipping_fee'];
            }
            //还要补款
            if ($reason_code != \aftersale_remark::buy_error && $reason_code != \aftersale_remark::seven_day_no_reason && $reason_code != \aftersale_remark::do_not_want) {
                $show_refund=$r['cost_price'] + $this->getRefundFreight($r['order_id']);
            } 
        }

        $r['show_refund']=$show_refund;

        $is_right_reason = $is_right_reason1 || $is_right_reason2;
        if (!$is_right_reason) {                                        //退货理由不对
            myerror(\StatusCode::msgAftersaleWrong, '售后理由不符合当前订单');
        }



        $r['order_state'] == \order_status::wait_send_goods and $r['cus_type'] = 2;             // 退款
        $r['order_state'] == \order_status::wait_receive_goods || $r['order_state'] == \order_status::success and $r['cus_type'] = 1;     //退货

        $r['return_status'] = 0;          //计算状态
        $r['refund_status'] = 0;
        $r['cus_type'] == 1 ? $r['return_status'] = \aftersale_back_good_status::wait_admin_confirm : $r['refund_status'] = \aftersale_back_money_status::wait_supplier_confirm;

        // 验证通过，查询商品
        $fields = 'a.goods_id, a.goods_name, a.img_path, a.goods_num, a.buyer_goods_no, a.distribution_price as price, a.depot_id, b.sku_comb_id';
        $sql = 'select ' . $fields . ' from order_goods as a left join order_goods_sku as b on a.order_id=b.order_id where a.order_id=:order';
        $param = ['order' => $order_id];
        $goods = $this->query($sql, $param);
        return ['main' => $r, 'goods' => $goods];
    }

    private function getRefundFreight($order_id){           //获得补款运费
        $sql="select province from order_contact where order_id=:order_id limit 1";
        $param=['order_id'=>$order_id];
        $to=$this->query($sql, $param, 'fetch_string');

        $sql="select province from order_goods as a inner join goods_list as b on a.goods_id=b.goods_id inner join fx_storage_list as c on b.depot_id=c.id where a.order_id=:order_id limit 1";
        $from=$this->query($sql, $param, 'fetch_string');
        

        $sql="select fee from fx_refund_template where `from` like :from and `to` like :to limit 1";
        $param=['from'=>$from, 'to'=>$to];
        $amount=$this->query($sql, $param, 'fetch_string');
        $amount=isset($amount)? $amount: 0;           //默认
        return $amount;
    }


    public function getDetail($user_id, $cus_id) {                //查询售后详情                                                                                                         //售后订单
        $sql = 'select ' . $this->fields . ' from ' . $this->table . ' where id=:cus_id and buyer_id=:user_id limit 1';

        $param = ['cus_id' => $cus_id, 'user_id' => $user_id];
        $main = $this->query($sql, $param, 'fetch_row');

        if (!$main) {
            myerror(\StatusCode::msgAftersaleWrong, '该售后信息不可查看');
        }
        $fields = 'goods_id, goods_name, img_path, goods_num, price';                                                                                                //售后商品
        $sql = 'select ' . $fields . ' from  cus_order_goods_list where cus_id=:cus_id';
        $param = ['cus_id' => $cus_id];
        $goods = $this->query($sql, $param);

        $goods_ids = '(';                                     //查询sku
        foreach ($goods as &$v) {
            $goods_ids.=$v['goods_id'] . ',';
            $v['sku'] = [];
        }
        $goods_ids = rtrim($goods_ids, ',');
        $goods_ids.=')';
        $fields = 'c.goods_id, c.sku_str_zh';
        $sql = 'select ' . $fields . ' from goods_sku_comb as c where 1=:placeholder and goods_id in ' . $goods_ids;
        $param = ['placeholder' => 1];
        $skus = $this->query($sql, $param);
        if ($skus) {                                    //合并sku和商品
            foreach ($goods as &$v) {
                foreach ($skus as $k => &$v2) {
                    if ($v['goods_id'] == $v2['goods_id']) {
                        $v['sku'][$k] = $v2;
                    }
                }
            }
        }

        $fields = 'img_path';                                                                                                //售后图片
        $sql = 'select ' . $fields . ' from  cus_order_goods_img where cus_id=:cus_id';
        $param = ['cus_id' => $cus_id];
        $imgs = $this->query($sql, $param);


        return ['main' => $main, 'goods' => $goods, 'imgs' => $imgs];
    }

    public function getStatus($cus_id, $user_id, $type) {                     //通过售后订单和状态类型获得记录数,用于更改订单状态用
        $sql = "select $type from  $this->table where id=:cus_id and buyer_id=:user_id";
        $param = ['cus_id' => $cus_id, 'user_id' => $user_id];
        return $this->query($sql, $param, 'fetch_string');
    }

    public function changeStatus($cus_id, $user_id, $raw, $is_cancel) {               //改变售后状态
        $data = '';
        $bind = [];
        foreach ($raw as $k => &$v) {
            $data.=$k . '=:' . $k . ',';
            $bind[$k] = $v;
        }
        $data = rtrim($data, ',');

        $this->beginTrans();
        $sql = "update $this->table set $data where id=:cus_id and buyer_id=:user_id";
        $param = ['cus_id' => $cus_id, 'user_id' => $user_id];
        $param = array_merge($param, $bind);
        $r1=$this->excute($sql, $param);

        if ($is_cancel) {
            $sql="select order_id from $this->table where id=:cus_id and buyer_id=:user_id";
            $param = ['cus_id' => $cus_id, 'user_id' => $user_id];
            $order_id=$this->excute($sql, $param, 'fetch_string');
            $sql="update order_list set is_cus=2 where order_id=:order_id and buyer_id=:user_id";
            $param = ['order_id' => $order_id, 'user_id' => $user_id];
            $r2=$this->excute($sql, $param);
        }   
        $this->endTrans();
        return $r1;

    }

    /**
     * 获取售后列表order_id
     * @param type $order_id_arr
     */
    public function get_cus_order_ids($order_id_arr) {
        $order_ids = implode(',', $order_id_arr);
        $sql = "select order_id from cus_order_list force index (order_id) where order_id in ({$order_ids}) and (refund_status<>2 and refund_status<>6 or return_status<>2 and return_status<>8)";
        $result = $this->query($sql, []);
        return array_combine(array_column($result, 'order_id'), array_column($result, 'order_id'));
    }

}
