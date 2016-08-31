<?php

namespace Orders\Controller;

use Org\Util\YHttp;

class OrdersController extends CommonController {

    function _initialize() {
        parent::_initialize();
    }

    /**
     * [index 订单列表 默认进入]
     * @return [type] [description]
     */
    public function index() {
        if (1 == I('post.explode_orders/d')) {
            //导出
            $this->exportOrderExecl();
        }
        $this->goods_category = D('GoodsCategory')->goodsCategoryList();
        $this->depot = D('SystemDepot')->depotList();
        $this->shipping = D('SystemShipping')->system_shipping();
        $this->datas = D('Orders/OrderList')->getOrderList($this->searchWhere(), I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'order_list.order_id desc');
        $this->shop_ids = C('shop_id');
        $this->show();
    }

    /**
     * [searchWhere 组合条件查询]
     * @return Array [数组]
     */
    public function searchWhere() {
        //订单状态
        //待确认
        $_where = [];
        if (2 == I('get.group_id')) {
            $_where['order_state'] = 1;
        }
        //待发货	
        if (3 == I('get.group_id')) {
            $_where['order_state'] = 2;
        }

        //已发货
        if (4 == I('get.group_id')) {
            $_where['order_state'] = 3;
        }
        //已完成
        if (5 == I('get.group_id')) {
            $_where['order_state'] = 4;
        }
        //待付款
        if (6 == I('get.group_id')) {
            $_where['order_state'] = 0;
        }
        //异常订单
        if (7 == I('get.group_id')) {
            $_where['order_state'] = 6;
        }
        //已关闭
        if (8 == I('get.group_id')) {
            $_where['order_state'] = 5;
        }

        //查询条件
        //仓库名称
        if (I('get.depot')) {
            $_where['order_goods.depot_id'] = I('get.depot');
        }
        //商品类目
        if (I('get.goods_category')) {
            $_where['order_goods.top_category'] = I('get.goods_category', 0);
        }
        //分销商名称
        if (I('get.buyer_name')) {
            $_where['order_list.buyer_name'] = I('get.buyer_name');
        }
        //是否备注
        if (I('get.remark')) {
            $_where['memo'] = I('get.remark') == 1 ? array('EXP', " <> ''") : array('exp', " = ''");
        }
        //物流公司
        if (I('get.shipping_id')) {
            $_where['shipping_id'] = I('get.shipping_id');
        }
        //面单类型
        if (I('get.hub_type')) {
            $_where['hub_type'] = I('get.hub_type', 0);
        }
        //订单时间
        if (I('get.time_type') and ( I('get.startTime') or I('get.endTime') )) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime', 0) ? strtotime(I('get.endTime')) : time();
            $_where[I('get.time_type')] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //平台来源
        if (I('get.shop_id')) {
            $_where['shop_id'] = I('get.shop_id', 1);
        }
        //关键字
        if (I('get.order_search') and I('get.search_word')) {
            if (strtolower(I('get.order_search')) == 'goods_name') {
                $_where['order_goods.goods_name'] = array('LIKE', '%' . I('get.search_word') . '%');
            } elseif (strtolower(I('get.order_search')) == 'buyer_goods_no') {
                $_where['order_goods.buyer_goods_no'] = array('LIKE', '%' . I('get.search_word') . '%');
            } elseif (strtolower(I('get.order_search')) == 'goods_no') {
                $_where['order_goods.goods_no'] = I('get.search_word');
            } else {
                $_where[I('get.order_search')] = I('get.search_word');
            }
        }
        //不显示已关闭订单
        if (2 == I('get.is_close')) {
            $_where['order_state'] = array('neq', '5');
        }
        //排除已售后订单
        if (2 == I('get.is_cus')) {
            $_where['is_cus'] = array('neq', '1');
        }
        return $_where;
    }

    /**
     * [addRemark 添加标记]
     */
    public function addRemark() {
        layout(FALSE);
        if (I('post.order_id')) {
            $this->memo = M('order_list')->where('order_id =' . I('post.order_id'))->getField('memo');
            $str = $this->fetch(T('Public/order_assign'));
            echo $str;
            exit();
        }
    }

