<?php

namespace User\Controller;

//use Think\Controller;
use Org\Util\YHttp;
use Common\Controller;

/**
 * 公共控制器
 * @author xlufei
 * 
 *
 */
class CommonController extends Controller\AuthController {

    function _initialize() {
        //处理浏览器时间传输问题
        $_GET['startTime'] = str_replace('+', ' ', I('get.startTime'));
        $_GET['endTime'] = str_replace('+', ' ', I('get.endTime'));
    }

    /**
     * 组装搜索时间条件
     * @param type $_time
     * @return array
     * 
     */
    function timeSearch($_time) {
        // 选择时间
        switch ($_time) {
            case 1:
                $startTime = date("Y-m-d 00:00:00", time());
                $endTime = date("Y-m-d 23:59:59", time());
                $_get['addtime'] = array('between', array($startTime, $endTime));
                break;
            case 2:
                $startTime = date("Y-m-d 00:00:00", strtotime('-7 day'));
                $endTime = date("Y-m-d 23:59:59", time());
                $_get['addtime'] = array('between', array($startTime, $endTime));
                break;
            case 3:
                $startTime = date("Y-m-d 00:00:00", strtotime('-30 day'));
                $endTime = date("Y-m-d 23:59:59", time());
                $_get['addtime'] = array('between', array($startTime, $endTime));
                break;
            default:
                break;
        }
        return $_get['addtime'];
    }

    /*
     * 组装分销商搜索条件
     * @return $_get 搜索条件
     */

    public function disSearchWhere() {
        // 用户等级
        $leavel = I('get.dengji');
        if (NULL !== intval($leavel) && '' !== $leavel) {
            $_get['leavel'] = I('get.dengji');
        }
        // 状态
        $account_status = I('get.zhaungtai', '');
        if (!empty($account_status)) {
            $_get['account_status'] = $account_status;
        }
        // 来源
        $source = I('get.laiyuan', '');
        if (!empty($source)) {
            $_get['source'] = $source;
        }
        // 搜索条件
        $search = I('get.order_search', '');
        switch ($search) {
            case 1:
                $_get['email'] = array('LIKE', '%' . I('get.search_word') . '%');
                break;
            case 2:
                $_get['usernick'] = array('LIKE', '%' . I('get.search_word') . '%');
                break;
            case 3:
                $_get['mobile'] = array('LIKE', '%' . I('get.search_word') . '%');
                break;
            default:
                break;
        }
        // 选择时间
        $_time = I('get.time');
        if ($_time) {
            $_get['addtime'] = $this->timeSearch($_time);
        }
        //自定义时间
        $startTime = I('get.startTime', '');
        $endTime = I('get.endTime', '');
        if (!empty($startTime) && !empty($endTime)) {
            $_get['addtime'] = array('between', array("$startTime", "$endTime"));
        }
        return $_get;
    }

    /**
     * 供应商搜索条件
     * 
     */
    public function supplierSearchWhere() {
        //  申请时间搜索
        // 选择时间        
        $_time = I('get.add_time');
        if ($_time) {
            $_get['addtime'] = $this->timeSearch($_time);
        }
        //自定义时间
        $startTime = I('get.startTime', '');
        $endTime = I('get.endTime', '');
        if (!empty($startTime) && !empty($endTime)) {
            $_get['addtime'] = array('between', array("$startTime", "$endTime"));
        }
        //审核时间搜索
        // 选择时间        
        $_time = I('get.check_time');
        if ($_time) {
            $_get['approve_time'] = $this->timeSearch($_time);
        }
        //自定义时间
        $check_startTime = I('get.check_startTime', '');
        $check_endTime = I('get.check_endTime', '');
        if (!empty($startTime) && !empty($endTime)) {
            $_get['approve_time'] = array('between', array("$check_startTime", "$check_endTime"));
        }
        // 状态
        $account_status = I('get.zhuangtai', '');
        if (!empty($account_status)) {
            $_get['approve_status'] = $account_status;
        }
        // 搜索条件
        $search = I('get.order_search', '');
        switch ($search) {
            case 1:
                $_get['email'] = array('LIKE', '%' . I('get.search_word') . '%');
                break;
            case 2:
                $_get['usernick'] = array('LIKE', '%' . I('get.search_word') . '%');
                break;
            case 3:
                $_get['mobile'] = array('LIKE', '%' . I('get.search_word') . '%');
                break;
            default:
                break;
        }
        return $_get;
    }

