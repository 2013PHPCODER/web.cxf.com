<?php

namespace Common\Controller;

use Common\Controller\BasicController;

class AuthController extends BasicController {

    // public function _initialize() {
    //     if (!$_SESSION['user'] && !$_SESSION['auth']) {             //登录检查
    //         $this->redirect('system/login/index');
    //     }

    //     $target = strtolower(__ACTION__);     //获得权限模块，控制器，方法
    //     $target = trim($target, '/');
    //     $target = explode('/', $target);
    //     $module = $target[0];
    //     $controller = $target[1];
    //     $action = $target[2];

    //     $this->checkAuth($module, $controller, $action);                                                              //权限检查
    //     $this->recordOperate($module, $controller);                                                                //日志记录
    // }

    // private function checkAuth($module, $controller, $action) {

    //     $auth = session('auth');
    //     $bool = $auth[$module][$controller][$action] || $auth[$module][$controller] === '*';              //权限判断
    //     $super_root = isset($auth['all']) && $auth['all'] == 'all';                //是否为超级管理
    //     if (!$bool && !$super_root) {                                           //超级管理可跳过验证
    //         $this->redirect('system/index/index');
    //     }
    // }

    // private function recordOperate($module, $controller) {
    //     if ($module === 'system' && $controller === 'index') {                  //忽略管理员访问首页的记录
    //         return;
    //     }
    //     $data = ['admin_user_id' => session('user.id'), 'detail' => $_SERVER['REQUEST_URI'], 'module' => $module, 'add_time' => time()];
    //     M('fx_admin_logs')->add($data);
    // }

    // protected function aReturn($status = 1, $message, $data = false) {
    //     $d['status'] = $status;
    //     $d['message'] = $message;
    //     $d['returnData'] = $data;
    //     die($this->ajaxReturn($d, 'JSON'));
    // }

}