    /**
     * [updateRemark 更新标记信息]
     * @return [type] [description]
     */
    public function updateRemark() {
        try {
            $order = M('order_list');
            $order->memo = I('post.memo');
            $order->where('order_id = ' . I('post.order_id'))->save();
            $_result['message'] = 'ok';
        } catch (Exception $e) {
            $_result['message'] = $e->getMessage();
        }
        $this->ajaxReturn($_result);
    }

    /**
     * [excepOrder 订单异常]
     * @return [type] [description]
     */
    public function excepOrder() {
        if (0 == I('post.order_id', 0) and 0 == I('post.type', 0)) {
            $this->aReturn(0, '参数错误');
        }

        $cus_num = 0;
        $total = 0;
        $cship = 0;

        if (I('post.order_id')) {
            $order_id = I('post.order_id');
        }

        if (!is_array($order_id)) {
            $this->aReturn(0, '参数错误');
        }

        foreach ($order_id as $k => $v) {
            //是否售后中
            $_order = M('order_list')->where("order_id={$v} and is_cus = 1")->find();
            if (1 == count($_order)) {
                $cus_num++;
                continue;
            }
            //状态判断，是否是0＝待付款，1=已付款待确认
            if (false == in_array($_order['order_state'], array(0, 1))) {
                $total++;
                continue;
            }

            //更新订单为异常
            $order = M('order_list');
            $order->order_state = 6;
            $order->hub_type = 0;
            $order->con_time = 0;
            $order->send_hub_time = 0;
            $order->close_time = 0;
            $order->order_marked = 0;
            $order->shipping_code = '';
            $order->shipping_id = 0;
            $order->shipping_name = '';
            $order->is_send_hub = 0;
            $order->where('order_id =' . $v)->save();
            $_where['order_id'] = $v;
            //删除发货表数据
            M('hub_order')->where($_where)->delete();
            //删除发货商品数据
            M('hub_order_goods')->where($_where)->delete();
            //写日志
            $this->log('订单异常');
            $this->addLog(array("log_info" => "订单异常", "pid" => $v, "handle_info" => "订单异常,不能进行操作", "cid" => "1"));
        }
        $_message = "操作成功";
        if (0 != $total) $_message = "操作失败，有{$total}个订单不能表记异常,";
        if (0 != $cus_num) $_message = "操作失败，其中已跳过{$cus_num}条售后中的订单,";
        $this->aReturn(1, $_message);
    }

