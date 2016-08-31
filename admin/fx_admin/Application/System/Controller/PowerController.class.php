<?php
namespace System\Controller;
use Common\Controller\AuthController as Auth;

class PowerController extends Auth{


	public function index(){			//显示员工列表
		C('TOKEN_ON', false);

		$data=I('get.');
		$status=(int) $data['status'];
		$name=$data['name'];

		$status && ($condition['status']=$status);
		$name && ($condition['name']=$name);	

		$r=R('QuerySql/adminList', [$condition], 'Dal');

		foreach ($r as $index=>&$v) {									//处理数据
			$v['add_time']=f_int2date($v['add_time']);
			$v['update_time']=f_int2date($v['update_time']);
			$v['auth']=json_decode($v['auth'], true);
			$v['status']=$v['status']? '是': '否';
			if ($v['auth']['all']) {					//排除掉超级管理员
				unset($r[$index]);	
			}			
		}
		$this->assign('list', $r);
		$this->display();
	}
	public function editShow(){					//显示编辑页面
		C('TOKEN_ON', false);
		$condition=['admin_user_id'=>I('get.id','','intval')];
		$r=R('QuerySql/adminDetail', [$condition], 'Dal');


		$r['add_time']=f_int2date($r['add_time']);
		$r['update_time']=f_int2date($r['update_time']);
		$r['auth']=json_decode($r['auth'], true);
		$r['status']=$r['status']? '在职': '离职';

		$this->assign('q', $r);	
		$this->assign('auth', showAuth($r['auth']));			//权限显示列表
		$this->display();
	}



	public function addOperator(){		//增加员工
		$post=I('post.');

		$data['account']=$post['account'];
		$data['name']=$post['name'];
		$data['pwd']=$post['pwd']? encodePwd($post['pwd']): encodePwd('123456');		//默认密码，123456
		$data['status']=(int) $post['status'];									
		$data['auth']=json_encode(['system'=>['index'=>'*']]);				//默认权限是个人中心
		$data['add_time']=time();
		$rules=[
			'valid'=>['is_lte20'=>['name'], 'is_lte50'=>['account']],
			'format'=>['intval'=>['status']],

		];


		$valid=new \valid();							//验证数据
		$valid->run($rules, $data);
		if ($valid->error) {							//失败返回
			$this->error($valid->error);			
		}

		$condition=['account'=>$data['account'], 'name'=>$data['name'], '_logic'=> 'OR'];
		if (M('fx_admin_user')->field('admin_user_id')->where($condition)->find()) {					//验证数据库是否重复
			$this->error('账号或姓名已存在，请更换');
		}


		$r=R('AddSql/admin', [$valid->data], 'Dal');		
		if ($r) {
			$this->success('添加管理员成功');
		}else{
			$this->error('添加失败，请重新尝试');
		}

	}			

	public function editOperator(){			//编辑员工
		$post=I('post.');

		$post['status'] === '' && ($data['status']=(int) $post['status']);
		$post['account'] && ($data['account']=$post['account']);
		$post['pwd'] && ($data['pwd']=PWD($post['pwd']));
		$post['name'] && ($data['name']=$post['name']);

		if (isset($data['name']) && !is_lte20($data['name'])) {				//验证name长度
			$this->error('name字段不可超过20位');
		}
		if (isset($data['account']) && !is_lte50($data['account'])) {				//验证修改账号长度
			$this->error('account字段不可超过50位');
		}

		$condition=['admin_user_id'=>(int) $post['id']];

		if ($post['auth']) {											//处理权限数据
			foreach ($post['auth'] as &$v) {					
				if (is_array($v)) {
					foreach ($v as &$v2) {
						$v2=array_flip($v2);
						foreach ($v2 as &$v3) {
						 	$v3=1;
						 } 
					}
				}
			}
			$post['auth']['system']['index']='*';			//管理员首页权限
		}
		$data['auth']=json_encode($post['auth'])? : json_encode(['system'=>['index'=>'*']]);			//没有授权则赋予默认权限
		$data['update_time']=time();
		$para=['data'=>$data, 'condition'=>$condition];

		R('UpdateSql/editAdmin', [$para], 'Dal');					//每次表单提交都为覆盖操作，所以默认成功
		$this->success('修改员工信息成功');


	}
	public function resetPwd(){						//重置密码
		if (IS_AJAX and $_POST['id']) {
			$condition=['admin_user_id'=>(int) $_POST['id']];
			$data=['pwd'=>PWD('123456')];
			$r=M('fx_admin_user')->where($condition)->save($data);
			$this->ajaxReturn(\status::success('重置密码成功'));
		}
		$this->ajaxReturn(\status::failed('缺少操作对象'));
	}

