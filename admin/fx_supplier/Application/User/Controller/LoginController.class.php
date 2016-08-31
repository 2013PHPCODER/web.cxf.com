<?php

namespace User\Controller;

use Think\Controller;

/**
 * 登录控制器
 * @author shengjiangtou
 */
class LoginController extends Controller {

    public function __construct() {
        parent::__construct();
        layout(false);
    }

    public function index() {
        $this->assign('username', Cookie('username'));
        $this->assign('password', Cookie('password'));
        $this->display('login');
    }

    public function login() {
        if (IS_POST) {
            $username = I('post.username');
            $passwd = I('post.password');
            if (!empty($username) && !empty($passwd)) {
                $condition['user_account'] = $username;
                $condition['email'] = $username;
                $condition['mobile'] = $username;
                $condition['_logic'] = 'OR';
                $userinfo = M('fx_supplier_user')->where($condition)->find();
                if (!empty($userinfo)) {
                    if ($userinfo['account_status'] == 2) {
                        if (password_verify($passwd, $userinfo['userpwd'])) {
                            $rember = I('post.remeberMe');
                            //记住密码
                            if ($rember == 'on') {
                                Cookie('username', $username, time() + 3600 * 24);
                                Cookie('password', $passwd, time() + 3600 * 24);
                            } else {
                                Cookie('username', NULL);
                                Cookie('password', NULL);
                            }
                            if ($userinfo['approve_status'] != 3) {
                                $this->redirect('http://supplier.mycxf.com/supplier_submit_auth.php?user_id=' . $userinfo['id']);
                                return false;
                            }
                            session('user_info', $userinfo, 3600);
                            $this->redirect('system/index/index');
                            return FALSE;
                        } else {
                            $this->assign("msg", '用户名或密码错误！');
                        }
                    } else {
                        $this->assign("msg", '无权登陆,请联系管理员！');
                    }
                } else {
                    $this->assign("msg", '用户名或密码错误！');
                }
            }
        }
        $this->assign('username', Cookie('username'));
        $this->assign('password', Cookie('password'));
        $this->display();
    }

    /**
     * 退出登录
     */
    public function logout() {
        session('user_info', null);
        $this->redirect('user/login/index');
    }

}
