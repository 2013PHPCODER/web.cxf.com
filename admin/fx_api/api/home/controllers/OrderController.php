<?php

namespace api\home;

class OrderController extends Controller {

    /**
     * 订单列表
     * @return string JSON
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function order_list() {
        $q = $this->request;
        \Valid::not_empty($q->user_id)->withError('用户id不能为空');
        $param = array();
        $param['buyer_id'] = $q->user_id;
        $condition = "o_l.buyer_id=:buyer_id";
        if (isset($q->order_state)) {
            if (0 == $q->order_state) {
                $condition .= " and o_l.order_state=:order_state and is_pay=0";
            } elseif (1 == $q->order_state) {
                $condition .= " and (o_l.order_state=:order_state or o_l.order_state=0) and is_pay=1";
            } else {
                $condition .= " and o_l.order_state=:order_state";
            }
            $param['order_state'] = $q->order_state;
        }
        if (isset($q->keyword)) {
            $condition .= " and (o_l.order_sn=:keyword or o_l.other_order_sn=:keyword or o_g.buyer_goods_no=:keyword or o_g.goods_name like :goods_name_keyword)";
            $param['keyword'] = $q->keyword;
            $param['goods_name_keyword'] = '%' . $q->keyword . '%';
        }
        $page = isset($q->page) ? $q->page : 1;
        $per_page = isset($q->per_page) ? $q->per_page : 20;
        $sort = "o_l.order_id desc";
        $fields = "o_l.order_id,o_l.order_sn,o_l.add_time,o_l.pay_amount,o_l.shipping_fee,o_l.other_shop,o_l.other_order_sn,o_l.order_state,o_l.is_cus,"
                . "o_g.goods_name,o_g.buyer_goods_no,o_g.distribution_price,o_g.goods_num,o_g.goods_id,goods_sku_comb.sku_str_zh";
        $dao = \Dao::Order_list();
        $result = $dao->getOrderList($fields, $condition, $param, $sort, ($page - 1) * $per_page, $per_page);
        $order_id_cus = array();
        if (0 < count($result['item'])) {
            $order_id_arr = array_column($result['item'], 'order_id');
            $cus_dao = \Dao::Cus_order_list();
            $order_id_cus = $cus_dao->get_cus_order_ids($order_id_arr);
        }
        array_walk($result['item'], function (&$v) use($q, $order_id_cus) {
            if (isset($q->order_state) && 1 == $q->order_state) {
                $v['order_state'] = 1;
            }
            $v['add_time'] = date("Y-m-d H:i:s", $v['add_time']);
            $v['is_cus'] = isset($order_id_cus[$v['order_id']]) ? 1 : 0;
        });
        $this->response['page'] = $page;
        $this->response['per_page'] = $per_page;
        $this->response['total'] = $result['total'];
        $this->response['item'] = $result['item'];
        $this->response();
    }

    /**
     * 订单详情
     * @param int $_order_id 订单ID
     * @param string $_order_sn 订单编号
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608111323
     */
    public function order_details() {
        //echo json_encode(array('order_id'=>1,'order_sn'=>"1160719035332928408"));exit;
        //{"order_id":1,"userid":1,"order_sn":"1160719035332928408"}
        if (!isset($this->request->order_id)) myerror(\StatusCode::msgCheckFail, \Order::order_id_not_null);
        if (!isset($this->request->order_sn)) myerror(\StatusCode::msgCheckFail, \Order::order_detail_order_sn);

        $_order_list_dao = \Dao::Order_list();
        $_datas = $_order_list_dao->order_details($this->request->order_id, $this->request->order_sn);
        $this->response($_datas);
    }

