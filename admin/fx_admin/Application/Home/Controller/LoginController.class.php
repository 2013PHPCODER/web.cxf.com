<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 
 */
class LoginController extends Controller{

    public function index(){
        // dump(C('LAYOUT_ON'));
    	if ($_SESSION['user'] && $_SESSION['auth']) {
    		$this->redirect('index/index');
    	}
        $this->display('login');
    }

    public function login(){
    	if ($_SESSION['_wrongtimes_'] > 5) {				//只限制当前浏览器
    		$this->error('密码错误次数超限，请联系超级管理员解锁');
    	}
        //vendor("TBAPI.TAOBAO",'','.php');
        $post=I('post.');										//登录查询

        $condition=['account'=>$post['username'], 'pwd'=>PWD($post['password'])];
        $r=M('fx_admin_user')->where($condition)->find();

        if (!$r) {
        	$_SESSION['_wrongtimes_']+=1;
        	$this->error('账号密码错误');
        }

        if (!$r['status']) {
        	$this->error('账号被冻结');
        }

        $id=$r['admin_user_id'];									//权限查询
        $condition=['b.admin_user_id'=>$id, 'a.status'=>1];
        $auth=M('fx_admin_role as a')->join('fx_admin_user_role as b on a.admin_role_id=b.admin_role_id')->where($condition)->field('auth')->select();

        $arr=[];
        foreach ($auth as &$v) {
        	$tmp=json_decode($v['auth'], true);
        	$arr=array_merge($arr, $tmp);
        }
        														//登录处理
        $_SESSION['user']=$r;
        $_SESSION['auth']=$arr;

        unset($r, $condition, $arr, $tmp);
        $this->redirect('index/index');
        
    }

    public function logout(){
    	session(null);
    	$this->redirect('login/index');
    }
}