    /*
     * 组装代理商搜索条件
     * @return $_get 搜索条件
     */

    public function actSearchWhere() {
        // 用户等级
        $leavel = I('get.dengji');
        if (NULL !== intval($leavel) && '' !== $leavel) {
            $_get['a.leavel'] = I('get.dengji');
        }
        // 状态
        $account_status = I('get.zhaungtai', '');
        if (!empty($account_status)) {
            $_get['fx_distribute_user.account_status'] = $account_status;
        }
        // 来源
        $source = I('get.laiyuan', '');
        if (!empty($source)) {
            $_get['fx_distribute_user.source'] = $source;
        }
        // 搜索条件
        $search = I('get.order_search', '');
        switch ($search) {
            case 1:
                $_get['fx_distribute_user.email'] = array('LIKE', '%' . I('get.search_word') . '%');
                break;
            case 2:
                $_get['fx_distribute_user.usernick'] = array('LIKE', '%' . I('get.search_word') . '%');
                break;
            case 3:
                $_get['fx_distribute_user.mobile'] = array('LIKE', '%' . I('get.search_word') . '%');
                break;
            default:
                break;
        }
        // 选择时间
        $_time = I('get.time');
        if ($_time) {
            switch ($_time) {
                case 1:
                    $startTime = date("Y-m-d 00:00:00", time());
                    $endTime = date("Y-m-d 23:59:59", time());
                    $_get['fx_distribute_user.addtime'] = array('between', array($startTime, $endTime));
                    break;
                case 2:
                    $startTime = date("Y-m-d 00:00:00", strtotime('-7 day'));
                    $endTime = date("Y-m-d 23:59:59", time());
                    $_get['fx_distribute_user.addtime'] = array('between', array($startTime, $endTime));
                    break;
                case 3:
                    $startTime = date("Y-m-d 00:00:00", strtotime('-30 day'));
                    $endTime = date("Y-m-d 23:59:59", time());
                    $_get['fx_distribute_user.addtime'] = array('between', array($startTime, $endTime));
                    break;
                default:
                    break;
            }
        }
        //自定义时间
        $startTime = I('get.startTime', '');
        $endTime = I('get.endTime', '');
        if (!empty($startTime) && !empty($endTime)) {
            $_get['fx_distribute_user.addtime'] = array('between', array("$startTime", "$endTime"));
        }
        return $_get;
    }

    /**
     * 代理商销售详情搜索条件组装
     * @return array
     * 
     */
    function actSaleSearch() {
        // 用户等级
        $leavel = I('get.dengji');
        if (NULL !== intval($leavel) && '' !== $leavel) {
            $_get['leavel'] = I('get.dengji');
        }
        //分销商账号
        if (I('get.fxzh')) {
            $_get['fx_distribute_user.account'] = array('LIKE', '%' . I('get.fxzh') . '%');
        }
        // 选择时间
        $_time = I('get.time');
        if ($_time) {
            switch ($_time) {
                case 1:
                    $startTime = date("Y-m-d 00:00:00", time());
                    $endTime = date("Y-m-d 23:59:59", time());
                    $_get['fx_distribute_user.addtime'] = array('between', array($startTime, $endTime));
                    break;
                case 2:
                    $startTime = date("Y-m-d 00:00:00", strtotime('-7 day'));
                    $endTime = date("Y-m-d 23:59:59", time());
                    $_get['fx_distribute_user.addtime'] = array('between', array($startTime, $endTime));
                    break;
                case 3:
                    $startTime = date("Y-m-d 00:00:00", strtotime('-30 day'));
                    $endTime = date("Y-m-d 23:59:59", time());
                    $_get['fx_distribute_user.addtime'] = array('between', array($startTime, $endTime));
                    break;
                default:
                    break;
            }
        }
        //自定义时间
        $startTime = I('get.startTime', '');
        $endTime = I('get.endTime', '');
        if (!empty($startTime) && !empty($endTime)) {
            $_get['fx_distribute_user.addtime'] = array('between', array("$startTime", "$endTime"));
        }
        return $_get;
    }

}