    /**
     * [orderDetail 订单详情]
     * @return [type] [description]
     */
    public function orderDetail() {
        $_order_id = I('get.order_id/d');
        $fields = "order_list.order_id,order_list.order_sn,order_list.add_time,order_list.shop_id,order_list.buyer_name,order_list.qq,order_list.is_cus,"
                . "order_list.memo,order_list.order_state,order_list.order_amount,order_list.shipping_fee,order_list.pay_amount,order_list.message_starts,shipping_code,"
                . "shipping_id,shipping_name,hub_type,payment_time,send_hub_time";
        $datas = M('order_list')->field($fields)->where("order_id = $_order_id")->find();
        //如果有留言，查询留言
        if ($datas['message_starts'] == 1) {
            $datas['order_message'] = M('order_message')->field("user_type,user_id,message,addtime")->where("order_id = $_order_id ")->select();
            foreach ($datas['order_message'] as $key => $value) {
                $value['addtime'] = date("Y-m-d H:i:s", $value['addtime']);
                $datas['order_message'][$key] = $value;
            }
        }
        //获取订单发货状态
        if ($datas['order_state'] == 2) {
            $datas['hub_order_state'] = M('hub_order')->where("order_id ={$_order_id}")->getField('ship_stats');
        }
        //查询快递公司
        if ($datas['order_state'] == 3 || $datas['order_state'] == 4 || $datas['hub_order_state'] > 1) {
            $this->ship_info = M('system_shipping')->field("shipping_id,shipping_name,shipping_code,reg_mail_no")->select();
        }
        //订单中商品的信息 ($datas['order_goods']);
        $datas['order_goods'] = M('order_goods')->where("order_id = $_order_id")->select();
        $datas['cus_order_num'] = M('cus_order_list')->where("order_id={$_order_id }")->count('order_id');
        $_cus_status = M('cus_order_list')->field("refund_status,return_status")->where("order_id={$_order_id }")->order('id desc')->find();
        $datas['refund_status'] = $_cus_status['refund_status'];
        $datas['return_status'] = $_cus_status['return_status'];
        foreach ($datas['order_goods'] as $kk => $vv) {
//            $goods_info = M('goods_list')->where("goods_id=" . $vv['goods_id'])->find();
            $vv['goods_img'] = $vv['img_path'];
            $vv['buyer_goods_on'] = $vv['buyer_goods_on'];
            //订单中商品的sku组合id ($vv['sku_comb_id']);
            $vv['sku_comb_id'] = M('order_goods_sku')->where("goods_id=" . $vv['goods_id'] . " and order_id = $_order_id")->getField('sku_comb_id');
            //订单中商品的价格
            if (!empty($vv['sku_comb_id'])) {
                $vv['distribution_price'] = $vv['distribution_price'];
                $vv['goods_price_total'] = bcmul($vv['distribution_price'], $vv['goods_num'], 2);
                $vv['sku_str'] = M('goods_sku_comb')->where("id=" . $vv['sku_comb_id'])->getField('sku_str_zh');
            }
            $datas['goods_num_total'] = bcadd($vv['goods_num'], $datas['goods_num_total'], 2);
            $datas['order_goods'][$kk] = $vv;
        }
        //订单的价格
        $datas['order_price'] = $datas['order_price'];
        $datas['order_price_total'] = bcadd($datas['shipping_fee'], $datas['order_price'], 2);
        /* 获取最新的2条收货人信息 */
        $datas['concat_address'] = M('order_contact')->where("order_id=" . $datas['order_id'])->order('id desc')->limit(2)->select();
        /* 取最新一条收货人信息 */
        $address = $datas['concat_address'][0];
        $this->assign('datas', $datas);
        $this->assign('address', $address);
        //订单日志
        $orderLog = M('log_list')->where(" cid=1 and pid = $_order_id ")->order("id desc")->select();
        $this->assign('orderLog', $orderLog);
        //获取地区
        $province = M('area_list')->where("parent_id=1")->select();
        foreach ($province as $key => $value) {
            if ($value['area_name'] == $address['province']) {
                $citys = M('area_list')->where("parent_id = " . $value['id'])->select();
                foreach ($citys as $k => $v) {
                    if ($v['area_name'] == $address['city']) {
                        $dists = M('area_list')->where("parent_id = " . $v['id'])->select();
                    }
                }
            }
        }
        $this->assign('dists', $dists);
        $this->assign('citys', $citys);
        $this->assign('province', $province);
        $this->assign('shop_ids', C('shop_id'));
        $this->show();
    }

    /**
     * 获取所有地址列表
     */
    public function area_list() {
        if (I('get.id') > 0) $id = I('get.id');
        $area = M('area_list')->where(" parent_id = $id ")->select();
        echo json_encode($area);
    }

    /**
     * 修改地址
     */
    public function editAddress() {
        layout(FALSE);
        $data['order_id'] = I('post.order_id');
        $data['tel'] = I('post.tel');
        $data['contact_name'] = I('post.contact_name');
        $data['province'] = I('post.province');
        $data['city'] = I('post.city');
        $data['dist'] = I('post.dist');
        $data['contact_address'] = I('post.contact_address');
        if (empty($data['contact_address']) || strlen($data['contact_address']) < 12) {
            $result['status'] = 0;
            $result['msg'] = "收货人详细地址不能为空或少于4个字";
            echo json_encode($result);
            return;
        }
        $data['province'] = M('area_list')->where("id = " . $data['province'])->getField('area_name');
        $data['city'] = M('area_list')->where("id = " . $data['city'])->getField('area_name');
        $data['dist'] = M('area_list')->where("id = " . $data['dist'])->getField('area_name');
        $data['zip_code'] = I('post.zip_code');
        $data['addtime'] = time();
        $is_edit_address = M('order_list')->where("order_id=" . $data['order_id'])->find();
        if ($is_edit_address['is_edit_address'] != 1) {
            $updata['is_edit_address'] = 1;
            $updata['receiver_name'] = $data['contact_name'];
            $updata['receiver_tel'] = $data['tel'];
            if (M('order_contact')->add($data) && M('order_list')->where("order_id=" . $data['order_id'])->save($updata)) {
                if ($is_edit_address['order_state'] > 1) {
                    $hub_data = array('receiver_name' => $data['contact_name'], 'receiver_tel' => $data['tel']);
                    M('hub_order')->where("order_id=" . $data['order_id'])->setField($hub_data);
                }
                $this->addLog(array("log_info" => "修改收件人信息", "pid" => I('post.order_id'), "handle_info" => "修改收件人信息", "cid" => "1"));
                $result['status'] = 1;
                $result['msg'] = "收货人信息修改成功";
            } else {
                $result['status'] = 0;
                $result['msg'] = "修改失败";
            }
        } else {
            if ($is_edit_address['receiver_name'] != $data['contact_name']) {
                $updata['receiver_name'] = $data['contact_name'];
            }
            if ($is_edit_address['receiver_tel'] != $data['tel']) {
                $updata['receiver_tel'] = $data['tel'];
            }
            if ($is_edit_address['receiver_name'] != $data['contact_name'] || $is_edit_address['receiver_tel'] != $data['tel']) {
                M('order_list')->where("order_id=" . $data['order_id'])->save($updata);
            }
            if (M('order_contact')->add($data)) {
                $this->addLog(array("log_info" => "修改收货人信息", "pid" => I('post.order_id'), "handle_info" => "修改收货人信息", "cid" => "1"));
                $result['status'] = 1;
                $result['msg'] = "收货人信息修改成功";
            } else {
                $result['status'] = 0;
                $result['msg'] = "修改失败";
            }
        }
        echo json_encode($result);
    }

