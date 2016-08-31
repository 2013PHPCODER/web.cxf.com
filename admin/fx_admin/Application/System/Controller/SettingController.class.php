<?php
namespace System\Controller;
use Common\Controller\AuthController as Auth;

class SettingController extends Auth{			//财务设置和用户等级设计
	
	public function finance(){			//显示收款信息

		$r=M('fx_receiver_account')->select();
		foreach ($r as &$v) {
			$v['update_time']=f_int2date($v['update_time']);
		}

		foreach ($r as &$v) {
			$v['receiver_platform_code']=$v['receiver_platform'];
			switch ($v['receiver_platform']) {
				case '1':
					$v['receiver_platform']='支付宝';
					break;
				case '2':
					$v['receiver_platform']='银行卡';
					break;
				case '3':
					$v['receiver_platform']='微信';
					break;									
			}
		}
		$this->assign('list', $r);
		$this->display();

	}

	public function editFinance(){			//	收款设置编辑
		$post=I('post.');
		$bool=$post['platform'] && $post['account'] && $post['name'] && $post['id'];
		if (!$bool) {																		//校验数据完整性
			$this->error('信息填写不完整');
		}
		$data=[
			'receiver_platform'=>$post['platform'],
			'receiver_name'=>$post['name'],
			'receiver_account'=>$post['account'],
			'update_user'=>session('user.name'),
			'update_time'=>time(),
		];
		$condition=['id'=>(int) $post['id']];
		$r=M('fx_receiver_account')->where($condition)->save($data);								//写入
		if ($r) {
			$this->success('新增收款账号成功');
		}else{
			$this->error('新增失败，请重新尝试');
		}		
	}
	public function addFinance(){			//新增收款信息
		$post=I('post.');
		$bool=$post['platform'] && $post['account'] && $post['name'];
		if (!$bool) {																		//校验数据完整性
			$this->error('信息填写不完整');
		}
		$data=[
			'receiver_platform'=>$post['platform'],
			'receiver_name'=>$post['name'],
			'receiver_account'=>$post['account'],
			'update_user'=>session('user.name'),
			'update_time'=>time(),
		];
		$r=M('fx_receiver_account')->add($data);								//写入
		if ($r) {
			$this->success('新增收款账号成功');
		}else{
			$this->error('新增失败，请重新尝试');
		}
	}

	public function level(){					//显示分销商，供货商等级
		$s=M('fx_supplier_level')->select();			// 供应商
		foreach ($s as &$v) {
			$v['update_time']=f_int2date($v['update_time']);
		}
		$d=M('fx_distribute_level')->select();			// 分销商
		foreach ($d as &$v) {									// 数据处理
			$v['update_time']=f_int2date($v['update_time']);
			$v['price']= intval($v['price']*100);
		}

		$this->assign('d', $d);
		$this->assign('s', $s);
		$this->display();
	}

	public function editDistribute(){			//编辑分销商等级
		$post=$_POST;
		strlen($post['l1'])>0 && ($c1=['level'=>1]) && ($d1=['price'=>round($post['l1']/100,2), 'update_user'=>session('user.name'), 'update_time'=>time() ] );
		strlen($post['l2'])>0 && ($c2=['level'=>2]) && ($d2=['price'=>round($post['l2']/100,2), 'update_user'=>session('user.name'), 'update_time'=>time() ] );
		strlen($post['l3'])>0 && ($c3=['level'=>3]) && ($d3=['price'=>round($post['l3']/100,2), 'update_user'=>session('user.name'), 'update_time'=>time() ] );
		
		$conn=M('fx_distribute_level');									
		for ($i=1; $i <4 ; $i++) { 				//写入数据
			$c='c'.$i;
			$d='d'.$i;			
			if (isset(${$c})) {
				$j+=$conn->where(${$c})->save(${$d});					//判断是否修改成功标识
			}
		}
		
		if ($j) {
			$this->success('修改成功');
		}else{
			$this->error('修改供货商等级失败');
		}

	}
	public function editSupplier(){			//编辑供货商等级
		$post=$_POST;
		strlen($post['l1'])>0 && ($c1=['level'=>1]) && ($d1=['num'=>intval($post['l1']), 'update_user'=>session('user.name'), 'update_time'=>time() ] );
		strlen($post['l2'])>0 && ($c2=['level'=>2]) && ($d2=['num'=>intval($post['l2']), 'update_user'=>session('user.name'), 'update_time'=>time() ] );
		strlen($post['l3'])>0 && ($c3=['level'=>3]) && ($d3=['num'=>intval($post['l3']), 'update_user'=>session('user.name'), 'update_time'=>time() ] );

		$conn=M('fx_supplier_level');									
		for ($i=1; $i <4 ; $i++) { 				//写入数据
			$c='c'.$i;
			$d='d'.$i;
			if (isset(${$c})) {
				$j+=$conn->where(${$c})->save(${$d});					//判断是否修改成功标识
			}
		}
		if ($j) {
			$this->success('修改成功');
		}else{
			$this->error('修改供货商等级失败');
		}

	}




}