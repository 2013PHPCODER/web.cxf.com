<?php

namespace api\home;

/**
 * 用户版本升级     up_level
 * @author shenlang
 * 2016‎/8‎/10
 */
class LevelUpdateController extends Controller {

    public function update() {
        $request = $this->request;
        $type = $request->type;         //1,查询版本费用和升级费用 2，升级版本
        $user_id = $request->user_id;
        $virtual_goods_id = $request->virtual_goods_id; //欲升级版本id
        $must = ['type', 'user_id', 'virtual_goods_id'];
        batch_isset($request, $must);
        \Valid::has_number($type)->withError('请求类型错误');
        \Valid::has_number($user_id)->withError('用户id错误');

        /* 获取升级价格和当前版本价格 */

        //  根据userid查询当前用户的版本、用户名
        $distribute_user_model = \Model::fx_distribute_user($user_id);
        $distribute_user_dao = \Dao::fx_distribute_user();
        $cur_list = $distribute_user_dao->getList($distribute_user_model, ['id', 'leavel', 'user_account']);
        if (empty($cur_list['list'])) {
            myerror(\UpdateLevel::levelNone, '获取用户版本失败!');
        }
        $cur_level = $cur_list['list'][0]['leavel'];
        $distribute_name = $cur_list['list'][0]['user_account'];

        /*         * *    升级版本    ** */

        //  根据虚拟商品id查询用户欲升级的版本
        $virtual_goods_model = \Model::fx_virtual_goods($virtual_goods_id);
        $virtual_goods_dao = \Dao::fx_virtual_goods();
        $virtual_goods_list = $virtual_goods_dao->getList($virtual_goods_model, ['level']);
        $to_level = $virtual_goods_list['list'][0]['level'];
        if ($to_level <= $cur_level) myerror(\UpdateLevel::levelLow, "请选择高于当前的版本升级!");

        //当前版本对应价格
        if (0 == $cur_level) {
            $cur_leavel_price = 0;
        } else {
            $cur_leavel_price = $this->get_level_price($cur_level);
        }
        //欲升级版本价格
        $to_leavel_price = $this->get_level_price($to_level);
        //升级需要费用
        $up_level_money = $to_leavel_price - $cur_leavel_price;

        if (1 == $type) {
            $this->response['up_level_money'] = $up_level_money;
            $this->response['to_leavel_price'] = $to_leavel_price;
            $this->response();
        } elseif (2 == $type) {
            //生成虚拟订单号
            $order_sn = '2' . date('ymdhis' . rand(100000, 999999));
            $check_msg = $this->check_order_unique($order_sn);
            //  验证订单号的唯一性
            while (!$check_msg) {
                $order_sn = '2' . date('ymdhis' . rand(100000, 999999));
                $check_msg = $this->check_order_unique($order_sn);
            }
//            //验证是否存在未付款订单
//            $checke_status = $this->check_is_pay($user_id, 1);
//            if (!empty($checke_status)) {
//                $this->response['status'] = 0;
//                $this->response['msg'] = '订单提交失败，有未付款的升级订单！';
//                $this->response['order_sn'] = $checke_status[0]['order_sn'];
//                $this->response['pay_money'] = $checke_status[0]['pay_money'];
//                $this->response();
//                die;
//            }
            $addtime = time();
            $model = \Model::fx_virtual_order('', $order_sn, 2, $up_level_money, $up_level_money, $addtime, '', 1, $user_id, $virtual_goods_id, $distribute_name, '', $cur_level, $to_level);
            $dao = \Dao::fx_virtual_order();
            $order_id = $dao->insert($model);
            if (is_numeric($order_id) && 0 !== $order_id) {
                $this->response['status'] = 1;
                $this->response['msg'] = "订单提交成功！";
                $this->response['order_id'] = $order_id;
                $this->response['order_num'] = $order_sn;
                $this->response['up_level_money'] = $up_level_money;
            } else {
                $this->response['status'] = 0;
                $this->response['msg'] = "订单失败！";
            }
            $this->response();
        }
    }

    /**
     * 根据版本获取对应价格
     * @param type $level 版本
     * @return folat
     * 
     */
    public function get_level_price($level) {
        $model = \Model::fx_virtual_goods('', '', $level);
        $dao = \Dao::fx_virtual_goods();
        $priceArr = $dao->getList($model, ['price']);
        return $priceArr['list'][0]['price'];
    }

    /**
     * 验证订单号的唯一性
     * @param type $order_sn
     * @return type 
     */
    public function check_order_unique($order_sn) {
        $model = \Model::fx_virtual_order('', $order_sn);
        $dao = \Dao::fx_virtual_order();
        $order_sn_arr = $dao->getList($model, ['order_sn']);
        if (empty($order_sn_arr['list'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 验证否存在未付款订单
     * @param type $distribute_user_id
     * @param type $virtual_goods_id
     * @return type
     */
//    public function check_is_pay($distribute_user_id, $status) {
//        $model = \Model::fx_virtual_order('', '', '', '', '', '', '', $status, $distribute_user_id);
//        $dao = \Dao::fx_virtual_order();
//        $is_pay = $dao->getList($model, ['order_sn', 'pay_money']);
//        return $is_pay['list'];
//    }

}
