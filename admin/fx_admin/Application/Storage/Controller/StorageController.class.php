<?php
namespace Storage\Controller;
use Common\Controller\AuthController;
use Org\Util\YHttp;
class StorageController extends AuthController{
    function _initialize(){
        parent::_initialize();
    }
    
    /**
     * [slist 仓储设置(供应商仓库列表) ]
     * @param string $search_sname 仓库名称
     * @param string $search_functionary 仓库负责人
     * @param string $_search_mobile 仓库联系人手机
     * @param string $_search_freight 运费模板ID
     * @param int $_uid 供应商ID值
     * @return array 返回条件的供应商仓库数据
     * @author san shui <2881501985@qq.com>
     */
    public function slist(){
        $_uid = $_SESSION['user_info']['id'];
        $_search_sname = I('get.search_sname');
        if(!empty($_search_sname)){
             $_where['sname'] = array('like',"%{$_search_sname}%");
        }
        $_search_functionary = I('get.search_functionary');
        if(!empty($_search_functionary)){
             $_where['functionary'] = array('like',"%{$_search_functionary}%");
        }
        $_search_mobile = I('get.search_mobile');
        if(!empty($_search_mobile)){
             $_where['mobile'] = array('like',"%{$_search_mobile}%");
        }
        $_search_freight = I('get.search_freight');
        if(!empty($_search_freight)){
            $_freight_arr = M('fx_freight_template')
                    ->where(array('name'=>array('like',"%{$_search_freight}%")))
                    ->field('freight_template_id')
                    ->select();
            foreach ($_freight_arr as $key=>$value){
                if($key == count($_freight_arr) - 1){
                    $_tmp_str .= $value['freight_template_id'];
                }else{
                    $_tmp_str .= $value['freight_template_id'].',';
                }
            }
            $_where['freight'] = array('in',"$_tmp_str");
        }
         $_fx_storage_list_model = M('fx_storage_list');
        $_count = $_fx_storage_list_model->where($_where)->count();
        $_page = getpage($_count);
        $this->pager = $_page->show();
        $this->datas = $_fx_storage_list_model->where($_where)->field('id,sname,functionary,mobile,freight,address,supplier_user_id')
                ->limit($_page->firstRow . ',' . $_page->listRows)->order('id DESC')->select();
        $this->freight_template = M('fx_freight_template')->where(array('supplier_user_id'=>$_uid))->field('freight_template_id,name')->select();
        $this->display();
    }
    /**
     * [index 订单列表 默认进入]
     * @return [type] [description]
     */
    public function index(){
        $this->datas = $this->getOrderList($this->searchWhere(),I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'hub_order.id desc');
        $this->depot = $this->depotList();
        $this->shipping = $this->system_shipping();
        $this->goods_category = $this->goodsCategoryList();
        $this->show();
    }

    /**
     * [searchWhere 组合条件查询]
     * @return Array [数组]
     */
//    public function searchWhere(){
//        //订单状态
//        //待确认
//        if(2 == I('get.group_id')){
//            $_where['order_state'] = 1;
//        }
//        //待发货	
//        if(3 == I('get.group_id')){
//            $_where['order_state'] = 2;
//        }
//
//        //已发货
//        if(4 == I('get.group_id')){
//            $_where['order_state'] = 3;
//        }
//        //已完成
//        if(5 == I('get.group_id')){
//            $_where['order_state'] = 4;
//        }
//        //待付款
//        if(6 == I('get.group_id')){
//            $_where['order_state'] = 0;
//        }
//        //异常订单
//        if(7 == I('get.group_id')){
//            $_where['order_state'] = 6;
//        }
//        //已关闭
//        if(8 == I('get.group_id')){
//            $_where['order_state'] = 5;
//        }
//
//        //查询条件
//        //仓库名称
//        if(I('get.depot')){
//            $_where['order_goods.depot_id'] = I('get.depot');
//        }
////        //商品类目
////        if(I('get.goods_category')){
////            $_where['goods_list.category_parent'] = I('get.goods_category',0);
////        }
//        //分销商名称
//        if(I('get.buyer_name')){
//            $_where['order_list.buyer_name'] = I('get.buyer_name');
//        }
//        //是否备注
//        if(I('get.remark')){
//            $_where['memo'] = I('get.remark') == 1 ? array('EXP'," <> ''") : array('exp'," = ''");
//        }
//        //物流公司
//        if(I('get.shipping_id')){
//            $_where['shipping_id'] = I('get.shipping_id');
//        }
//        //面单类型
//        if(I('get.hub_type')){
//            $_where['hub_type'] = I('get.hub_type',0);
//        }
//        //订单时间
//        if(I('get.time_type') and ( I('get.startTime') or I('get.endTime') )){
//            $_startTime = I('get.startTime',0) ? strtotime(I('get.startTime')) : 1;
//            $_endTime = I('get.endTime',0) ? strtotime(I('get.endTime')) : time();
//            $_where[I('get.time_type')] = array('BETWEEN',array($_startTime,$_endTime));
//        }
//        //平台来源
//        if(I('get.shop_id')){
//            $_where['shop_id'] = I('get.shop_id',1);
//        }
//        //关键字
//        if(I('get.order_search') and I('get.search_word')){
//            if(strtolower(I('get.order_search')) == 'goods_name'){
//                $_where['goods_list.goods_name'] = array('LIKE','%' . I('get.search_word') . '%');
//            }elseif(strtolower(I('get.order_search')) == 'buyer_goods_no'){
//                $_where['goods_list.buyer_goods_no'] = array('LIKE','%' . I('get.search_word') . '%');
//            }elseif(strtolower(I('get.order_search')) == 'goods_no'){
//                $_where['order_goods.goods_no'] = I('get.search_word');
//            }else{
//                $_where[I('get.order_search')] = I('get.search_word');
//            }
//        }
//        //不显示已关闭订单
//        if(2 == I('get.is_close')){
//            $_where['order_state'] = array('neq','5');
//        }
//        //排除已售后订单
//        if(2 == I('get.is_cus')){
//            $_where['is_cus'] = array('neq','1');
//        }
//        return $_where;
//    }
    /*
     * [searchWhere 发货管理组合搜索条件]
     * @return Array [数组]
     */

