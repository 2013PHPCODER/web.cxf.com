<?php
namespace System\Controller;
use Common\Controller\BasicController as Auth;

class IndexController extends Auth{			//管理员首页
	
	public function index(){			//显示管理员操作信息

		C('TOKEN_ON', false);				//关闭表单token
		$data=I('get.');
		$p=(int) $data['p']? :1;			
		
		$module=$data['module'];
		$time1=strtotime($data['time1']);
		$time2=strtotime($data['time2']);

		if ($time2<$time1 && $time2>0) {			//保证time2大于time1, time2可能为0
			$tmp=$time2;
			$time2=$time1;
			$time1=$tmp;
		}

		$module && ($condition['a.module']=$module);			//生成条件
		$time1 && $time2 && ($condition['a.add_time']=['between', [$time1, $time2]] );
		$time1 && !$time2 && ($condition['a.add_time']=['egt', $time1] );
		!$time1 && $time2 && ($condition['a.add_time']=['elt', $time2] );

		$condition['a.user_id']=$this->user_info['id'];
		$condition['a.user_type']=1;
		$para['condition']=$condition;
		$para['p']=$p;


		$r=R('QuerySql/logs', [$para], 'Dal');

		foreach ($r['list'] as &$v) {			//数据处理
			$v['add_time']=date('Y-m-d H:i:s', $v['add_time']);
			$v['module']=C('MODULE_NAME.'. strtolower($v['module']) );
		}


		$modules=C('MODULE_NAME');				//显示模块列表
		$this->assign('modules', $modules);
		$this->assign('list', $r['list']);
		$this->assign('total', $r['total']);
		
		$this->display();

	}


	public function edit(){					//管理员密码修改
		$post=I('post.');
		$pw1=$post['pw1'];
		$pw2=$post['pw2'];
		$old=$post['old'];
		$bool=$pw1 && $pw2 && $old;
		if (!$bool) {
			$this->ajaxReturn(\status::error('需填写旧密码和新密码'));
			return;
		}
		if ($pw1 !==$pw2) {					//两次新密码不一致
			$this->ajaxReturn(\status::error('输入的新密码不一致'));
			return;			
		}
		$condition=['admin_user_id'=>session('user.id'), 'pwd'=>PWD($old)];
		if (!M('fx_admin_user')->where($condition)->field('admin_user_id')->find()) {			//检查密码是否正确
			$this->ajaxReturn(\status::error('当前登录密码错误'));
			return;	
		}								
		$condition['admin_user_id']=session('user.id');
		$data=['pwd'=>PWD($pw1), 'update_time'=>time()];
		$para=['condition'=>$condition, 'data'=>$data ];

		$r=R('UpdateSql/editAdminSelf', [$para], 'Dal');
		$r=$r? \status::success('修改密码成功'): \status::failed('密码修改失败，请重新尝试');
		$this->ajaxReturn($r);
	}
}