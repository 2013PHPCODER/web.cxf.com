<?php

/**
 * 虚拟订单
 */

namespace Orders\Controller;

class virtualOrdersController extends CommonController {

    function _initialize() {
        parent::_initialize();
    }

    /**
     * [index 虚拟订单列表 默认进入]
     * @return [type] [description]
     */
    public function index() {
        $this->datas = $this->getVirtualOrderList($this->searchWhere(), I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'fx_virtual_order.id desc');
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
        //待付款
        if (1 == I('get.group_id')) {
            $_where['fx_virtual_order.status'] = 1;
        }
        //已完成
        if (2 == I('get.group_id')) {
            $_where['fx_virtual_order.status'] = 2;
        }
        //已关闭
        if (3 == I('get.group_id')) {
            $_where['fx_virtual_order.status'] = 3;
        }
        //分销商名称
        if (I('get.buyer_name')) {
            $_where['fx_virtual_order.buyer_name'] = I('get.buyer_name');
        }
        //订单时间
        if (I('get.time_type') and ( I('get.startTime') or I('get.endTime') )) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime', 0) ? strtotime(I('get.endTime')) : time();
            $_where["fx_virtual_order." . I('get.time_type')] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //关键字
        if (I('get.search_word')) {
            $_where['fx_virtual_order.order_sn'] = I('get.search_word');
        }
        return $_where;
    }

    /**
     * [getOrderList 虚拟订单列表]
     * @param  string $mWhere [查询条件]
     * @param  string $mOrder [订单排序]
     * @return [Array]         [订单列表数组]
     */
    public function getVirtualOrderList($mWhere = '', $mOrder = '', $type = '') {
        $_fx_virtual_order = M('fx_virtual_order');
        $_count = $_fx_virtual_order->where($mWhere)->count('fx_virtual_order.id');
        $_page = getPage($_count);
        $fields = "fx_virtual_order.id,fx_virtual_order.order_sn,fx_virtual_order.price,fx_virtual_order.pay_money,fx_virtual_order.add_time,fx_virtual_order.payment_time,fx_virtual_order.status,"
                . "fx_virtual_order.distribute_user_id,fx_virtual_order.virtual_goods_id,fx_distribute_user.email,fx_distribute_user.mobile";
        $_fx_virtual_order->field($fields);
        $_data['list'] = $_fx_virtual_order->where($mWhere)->join("left join fx_distribute_user on fx_distribute_user.id=fx_virtual_order.distribute_user_id")->order($mOrder)->limit($_page->firstRow . ',' . $_page->listRows)->select();
        foreach ($_data['list'] as &$val) {
            $val['buyer_name'] = $val['email'] ? $val['email'] : $val['mobile'];
        }
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * [orderDetail 虚拟订单详情]
     * @return [type] [description]
     */
    public function orderDetail() {
        $_where['id'] = I('get.id');
        $_fx_virtual_order = M('fx_virtual_order');
        $fields = "id,order_sn,price,pay_money,add_time,payment_time,status,distribute_user_id,virtual_goods_id,buyer_name";
        $_fx_virtual_order->field($fields);
        $this->orderInfo = $_fx_virtual_order->where($_where)->find();
        //分销商信息
        $_distribute_user_id = $this->orderInfo['distribute_user_id'];
        $this->distribute = M('fx_distribute_user')->where("id={$_distribute_user_id}")->find();
        //商品信息
        $_goods_id = $this->orderInfo['virtual_goods_id'];
        $this->orderGoods = M('fx_virtual_goods')->where("id={$_goods_id}")->find();
        //订单日志
        $this->orderLog = M('log_list')->where(" cid=5 and pid = {$_where['id']} ")->order("id desc")->select();

        $this->show();
    }

}
