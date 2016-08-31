<?php

namespace Common\Controller;

use Think\Controller;

class AuthController extends Controller {

    public function _initialize() {
        if (!$_SESSION['user'] && !$_SESSION['auth']) {             //登录检查
            $this->redirect('system/login/index');
        }

        $target = strtolower(__ACTION__);     //获得权限模块，控制器，方法
        $target = trim($target, '/');
        $target = explode('/', $target);
        $module = $target[0];
        $controller = $target[1];
        $action = $target[2];

        $this->checkAuth($module, $controller, $action);                                                              //权限检查
        $this->recordOperate($module, $controller);                                                                //日志记录
    }

    private function checkAuth($module, $controller, $action) {

        $auth = session('auth');
        $has_auth = $auth[$module][$controller][$action] || $auth[$module][$controller] === '*' || $auth[$module] === '*';              //权限判断
        $super_root = isset($auth['all']) && $auth['all'] == 'all';                //是否为超级管理
        if (!$has_auth && !$super_root) {                                           //超级管理可跳过验证
            $this->redirect('system/index/index');
        }
    }

    private function recordOperate($module, $controller) {
        if ($module === 'system' && $controller === 'index') {                  //忽略管理员访问首页的记录
            return;
        }
        $detail = __ACTION__;
        $get = $_GET ? ' | get:' . json_encode($_GET, JSON_UNESCAPED_UNICODE) : '';
        $post = $_POST ? ' | post:' . json_encode($_POST, JSON_UNESCAPED_UNICODE) : '';
        $detail.=$get . $post;
        $data = ['admin_user_id' => session('user.id'), 'detail' => $detail, 'module' => $module, 'add_time' => time()];
        M('fx_admin_logs')->add($data);
    }

    protected function aReturn($status = 1, $message, $data = false) {
        $d['status'] = $status;
        $d['message'] = $message;
        $d['returnData'] = $data;
        die($this->ajaxReturn($d, 'JSON'));
    }

    /**
     * 操作日志记录
     * @param type $user_id 用户id
     * @param type $user_name 用户名
     * @param type $detail 日志详情
     */
    protected function log($detail) {
        $objSystemLog = M("fx_operate_logs");
        $data = array();
        $data["user_id"] = session('user.id');
        $data['user_name'] = session('user.name');
        $data['user_type'] = 2; //用户类型，1供货商，2后台管理员
        $data['module'] = MODULE_NAME;
        $data['url'] = U();
        $data["detail"] = $detail;
        $data['add_time'] = time();
        $data["ip"] = getIp();
        $data['request'] = json_encode(I());
        $objSystemLog->add($data);
    }

}