	public function changeStatus(){				//改变员工状态
		$status=(int) $_POST['status'];
		$id=(int) $_POST['id'];
		$condition=['admin_user_id'=>$id];
		$data=['status'=>$status];
		$r=M('fx_admin_user')->where($condition)->save($data);
		$r=$r? \status::success('操作成功'): \status::failed('操作失败');
		$this->ajaxReturn($r);
	}

	public function logs(){						//员工操作日志
		C('TOKEN_ON', false);

		$data=I('get.');
		$p=(int) $data['p']? :1;
		$id=(int) $data['id'];
		$module=$data['module'];
		$time1=strtotime($data['time1']);
		$time2=strtotime($data['time2']);

		if ($time2<$time1 && $time2>0) {			//保证time2大于time1, time2可能为0
			$tmp=$time2;
			$time2=$time1;
			$time1=$tmp;
		}


		$module && ($condition['a.module']=$module);			//生成条件
		$id && ($condition['a.admin_user_id']=$id);
		$time1 && $time2 && ($condition['a.add_time']=['between', [$time1, $time2]] );
		$time1 && !$time2 && ($condition['a.add_time']=['egt', $time1] );
		!$time1 && $time2 && ($condition['a.add_time']=['elt', $time2] );

		
		$para=['condition'=>$condition, 'p'=>$p];
		$r=R('QuerySql/logs', [$para], 'Dal');			//查询数据

		foreach ($r['list'] as &$v) {			//数据处理
			$v['add_time']=date('Y-m-d H:i:s', $v['add_time']);
			$v['module']=C('MODULE_NAME.'. strtolower($v['module']) );
		}

		$modules=C('MODULE_NAME');
		$users=R('QuerySql/adminNameList', '', 'Dal');			//查询数据
		$this->assign('list', $r['list']);
		$this->assign('total', $r['total']);
		$this->assign('users', $users);
		$this->assign('modules', $modules);
		$this->display();
	}

	public function supplierLogs(){						//供应商操作日志
		C('TOKEN_ON', false);

		$data=I('get.');
		$p=(int) $data['p']? :1;
		$key=$data['key'];
		$module=$data['module'];
		$time1=strtotime($data['time1']);
		$time2=strtotime($data['time2']);

		if ($time2<$time1 && $time2>0) {			//保证time2大于time1, time2可能为0
			$tmp=$time2;
			$time2=$time1;
			$time1=$tmp;
		}


		$module && ($condition['a.module']=$module);			//生成条件
		$key && ($condition['b.username']=$key);
		$time1 && $time2 && ($condition['a.add_time']=['between', [$time1, $time2]] );
		$time1 && !$time2 && ($condition['a.add_time']=['egt', $time1] );
		!$time1 && $time2 && ($condition['a.add_time']=['elt', $time2] );

		$condition['type']=1;
		$para=['condition'=>$condition, 'p'=>$p];
		$r=R('QuerySql/supplierlogs', [$para], 'Dal');			//查询数据

		foreach ($r['list'] as &$v) {			//数据处理
			$v['add_time']=date('Y-m-d H:i:s', $v['add_time']);
			$v['module']=C('MODULE_NAME.'. strtolower($v['module']) );
		}

		$modules=C('MODULE_NAME');
		$users=R('QuerySql/adminNameList', '', 'Dal');			//查询数据
		$this->assign('list', $r['list']);
		$this->assign('total', $r['total']);
		$this->assign('users', $users);
		$this->assign('modules', $modules);
		$this->display();
	}

}