    /**
     * 购买商品（下单）
     * @return string JSON
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function add_order() {
        $q = $this->request;
        if (empty($q->user_id)) myerror(\StatusCode::msgCheckFail, '用户id不能为空！');
        if (empty($q->user_name)) myerror(\StatusCode::msgCheckFail, '用户姓名不能为空！');
        if (empty($q->goods_id)) myerror(\StatusCode::msgCheckFail, '商品id不能为空！');
        if (empty($q->goods_sku_id)) myerror(\StatusCode::msgCheckFail, '商品skuid不能为空！');
        if (empty($q->goods_count)) myerror(\StatusCode::msgCheckFail, '商品数量不能为空！');
        if (empty($q->contact_name)) myerror(\StatusCode::msgCheckFail, '联系人姓名不能为空！');
        if (empty($q->tel)) myerror(\StatusCode::msgCheckFail, '电话不能为空！');
        if (empty($q->province)) myerror(\StatusCode::msgCheckFail, '省不能为空！');
//        if (empty($q->city)) myerror(\StatusCode::msgCheckFail, '市不能为空！');
        if (empty($q->receiver_address)) myerror(\StatusCode::msgCheckFail, '地区编码不能为空！');
        if (empty($q->contact_address)) myerror(\StatusCode::msgCheckFail, '详细地址不能为空！');
        if (empty($q->platform)) myerror(\StatusCode::msgCheckFail, '请填写订单来源不能为空！');

        $_distribute_user_obj = \Dao::Fx_distribute_user();
        $user_info = $_distribute_user_obj->get_user_info($q->user_id, $q->user_name); //获取用户基本信息
        if (!$user_info) {
            myerror(\StatusCode::msgCheckFail, '获取用户信息失败！');
        }
        if (0 == $user_info['leavel']) {
            myerror(\StatusCode::msgCheckFail, '请升级后再来购买！');
        }
        if (!$user_info['qq']) {
            myerror(\StatusCode::msgCheckFail, '用户信息不完整，请补充完整后再试！');
        }
        $_goods_list_obj = \Dao::Goods_list();
        $goods_info = $_goods_list_obj->get_goods_info($q->goods_id); //获取商品基本信息
        $q->freight = $this->compute($q->goods_id, $q->receiver_address);
        $goods_info = $goods_info[0];
        if (!$goods_info['img_path']) myerror(\StatusCode::msgCheckFail, '商品信息有误！');
        $order_message_data = array();
        if (!empty($q->message)) {//判断是否有留言，有则创建数据
            $order_message_data = $this->create_order_message_data($q);
        }
        $order_list_dao = \Dao::Order_list();
        $_order_goods_sku_data = $this->create_order_goods_sku_data($goods_info, $q->goods_sku_id);
        $order_data = $this->create_order_data($q, $goods_info, $order_list_dao, $user_info);
        $order_contact_data = $this->create_order_contact_data($q);
        $order_goods_data = $this->create_order_goods_data($goods_info, $user_info['leavel'], $q->goods_count);
        $order_id = $order_list_dao->add_order($q, $order_data, $order_contact_data, $order_goods_data, $_order_goods_sku_data, $order_message_data);
        $this->response['order_id'] = $order_id;
        $this->response['order_sn'] = $order_data['order_sn'];
        $this->response['pay_amount'] = $order_data['pay_amount'];
        $this->response['message'] = '下单成功！';
        $this->response();
    }

    /**
     * 生成order_message_data
     * @param type $q
     * @return array
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function create_order_message_data($q) {
        $_order_message_data['user_type'] = 3;
        $_order_message_data['user_id'] = $q->user_id;
        $_order_message_data['message'] = $q->message;
        $_order_message_data['addtime'] = time();
        $_order_message_data['to_user_type'] = 2;
        return $_order_message_data;
    }

    /**
     * 生成order_goods_sku_data
     * @param type $goods_info
     * @param type $goods_sku_id
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function create_order_goods_sku_data($goods_info, $goods_sku_id) {
        $_order_goods_sku_data['goods_id'] = $goods_info['goods_id'];
        $_order_goods_sku_data['sku_comb_id'] = $goods_sku_id;
        return $_order_goods_sku_data;
    }

    /**
     * 生成order_goods_data
     * @param type $goods_info
     * @param type $user_level
     * @param type $goods_num
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function create_order_goods_data($goods_info, $user_level, $goods_num) {
        $goods_data['goods_id'] = $goods_info['goods_id'];
        $goods_data['goods_no'] = $goods_info['goods_no'];
        $goods_data['depot_id'] = $goods_info['depot_id'];
        $goods_data['goods_name'] = $goods_info['goods_name'];
        $goods_data['goods_num'] = $goods_num;
        $goods_data['price'] = $goods_info['distribution_price'];
        $goods_data['distribution_price'] = get_distribution_price($user_level, $goods_info['distribution_price']);
        $goods_data['buyer_goods_no'] = $goods_info['buyer_goods_no'];
        $goods_data['category_id'] = $goods_info['goods_category'];
        $goods_data['top_category'] = $goods_info['top_category'];
        $goods_data['img_path'] = $goods_info['img_path'];
        $goods_data['add_time'] = time();
        return $goods_data;
    }

    /**
     * 生成order_data
     * @param type $q
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function create_order_data($q, $goods_info, $order_list_dao, $user_info) {
        if (!empty($q->message)) {
            $order_data['message_starts'] = 1;
        }
        $order_data['order_sn'] = '1' . date('ymdhis' . rand(100000, 999999));
        $result_order_sn = $order_list_dao->checkOrderSn($order_data['order_sn']);
        while ($result_order_sn) {
            $result_order_sn = $order_list_dao->checkOrderSn($order_data['order_sn']);
        }
        $order_data['shipping_fee'] = $q->freight;
        $distribution_price = get_distribution_price($user_info['leavel'], $goods_info['distribution_price']);
        $order_data['goods_amount'] = bcmul($distribution_price, $q->goods_count, 2);
        $order_data['order_amount'] = bcadd($order_data['goods_amount'], $order_data['shipping_fee'], 2);
        $order_data['pay_amount'] = $order_data['order_amount'];
        $order_data['cost_price'] = bcadd(bcmul($goods_info['distribution_price'], $q->goods_count, 2), $order_data['shipping_fee'], 2);
        $order_data['shop_id'] = $q->platform;
        $order_data['supplier_id'] = $goods_info['supplier_id'];
        $order_data['qq'] = $user_info['qq'];
        $order_data['buyer_id'] = $q->user_id;
        $order_data['buyer_name'] = $q->user_name;
        $order_data['add_time'] = time();
        $order_data['order_state'] = 0;
        $order_data['other_shop'] = isset($q->other_shop) ? $q->other_shop : '';
        $order_data['other_order_sn'] = isset($q->other_order_sn) ? $q->other_order_sn : 0;
        return $order_data;
    }

    /**
     * 生成order_contact_data
     * @param type $q
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function create_order_contact_data($q) {
        $order_contact_data['contact_name'] = $q->contact_name;
        $order_contact_data['tel'] = $q->tel;
        $order_contact_data['province'] = $q->province;
        $order_contact_data['city'] = $q->city;
        $order_contact_data['dist'] = $q->dist;
        $order_contact_data['contact_address'] = $q->contact_address;
        $order_contact_data['addtime'] = time();
        return $order_contact_data;
    }

    /**
     * 查询订单商品（下单）
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function get_order_goods() {
        $q = $this->request;
        if (empty($q->user_id)) myerror(\StatusCode::msgCheckFail, '用户id不能为空！');
        if (empty($q->user_name)) myerror(\StatusCode::msgCheckFail, '用户姓名不能为空！');
        if (empty($q->goods_sku_id)) myerror(\StatusCode::msgCheckFail, '商品skuid不能为空！');
        if (!isset($q->select_num) || $q->select_num <= 0) myerror(\StatusCode::msgCheckFail, '选择商品数量必须大于0！');
        $_goods_sku_comb_dao = \Dao::Goods_sku_comb();
        $_goods_list_dao = \Dao::Goods_list();
        $_fx_distribute_user_dao = \Dao::Fx_distribute_user();
        $fields = "goods_id,sku_str_zh,stock_num";
        $goods_sku_info = $_goods_sku_comb_dao->get_goods_sku_info($q->goods_sku_id, $fields);
        $goods_info = $_goods_list_dao->get_goods_info($goods_sku_info['goods_id']);
        $goods_info = $goods_info[0];
        $_return_data['sku_str_zh'] = $goods_sku_info['sku_str_zh'];
        $_return_data['goods_name'] = $goods_info['goods_name'];
        $_return_data['img_path'] = $goods_info['img_path'];
        $user_info = $_fx_distribute_user_dao->get_user_info($q->user_id, $q->user_name);
        $_return_data['price'] = $goods_info['distribution_price'];
        if (0 == $user_info['leavel']) {
            myerror(\StatusCode::msgCheckFail, '请升级后再来购买！');
        }
        $_return_data['distribution_price'] = get_distribution_price($user_info['leavel'], $goods_info['distribution_price']);
        $_return_data['select_num'] = $q->select_num;
        $_return_data['stock_num'] = $goods_sku_info['stock_num'];
        $this->response = $_return_data;
        $this->response();
    }

    /**
     * 确认收货
     * @param int $_order_id 订单ID
     * @param string $_oder_sn 订单编号
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608121504
     */
    public function confirm_good() {
        //echo json_encode(array('order_id'=>1,'order_sn'=>"1160719035332928408"));exit;
        //{"order_id":1,"order_sn":"1160719035332928408"}
        if (empty($this->request->order_id)) myerror(\StatusCode::msgCheckFail, \Order::order_id_not_null);
        if (empty($this->request->order_sn)) myerror(\StatusCode::msgCheckFail, \Order::order_detail_order_sn);

        if (!\Dao::Order_list()->confirm_good($this->request->order_id, $this->request->order_sn)) myerror(\StatusCode::msgCheckFail, \Order::order_confirm_fail);
        $this->response(\Order::order_confirm_success);
    }

