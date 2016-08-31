<?php
namespace System\Controller;
use Think\Controller;
/**
 * 
 */
class LoginController extends Controller{
    public function index(){
    	if ($_SESSION['user'] && $_SESSION['auth']) {          // 已登录则跳转到首页
    		$this->redirect('system/index/index');
    	}
        $this->display('login');
    }

    public function login(){
    	if ($_SESSION['_wrongtimes_'] > 5) {				//只限制当前浏览器
    		$this->error('密码错误次数超限，请联系超级管理员解锁');
    	}
        $post=I('post.');										//登录查询

        $condition=['account'=>$post['username']];
        $r=M('fx_admin_user')->where($condition)->field('admin_user_id as id, name, pwd, status, auth')->find();
        if (!$r || !verifyPwd($post['password'], $r['pwd'])){
        	$_SESSION['_wrongtimes_']+=1;
        	$this->error('账号密码错误');
        }

        if (!$r['status']) {
        	$this->error('账号被冻结');
        }
        					
                            	
        $auth=json_decode($r['auth'], true);
        unset($r['auth']);                        								            //登录处理
        $_SESSION['user']=$r;
        $_SESSION['auth']=$auth;                                                            //权限，php判断用
        $_SESSION['auth_show']=[];                                                          //权限，js判断显示用
        if (isset($auth['all']) && $auth['all'] ==='all') {
            $_SESSION['auth_show']['all']='all';
        }else{
            foreach ($_SESSION['auth'] as $module_name => $controllers) {
                $module_name=strtoupper($module_name);
                if ($controllers === '*') {
                    array_push($_SESSION['auth_show'], $module_name);
                    continue;
                }

                foreach ($controllers as $controller_name => $actions) {
                    $controller_name=strtoupper($controller_name);
                    if ($actions === '*') {
                        array_push($_SESSION['auth_show'], $module_name. '/'. $controller_name);
                        continue;
                    }
                    foreach ($actions as $action_name => $v) {
                        $action_name=strtoupper($action_name);
                        array_push($_SESSION['auth_show'], $module_name. '/'. $controller_name. '/'. $action_name);
                    }
                    
                }
            }

        }

        unset($r, $condition, $arr, $tmp);
        $this->redirect('system/index/index');
        
    }

    public function logout(){
    	session(null);
    	$this->redirect('system/login/index');
    }
}
