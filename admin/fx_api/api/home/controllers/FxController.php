<?php
namespace api\home;
class FxController extends Controller{

	public function login(){

		//1.拿参数
		$q=$this->request;
//		$q=new \stdclass();
//		$q->user_account='18501672561';
//		$q->password='123456';
//		$q->auto_login=1;

		!isset($q->user_account) || !isset($q->password) and myerror(\StatusCode::msgCheckFail, '请求参数缺失');

		//2.特殊校验
		\Valid::not_empty($q->user_account)->withError('用户名为空');
		\Valid::not_empty($q->password)->withError('密码为空');

		//4.操作数据
		$dao=\Dao::Fx_distribute_user();
		$type=is_mobile($q->user_account)? 'mobile': (is_email($q->user_account)? 'email': 'user_account');
		$r=$dao->login($q->user_account, $q->password, $type);


		if (!$r || !$r['user_id'] || !verifyPwd($q->password, $r['pwd'])) {
			myerror(\StatusCode::msgUserLoginError, '用户名或密码错误');
		}
		empty($r['user_nickname']) && $r['user_nickname']=$r['user_account'];
		unset($r['pwd']);			//删除密码
		$r['msg_count']=\Dao::Fx_notice()->count(\Model::Fx_notice());		//消息数量
		$tb=\Dao::Fx_tb_user()->getList(\Model::Fx_tb_user('', $r['user_id']), ['tb_user_id', 'nick as tb_user_nick']);

		$r['taobao_bind']=$tb? $tb['list']: [];

		//查询token
		$auto_login=isset($q->auto_login) && $q->auto_login==1? 1: 0;			//自动登录与否
		$token_dao=\Dao::Fx_token();
		$token=$token_dao->getTokenWithId($r['user_id'], $auto_login);				


		$r['user_level_str']=f_level($r['user_level']);
		$token=f_token($token);							//加密以及格式化token
		$this->response=array_merge($r, $token);


		//5，返回
		$this->response();


		//6记录登录时间

		$dao->recordLoginTime($r['user_id']);


	}

	public function refreshLogin(){				//使用refresh获得token，达到自动登录
		$q=$this->request;
		// $q=new \stdclass();
		// $q->user_id='1';
		// $q->refresh='64a6dd39a0658c4180d4a96e90ce99fb8a1657f5';

		!isset($q->user_id) || !isset($q->refresh) and myerror(\StatusCode::msgCheckFail, '请求参数缺失');

		$dao=\Dao::Fx_token();
		$token=$dao->getTokenWithRefresh($q->user_id, $q->refresh);
		$token=f_token($token);	

		unset($token['token']['refresh_token'], $token['token']['refresh_overtime'], $token['token']['refresh_nexttime']);

		$dao=\Dao::Fx_distribute_user();
		$r=$dao->loginWithId($q->user_id);

		if (!$r) {
			myerror(\StatusCode::msgFailStatus, '响应失败，数据库缺少数据');
		}

		$r['msg_count']=\Dao::Fx_notice()->count(\Model::Fx_notice());		//消息数量
		$tb=\Dao::Fx_tb_user()->getList(\Model::Fx_tb_user($r['user_id']), ['tb_user_id', 'nick as tb_user_nick']);
		$r['taobao_bind']=$tb? $tb['list']: [];

		$this->response=array_merge($r, $token);
		$this->response();
	}

	public function checkRegiste(){				//查重
		$q=$this->request;						//获得参数
		// $q=new \stdclass();
		// $q->email='123456@163.com';
		// $q->mobile='13680465044';		
		// $q->type=2;
		batch_isset($q, ['type']);
		$dao=\Dao::Fx_distribute_user();
		if ($q->type ==2) {						//邮箱注册
			batch_isset($q, ['email']);
			\Valid::is_email($q->email)->withError('邮箱格式不对');	
			$exist=$dao->checkExist($q->email, 'email');				//检查是否存在邮箱手机
		}else{
			batch_isset($q, ['mobile']);
			\Valid::is_mobile($q->mobile)->withError('不是手机号码');
			$exist=$dao->checkExist($q->mobile, 'mobile');
		}
		
		$exist['mobile'] && myerror(\StatusCode::msgExistMobile, '手机号已存在');		
		$exist['email'] && myerror(\StatusCode::msgExistEmail, '邮箱已存在');

		$this->response('可以注册');

	}

	public function regist(){

		$q=$this->request;						//获得参数
		// $q=new \stdclass();
		// $q->email='10007292@qq.com';
		// $q->mobile='13680465044';
		// $q->password='123456';
		// $q->qq='1000729';
		// $q->type=1;
		// $q->password2='123456';
		// $q->code='123';
		batch_isset($q, ['password2', 'password', 'qq', 'type', 'code']);


		$model=\Model::Fx_distribute_user();
		$dao=\Dao::Fx_distribute_user();	

		if ($q->type ==2) {						//邮箱注册
			batch_isset($q, ['email']);
			\Valid::is_email($q->email)->withError('邮箱格式不对');	
			$model->email=$q->email;
			$model->reg_type=2;
			$exist=$dao->checkExist($model->email, 'email');				//检查是否存在邮箱手机
			checkVerifyCode('fx_registe', $q->email, $q->code);							//检查邮箱验证码
		}else{
			batch_isset($q, ['mobile']);
			\Valid::is_mobile($q->mobile)->withError('不是手机号码');
			$model->mobile=$q->mobile;	
			$model->reg_type=1;
			$exist=$dao->checkExist($model->mobile, 'mobile');
			checkVerifyCode('fx_registe', $q->mobile, $q->code);							//检查手机证码
		}
		\Valid::is_equality($q->password, $q->password2)->withError('两次密码输入不一致');
			
		$exist['mobile'] && myerror(\StatusCode::msgExistMobile, '手机号已存在');		
		$exist['email'] && myerror(\StatusCode::msgExistEmail, '邮箱已存在');

		$model->userpwd=encodePwd($q->password);						//赋值
		$model->qq=$q->qq;
		$model->user_account=create_user_account();

		$model->addtime=date('Y-m-d H:i:s');
                $model->account_status = \account_status::yes;
                
		$r=$dao->insert($model);				//写库
		$r? $this->response('注册成功'): myerror(\StatusCode::msgDBInsertFail, '注册失败');
	}

	public function create_user_account(){
		return 'cxf_'.uniqid().mt_rand(0,1000);
	}	

	
}