    /**
     * 订单付款
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function order_pay() {
        $q = $this->request;
        if (empty($q->user_id)) myerror(\StatusCode::msgCheckFail, '用户id不能为空！');
        if (empty($q->user_name)) myerror(\StatusCode::msgCheckFail, '用户名不能为空！');
        if (empty($q->order_id)) myerror(\StatusCode::msgCheckFail, '订单id不能为空！');
        if (empty($q->pay_account)) myerror(\StatusCode::msgCheckFail, '付款账户不能为空！');
        if (empty($q->receiver_account)) myerror(\StatusCode::msgCheckFail, '收款账户不能为空！');
        if (empty($q->pay_type)) myerror(\StatusCode::msgCheckFail, '支付方式不能为空！');
        if (empty($q->trade_no)) myerror(\StatusCode::msgCheckFail, '第三方流水号不能为空！');

        $_order_list_dao = \Dao::Order_list();
        $order_info = $_order_list_dao->get_order_info($q->order_id, 'order_sn,pay_amount,is_supplier_close,is_pay');
        if (!$order_info) {
            myerror(\StatusCode::msgCheckFail, '订单信息获取失败！');
        }
        if (1 == $order_info['is_pay']) {
            myerror(\StatusCode::msgCheckFail, '请不要重复付款！');
        }
        $_data['user_type'] = 2;
        $_data['user_id'] = $q->user_id;
        $_data['user_name'] = $q->user_name;
        $_data['source_id'] = $q->order_id;
        $_data['source_sn'] = $order_info['order_sn'];
        $_data['type'] = 1;
        $_data['status'] = 0;
        $_data['confirm_money'] = $order_info['pay_amount'];
        $_data['trade_no'] = $q->trade_no;
        $_data['pay_account'] = $q->pay_account;
        $_data['receiver_account'] = $q->receiver_account;
        $_data['pay_type'] = $q->pay_type;
        $_data['add_time'] = time();
        $_data['pay_time'] = time();
        $id = $_order_list_dao->order_pay($_data);
        $this->response['success'] = 0;
        $this->response['message'] = '付款失败！';
        if ($id) {
            $this->response['id'] = $id;
            $this->response['success'] = 0;
            $this->response['message'] = '付款成功！';
        }
        $this->response();
    }

    /**
     * 计算运费
     * @param type $goods_id
     * @param type $receiver_address
     * @return int
     */
    public function compute($goods_id, $receiver_address) {    //计算运费
        $dao = \Dao::Fx_freight_template();
        $r = $dao->getInfo($goods_id);
        if (!$r) return 0; //包邮
        $main = $r['main'];
        $sub = $r['sub'];
        $heavy = $main['heavy'];

        if (!$sub) {    //不存在特例 
            if ($main['is_free']) {
                $fee['freight'] = 0;
            } else {
                $fee['freight'] = $this->calculate($heavy, $main['start_heavy'], $main['start_freight'], $main['continue_heavy'], $main['continue_freight']);
            }
        } else {      //存在特例
            $have_computed = 0;
            foreach ($sub as $v) {       //查看是否落在特例中
                if ($v['area'] == $receiver_address) {
                    $fee['freight'] = $this->calculate($heavy, $v['start_heavy'], $v['start_freight'], $v['continue_heavy'], $v['continue_freight']);
                    $have_computed = 1;
                    break;
                }
            }
            if (!$have_computed) {     //没有在特例中
                if ($main['is_free']) {
                    $fee['freight'] = 0;
                } else {
                    $fee['freight'] = $this->calculate($heavy, $main['start_heavy'], $main['start_freight'], $main['continue_heavy'], $main['continue_freight']);
                }
            }
        }
        return $fee['freight'];
    }

    public function calculate($heavy, $s_heavy, $s_fee, $c_heavy, $c_fee) {
        $heavy = floatval($heavy);
        $s_heavy = floatval($s_heavy);
        $s_fee = floatval($s_fee);
        $c_heavy = floatval($c_heavy);
        $c_fee = floatval($c_fee);
        $rest = $heavy - $s_heavy;
        if ($rest <= 0) {    //在首重内
            return $s_fee;
        }
        $per = ceil($rest / $c_heavy);   //超出部分费用
        $sub_fee = $per * $c_fee;
        $total = $s_fee + $sub_fee;
        return floatval($total);
    }

}