    /**
     * [cancelOrder 订单取消]
     * @return [type] [description]
     */
    public function cancelOrder() {
        $cus_num = 0;
        if (I('post.order_id') || I('post.type')) {
            if (I('post.order_id')) {
                $order_id = I('post.order_id');
            }
            $total = 0;
            foreach ($order_id as $k => $v) {
                $order = M('order_list');
                $order_state = $order->where('order_id = ' . $v)->getField('order_state');
                $is_cus = $order->where('order_id = ' . $v)->getField('is_cus');

                if ($is_cus == 1) {
                    $cus_num++;
                    $total++;
                    continue;
                }
                if (0 != $order_state) {
                    $total++;
                } else {
                    //增加库存
                    if ($this->decGoodsStock($v)) {
                        //更改订单状态
                        $order->order_state = 5;
                        $order->is_supplier_close = 1;
                        $order->close_time = time();
                        $order->where('order_id =' . $v)->save();
                        $this->addLog(array("log_info" => "取消订单", "handle_info" => "操作", "cid" => 1, "pid" => $v));
                    }
                }
            }
            if (0 != $total) {
                $data['status'] = $total;
                $data['message'] = "订单取消操作完成，其中有" . $total . "订单取消操作未成功";
            } else {
                $data['status'] = 'ok';
                if ($cus_num > 0) {
                    $data['content'] = "操作成功，其中已跳过" . $cus_num . "条售后中的订单";
                } else {
                    $data['content'] = "操作成功";
                }
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * [getMessage 获取留言信息]
     * @return [type] [description]
     */
    public function Message() {
        layout(FALSE);
        if (I('post.order_id')) {
            $this->result = M('order_message')->where('order_id = ' . I('post.order_id'))
                            ->field('addtime,user_type,message,order_id,to_user_type')->order('addtime')->select();
            $this->order_id = I('post.order_id');
            $str = $this->fetch(T('Public/order_message'));
            echo $str;
        }
    }

    /**
     * [saveMessage 保存留言]
     * @return [type] [description]
     */
    public function saveMessage() {
        if (I('post.')) {
            $message = M('order_message');
            $message->order_id = I('post.order_id');
            $message->user_type = 2;
            $message->to_user_type = I('post.to_user_type');
            $message->user_id = $_SESSION['user']['id'];
            $message->message = I('post.val');
            $message->addtime = time();
            $total = $message->add();
            if ($total == 0) {
                $_result['status'] = "fail";
            } else {
                $_result['status'] = "success";
                $_result['time'] = date("Y-m-d H:m:s", time());
            }
            $this->ajaxReturn($_result);
        }
    }

    /**
     * [confirmOrder 订单确认]
     * @return [type] [description]
     */
    public function confirmOrder() {
        if (I('post.order_id') || I('post.type')) {
            if (I('post.type')) {
                $order_list = $this->getOrderList($this->searchWhere(), I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'order_list.order_id asc', 'all');
                $order_id = $order_list['list'];
            }
            if (I('post.order_id')) {
                $order_id = I('post.order_id');
            }
            $total = 0;
            $cus_num = 0;
            foreach ($order_id as $k => $v) {
                if (1 == M('order_list')->where("order_id = {$v} and is_cus = 1")->count()) {
                    $cus_num++;
                    $total++;
                    continue;
                }
                $order = M('order_list');
                $order->join('order_goods ON order_goods.order_id = order_list.order_id');
                $order_state = $order->where('order_list.order_id = ' . $v)->find();
                if (1 != $order_state['order_state']) {
                    $total++;
                } else {
                    if (M('hub_order')->where("order_id={$order_state['order_id']}")->count()) {
                        continue;
                    }
                    $_cus_order['order_id'] = $order_state['order_id'];
                    $_cus_order['order_sn'] = $order_state['order_sn'];
                    $_cus_order['buyer_id'] = $order_state['buyer_id'];
                    $_cus_order['buyer_name'] = $order_state['buyer_name'];
                    $_cus_order['ship_stats'] = 0;
                    $_cus_order['hub_type'] = $order_state['hub_type'];
                    $_cus_order['memo'] = $order_state['memo'];
                    $_cus_order['order_time'] = $order_state['add_time'];
                    $_cus_order['receiver_name'] = $order_state['receiver_name'];
                    $_cus_order['receiver_tel'] = $order_state['receiver_tel'];
                    $_cus_order['shop_id'] = $order_state['shop_id'];
                    $_cus_order['category_id'] = $order_state['category_id'];
                    $_cus_order['buyer_goods_no'] = $order_state['buyer_goods_no'];
                    $_cus_order['depot_id'] = $order_state['depot_id'];
                    $_cus_order['shipping_fee'] = $order_state['shipping_fee'];
                    $_cus_order['con_time'] = time();
                    $_cus_order['addtime'] = time();
                    $_cus_order_id = M('hub_order')->add($_cus_order);
                    if ($_cus_order_id) {
                        $_cus_goods['hub_id'] = $_cus_order_id;
                        $_cus_goods['sku_comb_id'] = M('order_goods_sku')->where('order_id = ' . $v)->getField('sku_comb_id');
                        $_cus_goods['order_id'] = $order_state['order_id'];
                        $_cus_goods['goods_id'] = $order_state['goods_id'];
                        $_cus_goods['goods_name'] = $order_state['goods_name'];
                        $_cus_goods['category_parent'] = $order_state['category_id'];
                        $_cus_goods['goods_num'] = $order_state['goods_num'];
                        $_cus_goods['addtime'] = time();
                        $_cus_goods_id = M('hub_order_goods')->add($_cus_goods);
                    }
                    if ($_cus_order_id && $_cus_goods_id) {
                        $order->order_state = 2;
                        $order->con_time = time();
                        $order->where('order_id =' . $v)->save();
                        $this->log('订单已确认');
                        $this->addLog(array("log_info" => "订单已确认", "pid" => $order_state['order_id'], "handle_info" => "订单确认,进入待发货", "cid" => "1"));
                    } else {
                        if ($_cus_goods_id) {
                            M('hub_order')->where('order_id =' . $order_state['order_id'])->delete();
                        }
                        $total++;
                    }
                }
            }
            $data['status'] = 'ok';
            $data['total'] = $total;
            if ($cus_num > 0) {
                $data['content'] = "操作成功，其中已跳过" . $cus_num . "条售后中的订单";
            } else {
                $data['content'] = "操作成功";
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * [dealOrder 异常订单处理]
     * @return [type] [description]
     */
    public function dealOrder() {
        if (I('post.order_id') || I('post.type')) {
            if (I('post.type')) {
                $order_list = $this->getOrderList($this->searchWhere(), I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'order_list.order_id asc', 'all');
                $order_id = $order_list['list'];
            }
            if (I('post.order_id')) {
                $order_id = I('post.order_id');
            }
            $total = 0;
            foreach ($order_id as $k => $v) {
                if (1 == M('order_list')->where("order_id={$v} and is_cus = 1")->count()) {
                    $cus_num++;
                    $total++;
                    continue;
                }
                $order = M('order_list');
                $order_state = $order->where('order_id = ' . $v)->getField('order_state');
                if (6 != $order_state) {
                    $total++;
                } else {
                    $order->order_state = 1;
                    $order->where('order_id =' . $v)->save();
                    $this->addLog(array("log_info" => "异常订单处理", "handle_info" => "处理异常订单,订单进入待确认", "cid" => 1, "pid" => $v));
                }
            }
            if (0 != $total) {
                $data['status'] = $total;
                $data['message'] = "有" . $total . "订单不能确认";
            } else {
                $data['status'] = 'ok';
                if ($cus_num > 0) {
                    $data['message'] = "操作成功，其中已跳过" . $cus_num . "条售后中的订单";
                } else {
                    $data['message'] = "操作成功";
                }
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * [orderManger 售后管理]
     * @return [type] [description]
     */
    public function orderManger() {
        $this->depot = M('system_depot')->field('id,depot_name')->select();
        $datas = $this->getCusList($this->cusOrderSearch(), I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'cus_order_list.id desc');
        //var_dump($this->cusOrderSearch());
        //echo M('cus_order_list')->getLastSql();
//        foreach ($datas['list'] as $key => $value) {
//        	$value['order_sn'] = M('order_list')->where("order_id=".$value['order_id'])->getField('order_sn');
//        	$datas['list'][$key] = $value;
//        }
        $this->assign('datas', $datas);
        $this->show();
    }

    /**
     * 获取订单的物流公司信息
     */
    public function getShippingName($shipping_id) {
        return M('system_shipping')->where("shipping_id = $shipping_id")->find();
    }

    /**
     * 修改物流信息
     */
    public function edit_shipping() {
        $data = I('post.');
        if (!empty($data['order_id'])) {
            $order_info = M('order_list')->where("order_id=" . $data['order_id'])->find();
            $ship_info = $this->getShippingName($data['shipping_id']);
            $update['shipping_code'] = $up_hub_order['shipping_code'] = $data['shipping_code'];
            $update['shipping_name'] = $up_hub_order['shipping_name'] = $ship_info['shipping_name'];
            $update['shipping_id'] = $ship_info['shipping_id'];
            $up_hub_order['shipping_no'] = M('system_shipping')->where("shipping_id=" . $ship_info['shipping_id'])->getField('shipping_code');
            if ($order_info['shipping_id'] == $data['shipping_id'] && $order_info['shipping_code'] == $data['shipping_code']) {
                $result['status'] = 0;
                $result['msg'] = "物流信息没有任何修改内容";
            } else {
                if (M('order_list')->where("order_id=" . $data['order_id'])->save($update) && M('hub_order')->where("order_id = " . $data['order_id'])->save($up_hub_order)) {
                    $this->addLog(array("log_info" => "修改物流信息", "pid" => $data['order_id'], "handle_info" => "修改物流信息", "cid" => "1"));
                    $result['status'] = 1;
                    $result['msg'] = "物流信息修改成功";
                } else {
                    $result['status'] = 0;
                    $result['msg'] = "物流信息修改失败";
                }
            }
        } else {
            $result['status'] = 0;
            $result['msg'] = "未获取到订单信息";
        }
        echo json_encode($result);
    }

    /**
     * [getOrderLog 获取订单操作日志]
     * @param  string $mWhere [查询条件]
     * @param  string $mOrder [排序方式]
     * @return Array         
     */
    public function getOrderLog($mWhere = '', $mOrder = '') {
        $_log_list = M('log_list')->where($mWhere)->order($mOrder)->select();
        return $_log_list;
    }

    /**
     * [getBuyerInfo 获取分销商信息]
     * @return [type] [description]
     */
    public function getBuyerInfo() {
        if (I('post.cus_order_id')) {
            $cus_order_list = M('cus_order_list')->where('cus_order_list.id =' . I('post.cus_order_id'))
                            ->field('*,cus_order_list.id as cus_order_id')->select();
            $this->ajaxReturn($cus_order_list[0]);
        }
    }

    /**
     * [getRefundAmount 获取退款金额]
     * @return [type] [description]
     */
    public function getRefundAmount() {
        if (I('post.cus_order_id')) {
            $_order_id = M('cus_order_list')->where('id =' . I('post.cus_order_id'))->getField('order_id');
            if (!$_order_id) {
                $_data['status'] = 'error';
                $_data['content'] = '参数错误';
                $this->aReturn($_data);
            }
            $data['pay_amount'] = M('order_list')->where('order_id =' . $_order_id)->getField('pay_amount');
            $data['refund_amount'] = M('cus_order_list')->where('id =' . I('post.cus_order_id'))->getField('refund_amount');
            $this->aReturn(1, "ok", $data);
        }
    }

    /**
     * exportOrderExecl 导出订单电子表格
     * @return [type] [description]
     */
    public function exportOrderExecl() {
        $xlsCell = array(
            array('order_sn', '订单号'),
            array('add_time', '下单时间'),
            array('shop_name', '来源'),
            array('buyer_name', '分销商'),
            array('goods_id', '商品ID'),
            array('qq', 'QQ'),
            array('is_cus', '是否售后'),
            array('goods_name', '商品名称'),
            array('buyer_goods_no', '商品编号'),
            array('sku', 'sku'),
            array('goods_price', '单价'),
            array('goods_num', '数量'),
            array('order_amount', '总价'),
            array('shipping_fee', '运费'),
            array('contact_name', '收件人'),
            array('tel', '联系方式'),
            array('concat_address', '收件地址'),
//            array('concat','收货地址'),
            array('order_state', '订单状态'),
            array('memo', '备注'),
        );
        $order_ids = I('post.export_order_id');
        if (empty($order_ids)) {
            //没有订单id，返回失败
            echo '没有订单id';
            exit;
        }
        $ids = trim($order_ids, ',');
        $this->pagesize = 100000;
        $sql = 'SELECT ol.order_id,og.goods_id,ol.order_sn,ol.add_time,ol.shop_id,ol.buyer_name,ol.qq,ol.is_cus,og.goods_name,
                og.buyer_goods_no,ogs.sku_comb_id,ol.memo,og.goods_num,
                ol.goods_amount,ol.order_amount,ol.shipping_fee,oc.*,
                ol.order_state,og.distribution_price as `price`
                 FROM order_list as `ol`, order_goods as `og`,
                order_goods_sku as `ogs`,order_contact as `oc` 
                 WHERE `ol`.order_id=`og`.order_id 
                and `ol`.order_id=`ogs`.order_id 
                and `ol`.order_id=`oc`.order_id 
                and `ol`.order_id in (' . $ids . ')';
        $data = D()->query($sql);
        foreach ($data as $key => $val) {
            $_data[$key]['order_sn'] = $val['order_sn'];
            $_data[$key]['goods_id'] = $val['goods_id'];
            $_data[$key]['add_time'] = date('Y-m-d H:i:s', $val['add_time']);
            $_data[$key]['shop_name'] = $val['shop_name'];
            $_data[$key]['buyer_name'] = $val['buyer_name'];
            $_data[$key]['qq'] = $val['qq'];
            switch ($val['shop_id']) {
                case 1:
                    $_data[$key]['shop_name'] = "星密码";
                    break;
                case 1:
                    $_data[$key]['shop_name'] = "创想范";
                    break;
            }
            $_data[$key]['is_cus'] = $val['is_cus'] == 1 ? '是' : '否';
            $_data[$key]['goods_name'] = $val['goods_name'];
            $_data[$key]['buyer_goods_no'] = $val['buyer_goods_no'];
            $_data[$key]['sku'] = D('OrderGoodsSku')->getOrderGoodsSku($val['goods_id'], $val['order_id']);
            $_data[$key]['goods_price'] = $val['price'];
            $_data[$key]['goods_num'] = $val['goods_num'];
            $_data[$key]['order_amount'] = $val['order_amount'];
            $_data[$key]['shipping_fee'] = $val['shipping_fee'];
            $_data[$key]['contact_name'] = $val['contact_name'];
            $_data[$key]['tel'] = $val['tel'];
            $_data[$key]['concat_address'] = $val['province'] . $val['city'] . $val['dist'] . $val['contact_address'];
            switch ($val['order_state']) {
                case 0:
                    $order_state = '待付款';
                    break;
                case 1:
                    $order_state = '待确认';
                    break;
                case 2:
                    $order_state = '待发货';
                    break;
                case 3:
                    $order_state = '已发货';
                    break;
                case 4:
                    $order_state = '已完成';
                    break;
                case 5:
                    $order_state = '已关闭';
                    break;
                case 6:
                    $order_state = '异常订单';
                    break;
                default :
                    $order_state = '未知';
                    break;
            }
            $_data[$key]['order_state'] = $order_state;
            $_data[$key]['memo'] = $val['memo'];
        }
        $this->exportExcel('订单表', $xlsCell, $_data);
        exit;
    }

}