    public function searchWhere(){
        //发货状态
        //待配货
        if(2 == I('get.group_id')){
            $_where['ship_stats'] = 0;
        }
        //待分配
        if(3 == I('get.group_id')){
            $_where['ship_stats'] = 1;
        }
        //待发货
        if(4 == I('get.group_id')){
            $_where['ship_stats'] = 2;
        }
        //已完成
        if(5 == I('get.group_id')){
            $_where['ship_stats'] = 3;
        }

        //组合搜索条件
        //仓库名称
        if(I('get.depot')){
            $_where['hub_order.depot_id'] = I('get.depot',0);
        }
        //分销商
        if(I('get.buyer_id')){
            $_where['hub_order.buyer_name'] = I('get.buyer_id');
        }
        //是否备注
        if(I('get.remark')){
            $_where['order_list.memo'] = I('get.remark') == 1 ? array('EXP'," <> ''") : array('exp'," = ''");
        }
        //物流公司
        if(I('get.shipping_id')){
            $_where['shipping_no'] = I('get.shipping_id');
        }
        //面单类型
        if(I('get.hub_type')){
            $_where['hub_order.hub_type'] = I('get.hub_type',0);
        }

        //订单时间 发货管理
        if(I('get.time_type') and ( I('get.startTime') or I('get.endTime') )){
            $_startTime = I('get.startTime',0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime',0) ? strtotime(I('get.endTime')) : time();
            $_where['hub_order.'.I('get.time_type')] = array('BETWEEN',array($_startTime,$_endTime));
        }
        //平台来源
        if(I('get.shop_id')){
            $_where['hub_order.'.'shop_id'] = I('get.shop_id',1);
        }
        //关键字
        if(I('get.hub_search') and I('get.search_word')){
//            if('goods_list.goods_name' == I('get.hub_search') or 'goods_list.buyer_goods_no' == I('get.hub_search')){
//                $_where[I('get.hub_search')] = array('like','%' . I('get.search_word') . '%');
//            }else{
//                $_where[I('get.hub_search')] = I('get.search_word');
//            }
            $_where[I('get.hub_search')] = array('like','%' . I('get.search_word') . '%');
        }
        //是否打印配货单
        if(I('get.is_print')){
            $status = I('get.is_print');
            if($status == 2){
                $status = 0;
            }
            $_where['is_print'] = $status;
        }
        //是否打印物流单
        if(I('get.shipping_is_print')){
            $status = I('get.shipping_is_print');
            if($status == 2){
                $status = 0;
            }
            $_where['shipping_is_print'] = $status;
        }
        return $_where;
    }

    /**
     * [cancelOrder 订单取消]
     * @return [type] [description]
     */
    public function cancelOrder(){
        if(I('post.order_id') || I('post.type')){
            if(I('post.type')){

                $order_list = $this->getOrderList($this->searchWhere(),I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'order_list.order_id asc','all');
                $order_id = $order_list['list'];
            }
            if(I('post.order_id')){
                $order_id = I('post.order_id');
            }
            $total = 0;
            foreach($order_id as $k=> $v){
                $order = M('order_list');
                $order_state = $order->where('order_id = ' . $v)->getField('order_state');
                $is_cus = $order->where('order_id = ' . $v)->getField('is_cus');
                if($is_cus == 1){
                    $cus_num++;
                    $total++;
                    continue;
                }
                if(0 != $order_state){
                    $total++;
                }else{
                    //增加库存
                    if($this->decGoodsStock($v)){
                        //更改订单状态
                        $order->order_state = 5;
                        $order->close_time = time();
                        $order->where('order_id =' . $v)->save();
                        $this->addLog(array("log_info"=>"取消订单","handle_info"=>"操作","cid"=>1,"pid"=>$v));
                    }
                }
            }
            if(0 != $total){
                $data['status'] = $total;
                $data['content'] = "订单取消操作完成，其中有" . $total . "订单取消操作未成功";
            }else{

                $data['status'] = 'ok';
                if($cus_num > 0){
                    $data['content'] = "操作成功，其中已跳过" . $cus_num . "条售后中的订单";
                }else{
                    $data['content'] = "操作成功";
                }
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * [confirmOrder 订单确认]
     * @return [type] [description]
     */
    public function confirmOrder(){
        if(I('post.order_id') || I('post.type')){
            if(I('post.type')){
                $order_list = $this->getOrderList($this->searchWhere(),I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'order_list.order_id asc','all');
                $order_id = $order_list['list'];
            }
            if(I('post.order_id')){
                $order_id = I('post.order_id');
            }
            $total = 0;
            $cus_num = 0;
            foreach($order_id as $k=> $v){
                if(1 == M('order_list')->where("order_id = {$v} and is_cus = 1")->count()){
                    $cus_num++;
                    $total++;
                    continue;
                }
                $order = M('order_list');
                $order->join('order_goods ON order_goods.order_id = order_list.order_id');
                $order_state = $order->where('order_list.order_id = ' . $v)->find();
                if(1 != $order_state['order_state']){
                    $total++;
                }else{
                    if(M('hub_order')->where("order_id={$order_state['order_id']}")->count()){
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
                    if($_cus_order_id){
                        $_cus_goods['hub_id'] = $_cus_order_id;
                        $_cus_goods['sku_comb_id'] = M('order_goods_sku')->where('order_id = ' . $v)->getField('sku_comb_id');
                        $_cus_goods['order_id'] = $order_state['order_id'];
                        $_cus_goods['goods_id'] = $order_state['goods_id'];
                        $_cus_goods['goods_name'] = $order_state['goods_name'];
                       // $_cus_goods['category_parent'] = $order_state['category_id'];
                        $_cus_goods['goods_num'] = $order_state['goods_num'];
                        $_cus_goods['addtime'] = time();
                        $_cus_goods_id = M('hub_order_goods')->add($_cus_goods);
                    }
                    if($_cus_order_id and $_cus_goods_id){
                        $order->order_state = 2;
                        $order->con_time = time();
                        $order->where('order_id =' . $v)->save();
                        $this->addLog(array("log_info"=>"订单已确认","pid"=>$order_state['order_id'],"handle_info"=>"订单确认,进入待发货","cid"=>"1"));
                    }else{
                        if($_cus_goods_id){
                            M('hub_order')->where('order_id =' . $order_state['order_id'])->delete();
                        }
                        $total++;
                    }
                }
            }
            $data['status'] = 'ok';
            $data['total'] = $total;
            if($cus_num > 0){
                $data['content'] = "操作成功，其中已跳过" . $cus_num . "条售后中的订单";
            }else{
                $data['content'] = "操作成功";
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * [excepOrder 订单异常]
     * @return [type] [description]
     */
    public function excepOrder(){
        if(0 == I('post.order_id',0) and 0 == I('post.type',0)){
            $this->aReturn(0,'参数错误');
        }

        $cus_num = 0;
        $total = 0;
        $cship = 0;

        if(I('post.type')){
            $order_list = $this->getOrderList($this->searchWhere(),I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'order_list.order_id asc','all');
            $order_id = $order_list['list'];
        }

        if(I('post.order_id')){
            $order_id = I('post.order_id');
        }

        if(!is_array($order_id)){
            $this->aReturn(0,'参数错误');
        }

        foreach($order_id as $k=> $v){
            if(1 == M('order_list')->where("order_id={$v} and is_cus = 1")->count()){
                $cus_num++;
                continue;
            }
            $_where['order_id'] = $v;
            $_order = M('order_list')->where($_where)->find();
            if(false == in_array($_order['order_state'],array(1,2))){
                $total++;
                continue;
            }

            if(2 == $_order['hub_type'] && '' != $_order['shipping_code']){
                //检测是否有运单号，如果有测取消运单号
                $_hub_order = $this->getHubOrder($v);
                $_ship_info_array = array(
                    'order_sn'=>$_hub_order['order_sn'],
                    'shipping_no'=>$_hub_order['shipping_no'],
                    'shipping_code'=>$_hub_order['shipping_code']
                );
                $_cancel_state = $this->wlbWaybillICancelRequest($_ship_info_array);
                if(!isset($_cancel_state->cancel_result)){
                    $cship++;
                    continue;
                }
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

            //删除发货表数据
            M('hub_order')->where($_where)->delete();
            //删除发货商品数据
            M('hub_order_goods')->where($_where)->delete();
            //写日志
            $this->addLog(array("log_info"=>"订单异常","pid"=>$v,"handle_info"=>"订单异常,不能进行操作","cid"=>"1"));
        }
        $_message = "操作成功";
        if(0 != $total) $_message = "操作失败，有{$total}个订单不能表记异常,";
        if(0 != $cus_num) $_message = "操作失败，其中已跳过{$cus_num}条售后中的订单,";
        if(0 != $cship) $_message = "操作失败，有{$cship}个订单因取消运单失败不能表记异常,";
        $this->aReturn(1,$_message);
    }

    /**
     * [dealOrder 异常订单处理]
     * @return [type] [description]
     */
    public function dealOrder(){
        if(I('post.order_id') || I('post.type')){
            if(I('post.type')){
                $order_list = $this->getOrderList($this->searchWhere(),I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'order_list.order_id asc','all');
                $order_id = $order_list['list'];
            }
            if(I('post.order_id')){
                $order_id = I('post.order_id');
            }
            $total = 0;
            foreach($order_id as $k=> $v){
                if(1 == M('order_list')->where("order_id={$v} and is_cus = 1")->count()){
                    $cus_num++;
                    $total++;
                    continue;
                }
                $order = M('order_list');
                $order_state = $order->where('order_id = ' . $v)->getField('order_state');
                if(6 != $order_state){
                    $total++;
                }else{
                    $order->order_state = 1;
                    $order->where('order_id =' . $v)->save();
                    $this->addLog(array("log_info"=>"异常订单处理","handle_info"=>"处理异常订单,订单进入待确认","cid"=>1,"pid"=>$v));
                }
            }
            if(0 != $total){
                $data['status'] = $total;
                $data['content'] = "有" . $total . "订单不能确认";
            }else{
                $data['status'] = 'ok';
                if($cus_num > 0){
                    $data['content'] = "操作成功，其中已跳过" . $cus_num . "条售后中的订单";
                }else{
                    $data['content'] = "操作成功";
                }
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * [orderManger 售后管理]
     * @return [type] [description]
     */
    public function orderManger(){
        $this->depot = M('system_depot')->field('id,depot_name')->select();
        $datas = $this->getCusList($this->cusOrderSearch(),I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'cus_order_list.id desc');
        //var_dump($this->cusOrderSearch());
        //echo M('cus_order_list')->getLastSql();
//        foreach ($datas['list'] as $key => $value) {
//        	$value['order_sn'] = M('order_list')->where("order_id=".$value['order_id'])->getField('order_sn');
//        	$datas['list'][$key] = $value;
//        }
        $this->assign('datas',$datas);
        $this->show();
    }

    /**
     * [cusOrderSearch 售后订单搜索条件查询]
     * @return [type] [description]
     */
    public function cusOrderSearch(){
        //订单状态
        //待确认
        if(2 == I('get.group_id')){
            $_where['status'] = 0;
        }
        //已确认待收货
        if(3 == I('get.group_id')){
            $_where['status'] = 1;
        }
        //待审核
        if(4 == I('get.group_id')){
            $_where['status'] = 3;
        }
        //待退款
        // if( 5 == I('get.group_id') ){
        // 	$_where['status'] = 5;
        // }
        //已完成	
        if(5 == I('get.group_id')){
            $_where['status'] = 4;
        }
        //已拒绝
        if(6 == I('get.group_id')){
            $_where['status'] = 2;
        }
        //组合搜索条件
        //仓库地址
        if(I('get.depot')){
            $_where['cus_order_goods_list.depot_id'] = I('get.depot',0);
        }
        //分销商名称
        if(I('get.buyer_name')){
            $_where['cus_order_list.buyer_name'] = I('buyer_name');
        }
        //售后理由
        if(I('get.refund_reason')){
            $_where['refund_reason'] = I('get.refund_reason');
        }
        // 售后类别
        if(I('get.cus_type')){
            $_where['cus_type'] = I('get.cus_type');
        }

        //申请时间
        if(I('get.startTime')){
            $_startTime = I('get.startTime',0) ? strtotime(I('get.startTime')) : 1;
            $_where['cus_order_list.addtime'] = array('egt',$_startTime);
        }
        //结束时间
        if(I('get.endTime')){
            $_endTime = I('get.endTime',0) ? strtotime(I('get.endTime')) : time();
            $_where['cus_order_list.close_time'] = array('between',"1,{$_endTime}");
        }
        //选择来源
        if(I('get.shop_id')){
            $_where['cus_order_list.shop_id'] = I('get.shop_id');
        }
        //选择关键字
        if(I('get.cus_order_search') and I('get.search_word')){
            if(I('get.cus_order_search') == 'id'){
                $_where['cus_order_list.id'] = I('get.search_word');
            }else if(I('get.cus_order_search') == 'buyer_goods_no'){
                $_where['cus_order_goods_list.buyer_goods_no'] = array('LIKE','%' . I('get.search_word') . '%');
            }else{
                $_where[I('get.cus_order_search')] = I('get.search_word');
            }
        }
        return $_where;
    }

    /**
     * [cusConfirmOrder 售后订单确认]
     * @return [type] [description]
     */
    public function cusConfirmOrder(){
        if(I('post.cus_order_id') || I('post.type')){
            if(I('post.type')){
                $order_list = $this->getCusList($this->cusOrderSearch(),'','all');
                $order_id = $order_list['list'];
            }
            if(I('post.cus_order_id')){
                $order_id = I('post.cus_order_id');
            }
            $total = 0;
            $cus_order = M('cus_order_list');
            foreach($order_id as $k=> $v){
                $cus_order_state = $cus_order->where('cus_order_list.id = ' . $v)->getField('status');
                if(0 == $cus_order_state){
                    $_join = 'order_list ON order_list.order_id = cus_order_list.order_id';
                    $_order_status = M('cus_order_list')->join($_join)->where('cus_order_list.id = ' . $v)->getField('order_state');
                    if($_order_status < 3){
                        $cus_order->status = 3;
                    }else{
                        $cus_order->status = 1;
                    }
                    $cus_order->conf_time = time();
                    $cus_order->where('cus_order_list.id = ' . $v)->save();
                    $this->addLog(array("log_info"=>"售后确认","pid"=>$v,"handle_info"=>"售后订单已确认","cid"=>"2"));
                }else{
                    $total++;
                }
            }
            if(0 != $total){
                $data['status'] = $total;
                $data['content'] = "售后单确认操作完成！有" . $total . "售后单未确认";
            }else{
                $data['status'] = 'ok';
                $data['content'] = "操作成功";
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * [getOrderId 通过售后订单ID获取订单ID]
     * @param  [type] $mCusId [售后订单id]
     * @return [type]         [description]
     */
    public function getOrderId($mCusId){
        $_order_id = M('cus_order_list')->where('id =' . $mCusId)->getField('order_id');
        return $_order_id;
    }

    /**
     * [cusCancelOrder 售后订单拒绝]
     * @return [type] [description]
     */
    public function cusCancelOrder(){
        if(I('post.cus_order_id') || I('post.type')){
            if(I('post.type')){
                $order_list = $this->getCusList($this->cusOrderSearch(),'','all');
                $order_id = $order_list['list'];
            }
            if(I('post.cus_order_id')){
                $order_id = I('post.cus_order_id');
            }
            $total = 0;
            $cus_order = M('cus_order_list');
            foreach($order_id as $k=> $v){
                $cus_order_state = $cus_order->where('cus_order_list.id = ' . $v)->getField('status');
                if(4 != $cus_order_state and 2 != $cus_order_state){
                    $cus_order->status = 2;
                    $cus_order->close_time = time();
                    $cus_order->where('cus_order_list.id = ' . $v)->save();
                    $order = M('order_list');
                    $order->is_cus = 0;
                    $order->where('order_id = ' . $this->getOrderId($v))->save();
                    $this->addLog(array("log_info"=>"售后订单已拒绝","pid"=>$order_id,"handle_info"=>"售后订单已拒绝","cid"=>"2"));
                }else{
                    $total++;
                }
            }

            if(0 != $total){
                $data['status'] = 'fail';
                $data['content'] = "售后单拒绝操作成功,有" . $total . "售后单不能拒绝";
            }else{
                $data['status'] = 'ok';
                $data['content'] = "售后单拒绝操作成功";
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * [cusReceivOrder 售后订单  收货]
     * @return [type] [description]
     */
    public function cusReceivOrder(){
        if(I('post.order_id')){
            $cus_order_id = I('post.order_id');
            $cus_order_list = M('cus_order_list');
            $cus_goods = M('cus_order_goods_list');
            foreach($cus_order_id as $k=> $v){
                $cus_order_state = $cus_order_list->where('cus_order_list.id =' . $v)->getField('status');
                $str = '';
                if(1 == $cus_order_state){
                    //收货加库存
                    //$_order_id = M('cus_order_list')->where('id = '.$v)->getField('order_id');
                    //$_result = $this->decGoodsStock( $_order_id );
                    // $_result =$this->decCusStock($v);
                    // if(!$_result){
                    // 	$data['status']     = 'error';
                    // 	return;							
                    // }
                    $cus_order_list->status = 3;
                    $cus_order_list->receipt_time = time();
                    $_order = $cus_order_list->where('cus_order_list.id=' . $v)->save();
                    if(!$_order){
                        $data['status'] = 'error';
                        $this->ajaxReturn($data);
                        return;
                    }
                    $this->addLog(array("log_info"=>"售后订单已收货","pid"=>$cus_order_id,"handle_info"=>"售后订单已售后,进入待审核状态","cid"=>"2"));
                    if(I('post.cus_goods_statu')){
                        $cus_goods->cus_goods_statu = I('post.cus_goods_statu');
                    }
                    if(I('post.user')){
                        $cus_goods->responsible = I('post.user');
                    }
                    if(I('post.ckbox',4)){
                        $_data = array();
                        foreach(I('post.ckbox') as $n=> $m){
                            switch($m){
                                case "1":
                                    $_data[] = '已洗涤';
                                    break;
                                case "2":
                                    $_data[] = '缺吊牌';
                                    break;
                                case "3":
                                    $_data[] = '破损';
                                    break;
                                case "4":
                                    $_data[] = '其他';
                                    break;
                                default;
                            }
                        }
                    }

                    if(I('post.other')){
                        $_data[] = I('post.other');
                    }
                    if(is_array($_data)){
                        $cus_goods->damaged = serialize($_data);
                    }
                    $_goods = $cus_goods->where('cus_id =' . $v)->save();
                }
            }
            if($_order){
                $data['status'] = 'ok';
            }else{
                $data['status'] = 'error';
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * [cusAudit 审核]
     * getRefundAmount
     * @return [type] [description]
     */
    public function cusAudit(){
        if(I('post.cus_order_id') and I('post.refund_amount',-1) != -1){
            $cus_order_id = I('post.cus_order_id');
            $cus_order_list = M('cus_order_list');
            $cus_order = $cus_order_list->where('cus_order_list.id =' . $cus_order_id)->find();
            if(3 != $cus_order['status']){
                $this->aReturn(0,"售后单状态不是待审核");
            }else{
                //返回借口的数据
                $send_data['mms_userid'] = $cus_order['buyer_id'];
                $send_data['fund'] = I('post.refund_amount');
                $send_data['remark'] = "售后订单" . $cus_order_id . "已取消";
                $send_data['_act'] = 1;
                $send_data['_ts'] = time();
                $send_data['_sign'] = $this->autoSign($send_data);
                $url = C('cus_api_url');
                $result = YHttp::sendHttpRequest($url,$send_data,'POST');
                //if( $result->code !== 0 ){
                if(1 == 0){
                    $this->aReturn(0,$result->msg);
                }else{
                    /*                     * 售后加库存* */
                    $_result = $this->decCusStock($cus_order_id);
                    if(1 != $_result){
                        $this->aReturn(0,"售后库存增加失败");
                        return;
                    }
                    $cus_order_list->status = 4;
                    $cus_order_list->verify_time = time();
                    $cus_order_list->close_time = time();
                    $cus_order_list->refund_amount = I('post.refund_amount');
                    $cus_order_list->where('cus_order_list.id =' . $cus_order_id)->save();
                    $order = M('order_list');
                    $_pay_amount = $order->where('order_id =' . $this->getOrderId($cus_order_id))->getField('pay_amount');
                    if($_pay_amount == I('post.refund_amount')){
                        $order->order_state = 5;
                    }
                    $order->is_cus = 0;
                    $order->where('order_id = ' . $this->getOrderId($cus_order_id))->save();
                    $this->addLog(array("log_info"=>"售后订单已审核完成","pid"=>$cus_order_id,"handle_info"=>"售后订单审核完成","cid"=>"2"));
                    $this->aReturn(1,"售后单审核操作成功");
                }
            }
        }
    }

    /**
     * [cusOrderRefund 补款]
     * @return [type] [description]
     */
    public function cusOrderRefund(){
        if(I('post.')){
            $_refund_count = M('cus_order_repl')->where('cus_id=' . I('post.cus_id'))->count('cus_id');
            if($_refund_count < 3){
                $send_data['mms_userid'] = I('post.buyer_id');
                $send_data['fund'] = I('price');
                $send_data['remark'] = "售后订单" . I('post.cus_id') . "已取消";
                $send_data['_act'] = 1;
                $send_data['_ts'] = time();
                $send_data['_sign'] = $this->autoSign($send_data);
                $url = C('cus_api_url');
                $result = YHttp::sendHttpRequest($url,$send_data,'POST');
                if($result->code != 0){
                    $this->aReturn(0,'补款操作失败');
                }else{
                    $cus_repl = M('cus_order_repl');
                    $cus_repl->cus_id = I('post.cus_id');
                    $cus_repl->buyer_id = I('post.buyer_id');
                    $cus_repl->buyer_name = I('buyer_name');
                    $cus_repl->price = I('price');
                    $cus_repl->add_time = time();
                    $cus_repl->admin_id = $_SESSION['phpCAS']['user'];
                    $cus_repl->remark = I('post.remark');
                    $_total = $cus_repl->add();
                }
            }else{
                // $_data['status']  = 'error';
                // $_data['content'] = '补款次数不能超过三次';
                // $this->ajaxReturn($_data);
                $this->aReturn(0,"补款次数不能超过三次");
            }
        }
        if($_total){
            $this->addLog(array("log_info"=>"售后订单补款" . I('price') . "元","pid"=>I('post.cus_id'),"handle_info"=>"售后订单补款","cid"=>"2"));
            // $this->ajaxReturn('ok');
            $this->aReturn(1,"补款成功");
        }else{
            //$this->ajaxReturn('error');
            $this->aReturn(0,"补款失败");
        }
    }

    /**
     * [orderDetail 订单详情]
     * @return [type] [description]
     */
    public function orderDetail(){
        $_order_id = I('get.order_id/d');

        $datas = M('order_list')->where("order_id = $_order_id")->find();
        //如果有留言，查询留言
        if($datas['message_starts'] == 1){
            $datas['order_message'] = M('order_message')->where("order_id = $_order_id ")->select();
            foreach($datas['order_message'] as $key=> $value){
                $value['addtime'] = date("Y-m-d H:i:s",$value['addtime']);
                $datas['order_message'][$key] = $value;
            }
        }
        //获取订单发货状态
        if($datas['order_state'] == 2){
            $datas['hub_order_state'] = M('hub_order')->where("order_id ={$_order_id}")->getField('ship_stats');
        }
        //查询快递公司
        if($datas['order_state'] == 3 || $datas['order_state'] == 4 || $datas['hub_order_state'] > 1) $this->ship_info = M('system_shipping')->select();
        //订单中商品的信息 ($datas['order_goods']);
        $datas['order_goods'] = M('order_goods')->where("order_id = $_order_id")->select();
        //$datas['goods_num_total']   = M('order_goods')->where("order_id = $_order_id")->count("goods_num");
        $datas['cus_order_num'] = M('cus_order_list')->where("order_id={$_order_id }")->count('order_id');
        $datas['cus_order_state'] = M('cus_order_list')->where("order_id={$_order_id }")->order('id desc')->getField('status');
        foreach($datas['order_goods'] as $kk=> $vv){
            $goods_info = M('goods_list')->where("goods_id=" . $vv['goods_id'])->find();
            $vv['goods_img'] = $goods_info['img_path'];
            $vv['buyer_goods_on'] = $goods_info['buyer_goods_on'];
            //订单中商品的sku组合id ($vv['sku_comb_id']);
            $vv['sku_comb_id'] = M('order_goods_sku')->where("goods_id=" . $vv['goods_id'] . " and order_id = $_order_id")->getField('sku_comb_id');
            //订单中商品的价格
            if(!empty($vv['sku_comb_id'])){
                $goods_price = M('goods_price')->where(" goods_id=" . $vv['goods_id'] . " and shop_id=" . $datas['shop_id'] . " and comb_id=" . $vv['sku_comb_id'])->find();
                $vv['original_price'] = $goods_price['original_price'];
                $vv['market_price'] = $goods_price['market_price'];
                $vv['distribution_price'] = $goods_price['distribution_price'];
                $vv['goods_price_total'] = number_format($vv['distribution_price'] * $vv['goods_num'],2);
                $vv['sku_str'] = M('goods_sku_comb')->where("id=" . $vv['sku_comb_id'])->getField('sku_str_zh');
            }
            $datas['goods_num_total'] += $vv['goods_num'];
            $datas['order_goods'][$kk] = $vv;
        }
        //订单的价格
        $datas['order_price'] = number_format($datas['order_price'],2);
        $datas['order_price_total'] = number_format($datas['shipping_fee'] + $datas['order_price'],2);
        /* 获取最新的2条收货人信息 */
        $datas['concat_address'] = M('order_contact')->where("order_id=" . $datas['order_id'])->order('id desc')->limit(2)->select();
        /* 取最新一条收货人信息 */
        $address = $datas['concat_address'][0];
        $datas['shop_id'] = M('system_shop')->where("shop_id=" . $datas['shop_id'])->getField('shop_name');
        //print_r($datas);
        $this->assign('datas',$datas);
        $this->assign('address',$address);
        //订单日志
        $orderLog = M('log_list')->where(" cid=1 and pid = $_order_id ")->order("id desc")->select();
        $this->assign('orderLog',$orderLog);
        //获取地区
        $province = M('area_list')->where("parent_id=1")->select();
        foreach($province as $key=> $value){
            if($value['area_name'] == $address['province']){
                $citys = M('area_list')->where("parent_id = " . $value['id'])->select();
                foreach($citys as $k=> $v){
                    if($v['area_name'] == $address['city']){
                        $dists = M('area_list')->where("parent_id = " . $v['id'])->select();
                    }
                }
            }
        }
        $this->assign('dists',$dists);
        $this->assign('citys',$citys);
        $this->assign('province',$province);
        $this->show();
    }

    /**
     * [cusOrder 售后订单详情]
     * @return [type] [description]
     */
    public function cusOrderDetail(){
        $cus_id = I('get.cus_order_id/d');
        /* 售后订单 */

        $data['cus_order'] = M('cus_order_list')->where("id =$cus_id")->find();
        $data['shop'] = M('system_shop')->where("id={$data['cus_order']['shop_id']}")->find();
        $data['cus_order']['cus_order_goods_img'] = M('cus_order_goods_img')->where('cus_id =' . $cus_id)->select();
        $data['cus_order']['refund_amount'] = number_format($data['cus_order']['refund_amount'],2);
        /* 订单信息 */
        $data['order'] = M('order_list')->where("order_id = {$data['cus_order']['order_id']}")->find();
        $data['order_goods'] = M('order_goods')->where("order_id = " . $data['order']['order_id'])->select();
        foreach($data['order_goods'] as $kk=> $vv){
            $goods_info = M('goods_list')->where("goods_id=" . $vv['goods_id'])->find();
            $vv['goods_img'] = $goods_info['img_path'];
            $vv['buyer_goods_on'] = $goods_info['buyer_goods_on'];
            //订单中商品的sku组合id ($vv['sku_comb_id']);
            $vv['sku_comb_id'] = M('order_goods_sku')->where("goods_id=" . $vv['goods_id'] . " and order_id =" . $data['order']['order_id'])->getField('sku_comb_id');
            //订单中商品的价格
            if(!empty($vv['sku_comb_id'])){
                $goods_price = M('goods_price')->where(" goods_id=" . $vv['goods_id'] . " and shop_id=" . $data['cus_order']['shop_id'] . " and comb_id=" . $vv['sku_comb_id'])->find();
                $vv['original_price'] = $goods_price['original_price'];
                $vv['market_price'] = $goods_price['market_price'];
                $vv['distribution_price'] = $goods_price['distribution_price'];
                $vv['goods_price_total'] = number_format($vv['distribution_price'] * $vv['goods_num'],2);
                $data['goods_num_total'] += $vv['goods_num'];
                $data['order_price'] += $vv['goods_price_total'];
                $vv['sku_str'] = M('goods_sku_comb')->where("id=" . $vv['sku_comb_id'])->getField('sku_str_zh');
            }
            $data['order_goods'][$kk] = $vv;
        }

        // 售后订单商品
        $data['cus_order_goods'] = M('cus_order_goods_list')->where("cus_id = $cus_id")->select();
        foreach($data['cus_order_goods'] as $k=> $vv){
            $data['cus_goods_num_total'] += $vv['goods_num'];
            $vv['damaged'] = unserialize($vv['damaged']);
            $data['cus_order_goods'][$k] = $vv;
        }
        /* 获取最新的2条收货人信息 */
        $data['concat_address'] = $this->getOrderConcatAll($data['order']['order_id'],2);
        /* 取最新一条收货人信息 */
        $address = $datas['concat_address'][0];
        $data['order_price'] = number_format($data['order_price'],2);
        $data['shipping_fee'] = number_format($data['shipping_fee'],2);
        $data['order_price_total'] = number_format($data['shipping_fee'] + $data['order_price'],2);
        $data['message'] = M('order_message')->where('order_id = ' . $data['order']['order_id'] . " and user_type =1")->select();
        $orderLog = M('log_list')->where(" cid=2 and pid =$cus_id")->order("id desc")->select();
        $this->assign('orderLog',$orderLog);
        $this->assign('datas',$data);
        $this->show();
    }

    /**
     * 获取订单的物流公司信息
     */
    public function getShippingName($shipping_id){
        return M('system_shipping')->where("shipping_id = $shipping_id")->find();
    }

    /**
     * 修改物流信息
     */
    public function edit_shipping(){
        $data = I('post.');
        if(!empty($data['order_id'])){
            $order_info = M('order_list')->where("order_id=" . $data['order_id'])->find();
            $ship_info = $this->getShippingName($data['shipping_id']);
            $update['shipping_code'] = $up_hub_order['shipping_code'] = $data['shipping_code'];
            $update['shipping_name'] = $up_hub_order['shipping_name'] = $ship_info['shipping_name'];
            $update['shipping_id'] = $ship_info['shipping_id'];
            $up_hub_order['shipping_no'] = M('system_shipping')->where("shipping_id=" . $ship_info['shipping_id'])->getField('shipping_code');
            if($order_info['shipping_id'] == $data['shipping_id'] && $order_info['shipping_code'] == $data['shipping_code']){
                $result['status'] = 0;
                $result['msg'] = "物流信息没有任何修改内容";
            }else{
                if(M('order_list')->where("order_id=" . $data['order_id'])->save($update) && M('hub_order')->where("order_id = " . $data['order_id'])->save($up_hub_order)){
                    $this->addLog(array("log_info"=>"修改物流信息","pid"=>$data['order_id'],"handle_info"=>"修改物流信息","cid"=>"1"));
                    $result['status'] = 1;
                    $result['msg'] = "物流信息修改成功";
                }else{
                    $result['status'] = 0;
                    $result['msg'] = "物流信息修改失败";
                }
            }
        }else{
            $result['status'] = 0;
            $result['msg'] = "未获取到订单信息";
        }
        echo json_encode($result);
    }

    /**
     * 修改地址
     */
    public function edit_address(){
        $data['order_id'] = I('post.order_id');
        $data['tel'] = I('post.tel');
        $data['contact_name'] = I('post.contact_name');

        $data['province'] = I('post.province');
        $data['city'] = I('post.city');
        $data['dist'] = I('post.dist');
        $data['contact_address'] = I('post.contact_address');
        if(empty($data['contact_address']) || strlen($data['contact_address']) < 12){
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
        if($is_edit_address['is_edit_address'] != 1){
            $updata['is_edit_address'] = 1;
            $updata['receiver_name'] = $data['contact_name'];
            $updata['receiver_tel'] = $data['tel'];
            if(M('order_contact')->add($data) && M('order_list')->where("order_id=" . $data['order_id'])->save($updata)){
                if($is_edit_address['order_state'] > 1){
                    $hub_data = array('receiver_name'=>$data['contact_name'],'receiver_tel'=>$data['tel']);
                    M('hub_order')->where("order_id=" . $data['order_id'])->setField($hub_data);
                }
                $this->addLog(array("log_info"=>"修改收件人信息","pid"=>I('post.order_id'),"handle_info"=>"修改收件人信息","cid"=>"1"));
                $result['status'] = 1;
                $result['msg'] = "收货人信息修改成功";
            }else{
                $result['status'] = 0;
                $result['msg'] = "修改失败";
            }
        }else{
            if($is_edit_address['receiver_name'] != $data['contact_name']){
                $updata['receiver_name'] = $data['contact_name'];
            }
            if($is_edit_address['receiver_tel'] != $data['tel']){
                $updata['receiver_tel'] = $data['tel'];
            }
            if($is_edit_address['receiver_name'] != $data['contact_name'] || $is_edit_address['receiver_tel'] != $data['tel']){
                M('order_list')->where("order_id=" . $data['order_id'])->save($updata);
            }
            if(M('order_contact')->add($data)){
                $this->addLog(array("log_info"=>"修改收货人信息","pid"=>I('post.order_id'),"handle_info"=>"修改收货人信息","cid"=>"1"));
                $result['status'] = 1;
                $result['msg'] = "收货人信息修改成功";
            }else{
                $result['status'] = 0;
                $result['msg'] = "修改失败";
            }
        }
        echo json_encode($result);
    }

    /**
     * 获取所有地址列表
     */
    public function area_list(){
        if(I('get.id') > 0) $id = I('get.id');
        $type = M('area_list')->where(" id = $id ")->find();
        $area = M('area_list')->where(" parent_id = $id ")->select();
        echo json_encode($area);
    }
    /**
     * [getHubList description]
     * @param  string $mWhere [组合搜索条件查询]
     * @param  string $mOrder [排序]
     * @param  string $type    非空的就查询所有
     * @return Array         [description]
     */
    public function getOrderList($mWhere = '',$mOrder = '',$type = ''){
        $order_list = M('hub_order');
        if(!empty($type)){
            $_join = 'hub_order_goods ON hub_order_goods.order_id = hub_order.order_id';
            $_join_tow = "goods_list ON goods_list.goods_id = hub_order_goods.goods_id";
            $_list = $order_list->join($_join)->join($_join_tow)->Field('hub_order.order_id')->where($mWhere)->select();
            foreach($_list as $value){
                $_data[] = $value['order_id'];
            }
        }else{
            $order_list->join('hub_order_goods ON hub_order_goods.order_id = hub_order.order_id');
            $order_list->join('goods_list ON goods_list.goods_id = hub_order_goods.goods_id');
            $order_list->join('order_list ON order_list.order_id = hub_order_goods.order_id');
            $order_list->join('order_contact ON order_contact.order_id = hub_order.order_id');
            $order_list->join('order_goods ON order_list.order_id = order_goods.order_id');
            $order_list->join('order_goods_sku ON order_goods_sku.order_id = order_list.order_id and order_goods.goods_id=order_goods_sku.goods_id');
            $order_list->join('goods_sku_comb ON goods_sku_comb.id = order_goods_sku.sku_comb_id');
            $_field = 'order_list.order_id,order_list.order_sn,order_goods.goods_name,'
                    . 'hub_order.buyer_goods_no,hub_order.con_time,hub_order.id as hub_id,'
                    . 'order_list.memo,contact_name,contact_address,order_goods.img_path,hub_order.ship_stats,'
                    . 'tel,province,city,dist,order_goods.distribution_price,cost_price'
                    . ',order_goods.price,order_list.shipping_fee,order_amount,is_cus,goods_sku_comb.sku_str_zh as sku';
            $_count = $order_list->where($mWhere)->count();
            $_page = getPage($_count);
            
            $order_list->join('hub_order_goods ON hub_order_goods.order_id = hub_order.order_id');
            $order_list->join('goods_list ON goods_list.goods_id = hub_order_goods.goods_id');
            $order_list->join('order_list ON order_list.order_id = hub_order_goods.order_id');
            $order_list->join('order_contact ON order_contact.order_id = hub_order.order_id');
            $order_list->join('order_goods ON order_list.order_id = order_goods.order_id');
            $order_list->join('order_goods_sku ON order_goods_sku.order_id = order_list.order_id and order_goods.goods_id=order_goods_sku.goods_id');
            $order_list->join('goods_sku_comb ON goods_sku_comb.id = order_goods_sku.sku_comb_id');
            $_field = 'order_list.order_id,order_list.order_sn,order_goods.goods_name,'
                    . 'hub_order.buyer_goods_no,hub_order.con_time,hub_order.id as hub_id,'
                    . 'order_list.memo,contact_name,contact_address,order_goods.img_path,hub_order.ship_stats,'
                    . 'tel,province,city,dist,order_goods.distribution_price,cost_price'
                    . ',order_goods.price,order_list.shipping_fee,order_amount,is_cus,goods_sku_comb.sku_str_zh as sku';
            $_data['list'] = $order_list->where($mWhere)->order($mOrder)->limit($_page->firstRow . ',' . $_page->listRows)->field($_field)->select();
            $_data['page'] = $_page->show();
        }
        return $_data;
    }

    /**
     * [getOrderImg 获取订单商品图片]
     * @return [type] [description]
     */
    public function getOrderImg($mOrderId){
        $order_goods = M('order_goods');
        $order_goods->join('goods_list ON goods_list.goods_id = order_goods.goods_id');
        $img_path = $order_goods->where("order_goods.order_id ={$mOrderId}")->field('order_goods.img_path')->find();
        return $img_path;
    }

    /**
     * [getOrderLog 获取订单操作日志]
     * @param  string $mWhere [查询条件]
     * @param  string $mOrder [排序方式]
     * @return Array         
     */
    public function getOrderLog($mWhere = '',$mOrder = ''){
        $_log_list = M('log_list')->where($mWhere)->order($mOrder)->select();
        return $_log_list;
    }

    /**
     * [getCusList description]
     * @param  string $mWhere [搜索条件]
     * @param  string $mOrder [排序方式]
     * @param  string $type   [存在查询全部,不存在,按照条件查询]
     * @return [type]         [description]
     */
    public function getCusList($mWhere = '',$mOrder = '',$type = ''){
        $_join_one = "cus_order_goods_list ON cus_id = cus_order_list.id";
        $_join_two = "order_list ON order_list.order_id = cus_order_list.order_id";
        $_join_tree = "goods_list ON goods_list.goods_id = cus_order_goods_list.goods_id";
        $_count = M('cus_order_list')->join($_join_one)->join($_join_two)->join($_join_tree)->where($mWhere)->count();
        $_page = $this->getPage($_count);
        $cus_order_list = M('cus_order_list');
        if(!empty($type)){
            $cus_order_list->join($_join_one);
            $cus_order_list->join($_join_two);
            $cus_order_list->join($_join_tree);
            $_list = $cus_order_list->Field('cus_order_list.id')->where($mWhere)->select();
            foreach($_list as $key=> $value){
                $_data['list'][] = $value['id'];
            }
        }else{
            $cus_order_list->join('cus_order_goods_list ON cus_id = cus_order_list.id');
            $cus_order_list->join('order_list ON order_list.order_id = cus_order_list.order_id');
            $cus_order_list->join('goods_list ON goods_list.goods_id = cus_order_goods_list.goods_id');

            $str = "cus_order_list.*,cus_order_list.id as cus_order_id,order_list.order_sn,order_list.order_amount";
            $str.=", order_list.qq,goods_list.goods_no, cus_order_goods_list.buyer_goods_no as cus_goods_no, cus_order_goods_list.cus_goods_statu,";
            $str.="cus_order_goods_list.responsible,cus_order_goods_list.damaged";
            $cus_order_list->field($str);
            $_data['list'] = $cus_order_list->where($mWhere)->order($mOrder)->limit($_page->firstRow . ',' . $_page->listRows)->select();
            $_data['page'] = $_page->show();
        }
        return $_data;
    }

    /**
     * [getBuyerInfo 获取分销商信息]
     * @return [type] [description]
     */
    public function getBuyerInfo(){
        if(I('post.cus_order_id')){
            $cus_order_list = M('cus_order_list')->where('cus_order_list.id =' . I('post.cus_order_id'))
                            ->field('*,cus_order_list.id as cus_order_id')->select();
            $this->ajaxReturn($cus_order_list[0]);
        }
    }

    /**
     * [getRefundAmount 获取退款金额]
     * @return [type] [description]
     */
    public function getRefundAmount(){
        if(I('post.cus_order_id')){
            $_order_id = M('cus_order_list')->where('id =' . I('post.cus_order_id'))->getField('order_id');
            if(!$_order_id){
                $_data['status'] = 'error';
                $_data['content'] = '参数错误';
                $this->aReturn($_data);
            }
            $data['pay_amount'] = M('order_list')->where('order_id =' . $_order_id)->getField('pay_amount');
            $data['refund_amount'] = M('cus_order_list')->where('id =' . I('post.cus_order_id'))->getField('refund_amount');
            $this->aReturn(1,"ok",$data);
        }
    }

    /**
     * [addRemark 添加标记]
     */
    public function addRemark(){
        if(I('post.order_id')){
            $this->memo = M('order_list')->where('order_id =' . I('post.order_id'))->getField('memo');
            $str = $this->fetch(T('Public/order_assign'));
            echo $str;
        }
    }

    /**
     * [updateRemark 更新标记信息]
     * @return [type] [description]
     */
    public function updateRemark(){
        try{
            $order = M('order_list');
            $order->memo = I('post.memo');
            $order->where('order_id = ' . I('post.order_id'))->save();
            $_result['message'] = 'ok';
        }catch(Exception $e){
            $_result['message'] = $e->getMessage();
        }
        $this->ajaxReturn($_result);
    }

    /**
     * [getMessage 获取留言信息]
     * @return [type] [description]
     */
    public function Message(){
        if(I('post.order_id')){
            $this->result = M('order_message')->where('order_id = ' . I('post.order_id'))
                            ->field('addtime,user_type,message,order_id')->order('addtime')->select();
            $this->order_id = I('post.order_id');
            $str = $this->fetch(T('Public/order_message'));
            echo $str;
        }
    }

    /**
     * [saveMessage 保存留言]
     * @return [type] [description]
     */
    public function saveMessage(){
        if(I('post.')){
            $message = M('order_message');
            $message->order_id = I('post.order_id');
            $message->user_type = 2;
            $message->user_id = $_SESSION['phpCAS']['user'];
            $message->message = I('post.val');
            $message->addtime = time();
            $total = $message->add();
            if($total == 0){
                $_result['status'] = "fail";
            }else{
                $_result['status'] = "success";
                $_result['time'] = date("Y-m-d H:m:s",time());
            }
            $this->ajaxReturn($_result);
        }
    }
    
    /**
     * [storageFaHuoList 仓储管理 库存管理]
     * @return [type] [description]
     */
    public function storageManger(){
        if(1 == I('get.explode_goods/d')){
            $this->exportStock();
            exit();
        }
        $this->depot = $this->depotList();
        $this->goods_category = $this->goodsCategoryList();
        $_goodsWhere = $this->goodsWhere();
        if(2 == I('get.group_id',0)){
            $_goodsWhere['goods_sku_comb.stock_num'] = array('exp',' <=goods_sku_comb.stock_lock_num and goods_sku_comb.stock_lock_num >0 ');
        }
        $this->datas = $this->getStorage($_goodsWhere,I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'goods_list.goods_id asc');
        $this->show();
    }
    /**
     * [goodsWhere 库存管理 搜索条件]
     * @return [type] [description]
     */
    public function goodsWhere(){
        $_where['is_delete'] = 0;
        $_where['goods_lack'] = 0;
        //搜索条件
        //仓库地址
        if(I('get.depot')){
            $_where['depot_id'] = I('get.depot');
        }
        //商品类目
        if(I('get.goods_category')){
            $_where['category_parent'] = I('get.goods_category');
        }

        if(1 == I('get.explode_goods/d')){
            if(is_array(I('get.explodeGoods'))){
                $_where['goods_list.goods_id'] = array('in',I('get.explodeGoods'));
            }
        }
        //商品状态
        if(I('get.goods_sale')){
            $_where['goods_sale'] = I('goods_sale');
        }
        //仓储 管理 时间
        if(I('get.time_type') and ( I('get.startTime') or I('get.endTime') )){
            $_startTime = I('get.startTime',0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime',0) ? strtotime(I('get.endTime')) : time();
            $_where[I('get.time_type')] = array('BETWEEN',array($_startTime,$_endTime));
        }

        if(I('get.goods_search',0)){
            if(I('get.search_word') != ''){
                if(strtolower(I('get.goods_search')) == 'goods_name'){
                    $_where['goods_list.goods_name'] = array('LIKE','%' . I('get.search_word') . '%');
                }elseif(strtolower(I('get.goods_search')) == 'buyer_goods_no'){
                    $_where['goods_list.buyer_goods_no'] = array('LIKE','%' . I('get.search_word') . '%');
                }else{
                    $_where['goods_list.' . I('get.goods_search')] = I('get.search_word');
                }
            }
        }
        return $_where;
    }
    
    /**
     * getStorage 获取商品库存
     * @return Array
     */
    public function getStorage($mWhere = '',$mOrder = '',$type = ''){
        $_join = 'goods_sku_comb ON goods_sku_comb.goods_id = goods_list.goods_id ';
        $_count = M('goods_list')->join($_join)->where($mWhere)->group('goods_list.goods_id')->select();
        $_page = getPage(count($_count));
        $_data['list'] = M('goods_list')->join($_join)->where($mWhere)->group('goods_list.goods_id')->order($mOrder)->limit($_page->firstRow . ',' . $_page->listRows)->select();
        $_data['sql'] = M('goods_list')->getLastSql();
        foreach($_data['list'] as $k=> $v){
            $total = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->group('goods_id')->sum('stock_num');
            $_data['list'][$k]['sku_str_zh'] = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->order('id asc')->getField('sku_str_zh',true);
            $_data['list'][$k]['stock_num'] = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->order('id asc')->Field('stock_num,id')->select();
            $_data['list'][$k]['stock_lock_num'] = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->order('id asc')->getField('stock_lock_num',true);
            $_data['list'][$k]['all_stock'] = $total;
        }
        $_data['page'] = $_page->show();
        return $_data;
    }
    
    /**
     * [logEdit 库存日志]
     * @return [type] [description]
     */
    public function logEdit() {
        $this->depot = $this->depotList();
        $this->shipping = $this->system_shipping();
        $this->goods_category = $this->goodsCategoryList();
        $this->datas = $this->getLogCusList($this->logWhere());
        $this->display();
    }
    
    /**
     * [getLogCusList 日志列表]
     * @param  string $mWhere [搜索条件]
     * @param  string $mOrder [排序方式]
     * @param  string $type   [description]
     * @return [type]         [description]
     */
    public function getLogCusList($mWhere = '', $mOrder = '') {
        $_join_goods_list = 'goods_list ON goods_list.goods_id = log_cus_list.goods_id';
        $_join_goods_sku_com = 'goods_sku_comb ON  goods_sku_comb.id = log_cus_list.sku_comb_id';
        $_field = '*,log_cus_list.id as log_id,log_cus_list.addtime as log_time';
        $_count = M('log_cus_list')->join($_join_goods_list)->join($_join_goods_sku_com)->where($mWhere)->order($mOrder)->count();
        $_page = getPage($_count);
        $_log_list = M('log_cus_list');
        $_log_list->join($_join_goods_list);
        $_log_list->join($_join_goods_sku_com);
        $_data['list'] = $_log_list->where($mWhere)->order($mOrder)->field($_field)->limit($_page->firstRow . ',' . $_page->listRows)->select();
        $_data['sql'] = $_log_list->getLastSql();
        foreach ($_data['list'] as $n => $m) {
            preg_match_all('/([0-9]+:[0-9]+);/', $m['sku_str'], $rk);
            $arr_sku = array();
            foreach ($rk[1] as $k => $v) {
                $sku_key_val = explode(':', $v);
                $sku_name = $sku_key_val[0];
                $sku_val = $sku_key_val[1];
                $_data['goods_id'] = $m['goods_id'];
                $_data['sku_val'] = $sku_val;
                //$sku_val_str = M('goods_sku_list_val')->where($_data)->getField('sku_val_str');
                array_push($arr_sku, $sku_val_str);
            }
            $_data['list'][$n]['sku'] = $arr_sku;
        }
        $_data['page'] = $_page->show();
        return $_data;
    }
    
    /**
     * [logWhere 日志搜索条件]
     * @return [type] [description]
     */
    public function logWhere() {
        //group_id
        //创想范
        if (I('get.group_id') == 2) {
            $_where['shop_id'] = 1;
        }
        //星密码
        if (I('get.group_id') == 3) {
            $_where['shop_id'] = 2;
        }
        //仓库地址
        if (I('get.depot')) {
            $_where['depot_id'] = I('get.depot');
        }
        //商品类目 
        if (I('get.goods_category')) {
            $_where['category_parent'] = I('get.goods_category');
        }
        //分销商
        if (I('get.buyer_id')) {
            $_where['buyer_id'] = I('get.buyer_id');
        }
        //操作人
        if (I('get.user_id')) {
            $_where['user_id'] = I('get.user_id');
        }
        //操作时间 日志操作时间
        if (I('get.startTime') or I('get.endTime')) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime', 0) ? strtotime(I('get.endTime')) : time();
            $_where['log_cus_list.addtime'] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //关键字
        if (I('get.order_search') and I('get.search_word')) {
            if (I('get.order_search') == 'goods_name') {
                $_where['goods_name'] = array('LIKE', '%' . I('get.search_word') . '%');
            } elseif (I('get.order_search') == 'buyer_goods_no') {
                $_where['buyer_goods_no'] = array('LIKE', '%' . I('get.search_word') . '%');
            } else {
                $_where[I('get.order_search')] = I('get.search_word');
            }
        }
        return $_where;
    }
    
    /**
     * [getOrderConcatAll 获取订单收件人所有地址信息]
     * @param  int  $mOrderID [订单ID]
     * @return Array           [数组]
     */
    public function getOrderConcatAll($mOrderID, $mLimit = 1) {
        $_concat = M('order_contact')->where(array('order_id' => $mOrderID))->order('id desc');
        if (1 == $mLimit) {
            return $_concat->find();
        } else {
            return $_concat->select();
        }
    }
    
    /**
     * [getOrderGoodsSK 获取订单商品SKU]
     * @param  [订单id] $mOrderID [description]
     * @param  [订单商品id] $mGoodsID [description]
     * @return [type]           [description]
     */
    public function getOrderGoodsSK($mOrderID = '', $goodsId = '') {
        $map['order_id'] = $mOrderID;
        if (empty($goodsId)) {
            $_order_sku_id = M('order_goods_sku')->where($map)->Field('sku_comb_id,goods_id')->find();
            $con_sku_val = M('goods_sku_comb')->where(array('goods_id' => $_order_sku_id['goods_id'], 'id' => $_order_sku_id['sku_comb_id']))->getField('sku_str');
            $_where['goods_id'] = $_order_sku_id['goods_id'];
            $_data['goods_id'] = $_order_sku_id['goods_id'];
        } else {
            $con_sku_val = M('goods_sku_comb')->where(array('goods_id' => $goodsId))->getField('sku_str');
            $_where['goods_id'] = $goodsId;
            $_data['goods_id'] = $goodsId;
        }
        preg_match_all('/([0-9]+:[0-9]+);/', $con_sku_val, $rk);
        $arr_sku = array();
        foreach ($rk[1] as $k => $v) {
            $sku_key_val = explode(':', $v);
            $sku_name = $sku_key_val[0];
            $sku_val = $sku_key_val[1];
            $_where['sku_name'] = $sku_name;
            //$sku_name_str = M('goods_sku_list_name')->where($_where)->getField('sku_name_str');
            $_data['sku_val'] = $sku_val;
           //$sku_val_str = M('goods_sku_list_val')->where($_data)->getField('sku_val_str');
            $arr_sku[$sku_name_str] = $sku_val_str;
        }
        return $arr_sku;
    }
    
    /**
     * depotList 取仓库列表
     * @return Array 
     */
    public function depotList() {
        return M('fx_storage_list')->field('id,sname')->select();
    }
    
    /**
     * [system_shipping 取物流公司名称]
     * @version 增加物流下拉框对数据字段的筛选
     * @return Array [description]
     */
    public function system_shipping($field = '') {
        return M('system_shipping')->field($field)->order("sort asc")->select();
    }
    
    /**
     * [system_shop 取平台列表]
     * @return Array [description]
     */
    public function system_shop() {
        return M('system_shop')->select();
    }
    
    /**
     * goodsCategoryList 商品类目列表
     * @return [type] [description]
     */
    public function goodsCategoryList($mParentId = 0) {
        return M('goods_category')->field('cid,name')->where("parent_cid = {$mParentId}")->order('cid asc')->select();
    }
}
