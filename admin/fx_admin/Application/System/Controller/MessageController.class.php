<?php
namespace System\Controller;
use Common\Controller\AuthController as Auth;

class MessageController extends Auth{

	public function index(){					//站内信列表

		C('TOKEN_ON', false);
		$get=I('get.');
		$p=(int) $get['p']? :1;			
		
		$time1=strtotime($get['time1']);
		$time2=strtotime($get['time2']);
		$sort=$get['sort'];
		$sort=$sort=='asc'? 'asc': 'desc';			//默认降序

		strlen($get['name'])>0 and $condition['adduser']=$get['name'];
		strlen($get['client'])>0 and $condition['to_client']=(int) $get['client'];
		$time1 && $time2 && ($condition['addtime']=['between', [$time1, $time2]] );
		$time1 && !$time2 && ($condition['addtime']=['egt', $time1] );
		!$time1 && $time2 && ($condition['addtime']=['elt', $time2] );		

		$para=['condition'=>$condition, 'p'=>$p, 'sort'=>$sort];
		$r=R('QuerySql/messageList', [$para], 'Dal');				//查询数据

		foreach ($r['list'] as $k => &$v) {
			f_int2date($v['addtime']);
			$v['client']=$v['to_client']==1? 'web端': '开店助理';
		}

		$users=R('QuerySql/adminNameList', '', 'Dal');			

		$this->assign('list', $r['list']);
		$this->assign('total', $r['total']);
		$this->assign('users', $users);
		$this->display();
	}


	public function add(){			// 新增公告
		$post=I('post.');
		empty($post['title']) || empty($post['content']) || empty($post['client']) and $this->error('请将内容填写完整');

		$data=['title'=>$post['title'], 
			'content'=>$post['content'], 'to_client'=>(int) $post['client'],
			'addtime'=>time(), 'adduser'=>session('user.name')
		];


		$r=R('addSql/notice', [$data], 'Dal');
		$r? $this->success('发布成功'): $this->error('发布失败');

	}

	public function edit(){				//编辑
		$post=I('post.');
		empty($post['title']) || empty($post['content']) || empty($post['client']) || empty($post['id']) and $this->error('请将内容填写完整');

		$data=['title'=>$post['title'], 
			'content'=>$post['content'], 'to_client'=>(int) $post['client'],
			'addtime'=>time(), 'adduser'=>session('user.name')
		];
		$condition=['id'=>(int) $post['id']];
		$para=['data'=>$data, 'condition'=>$condition];
		$r=R('updateSql/notice', [$para], 'Dal');
		$r? $this->success('发布成功'): $this->error('发布失败');		
	}
}