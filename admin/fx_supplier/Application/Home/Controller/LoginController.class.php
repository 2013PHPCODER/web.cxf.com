<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 登录控制器
 * @author shengjiangtou
 */
class LoginController extends Controller{

    public function __construct(){
        parent::__construct();
        layout(false);
    }

    public function index(){
        $this->assign('username',Cookie('username'));
        $this->assign('password',Cookie('password'));
        $this->display('login');
    }

    public function login(){
        if(IS_POST){
            $username = I('post.username');
            $passwd = I('post.password');
            if(!empty($username) && !empty($passwd)){
                $userinfo = M('fx_supplier_user')->where(array('username'=>$username))->find();
                if(!empty($userinfo)){
//                    if($userinfo['status'] == 0){
//                        $this->assign("msg",'无权登陆,请联系管理员！');
//                    }else{
//                        $upwd = md5($passwd);
                    $upwd = $passwd;
                    if($userinfo['userpwd'] === $upwd){
                        $rember = I('post.remeberMe');
                        //记住密码
                        if($rember == 'on'){
                            Cookie('username',$username,time() + 3600 * 24);
                            Cookie('password',$passwd,time() + 3600 * 24);
                        }else{
                            Cookie('username',NULL);
                            Cookie('password',NULL);
                        }
                        session('user_info',$userinfo,3600);
                        $this->assign("jumpUrl",U('home/user/index'));
                        $this->success('登陆成功！');
                        return FALSE;
                    }else{
                        $this->assign("msg",'用户名或密码错误！');
                    }
//                    }
                }else{
                    $this->assign("msg",'用户名或密码错误！');
                }
            }
        }
        $this->assign('username',Cookie('username'));
        $this->assign('password',Cookie('password'));
        $this->display();
    }

    /**
     * 退出登录
     */
    public function logout(){
        session('user_info',null);
        $this->assign("jumpUrl",U('home/login/index'));
        $this->success('退出登陆！');
    }

}
