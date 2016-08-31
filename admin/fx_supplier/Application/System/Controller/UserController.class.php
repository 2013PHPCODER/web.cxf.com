<?php
namespace System\Controller;
use Common\Controller\BasicController as Auth;

class UserController extends Auth{			//管理员首页

	public function index(){				//用户信息
		$this->assign('account',$this->user_info['user_account']);

		// $sms=new \sms('18581664121');
		// dump($_SESSION['_sms_']['18581664121']);die;
		// dump($sms->send());return;
		// $this->assign('mobile',$this->user_info['mobile']);
		$this->display();
	}
	public function bindMobile(){				//新增绑定手机
		if ($_SESSION['_pic_verified']) {
			unset($_SESSION['_pic_verified']);

			$post=I('post.');
			empty($post['mobile'])  || empty($post['sms']) and $this->ajaxReturn(\status::error('数据填写有误'));
			$this->is_mobile($post['mobile']) || $this->ajaxReturn(\status::error('手机号码有误'));
			!$this->is_mobileExist($post['mobile']) || $this->ajaxReturn(\status::error('手机号码已存在，请更换手机'));

			$sms=new \sms($post['mobile']);
			$result=$sms->verify();
			if ($result['status']=='success') {					//获得验证结果
				$data=['mobile'=>$post['mobile']];
				$r=M('fx_supplier_user')->where(['id'=>$this->user_info['id']])->save($data);
				$r=$r? \status::success('绑定成功'): \status::error('绑定失败');
				$this->ajaxReturn($r);
			}
			$this->ajaxReturn($result);
		}else{
			$this->ajaxReturn(\status::error('非法请求'));
		}
	}

	public function modifyMobile(){				//修改手机号第一步，验证老手机
		$sms=new \sms($this->user_info['mobile']);
		$result=$sms->verify();
		if ($result['status']=='success') {						//老手机号短信验证通过
			$_SESSION['_oldMoblie_verified']=1;
			$_SESSION['_pic_verified']=1;
			$this->ajaxReturn(\status::success());
			
		}else{
			$this->ajaxReturn(\status::error('短信验证码错误'));
			return;			
		}
	}


	public function smsFromForm(){				//发送短信，手机号来自form
		$post=I('post.');
		$bool=$this->is_mobile($post['mobile']);
		if (!$bool) {															//验证手机
			$this->ajaxReturn(\status::error('手机号码错误'));
			return;
		}
		if ($_SESSION['_pic_verified']!=1) {				//如果没有图形验证码通过标识
			$verify=$this->checkPicVerify($post['code']);
			if (!$verify) {														//验证图形码
				$this->ajaxReturn(\status::error('验证码错误'));
				return;
			}	
		}
		
	
								
		$exist=$this->is_mobileExist($post['mobile']);					//检查手机号是否被使用
		if ($exist) {
			$this->ajaxReturn(\status::error('手机号已被使用，请更换'));
			return;
		}
		$_SESSION['_pic_verified']=1;					//给出图形验证码已通过标记
		$sms=new \sms($post['mobile']);
		$this->ajaxReturn($sms->send());


	}
	public function smsFromDb(){				//发送短信，手机号来自数据库		//直接检查图形验证码
		$verify=$this->checkPicVerify($_POST['code']);				
		if (!$verify) {
			$this->ajaxReturn(\status::error('验证码错误'));
			return;
		}

		$sms=new \SMS($this->user_info['mobile']);
		$this->ajaxReturn($sms->send());		
	}



	public function picVerify(){				//图形验证码
		$config =    array(
		    'fontSize'    =>    50,    // 验证码字体大小
		    'length'      =>    4,
		    'useCurve'=>false, 
		);		
    	$verify = new \Think\Verify($config);
    	$verify->entry();
	}
	private function checkPicVerify($code){
		$verify = new \Think\Verify();
    	return $verify->check($code);
	}
	private function is_mobileExist($mobile){				//检查手机是否被注册
		$r=M('fx_supplier_user')->where(['mobile'=>$mobile])->getfield('id');
		return $r;
	}
	private function is_mobile($mobile){
		if (preg_match('/^1[3-9][0-9]{9}$/', subject)) {
			return true;
		}else{
			return true;
		}
	}

}