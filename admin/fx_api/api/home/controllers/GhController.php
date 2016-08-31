<?php
namespace api\home;
class GhController extends Controller{


	public function checkRegiste(){				//查重
		$q=$this->request;						//获得参数
		// $q=new \stdclass();
		// $q->email='12121@qq.com';

		batch_isset($q, ['email']);
		$dao=\Dao::Fx_supplier_user();

		\Valid::is_email($q->email)->withError('邮箱格式不对');	

		$exist=$dao->checkExist($q->email);
		$exist && myerror(\StatusCode::msgExistEmail, '邮箱已存在');

		$this->response('可以注册');

	}


	public function regist(){			
		$q=$this->request;
		// $q=new \stdClass();
		// $q->email='12007321119@qq.com';
		// $q->mobile='13582554224';
		// $q->password='123';
		// $q->password2='123';
		batch_isset($q, ['email', 'password', 'password2', 'code']);
		checkVerifyCode('gh_registe', $q->email, $q->code);


		\Valid::is_equality($q->password, $q->password2)->withError('两次输入密码不正确');
		\Valid::is_email($q->email)->withError('邮箱格式不对');


		$model=\Model::Fx_supplier_user();
		$model->email=$q->email;
		$model->userpwd=encodePwd($q->password);
		$model->user_account=create_user_account();
		$model->addtime=date('Y-m-d H:i:s', time());

		$dao=\Dao::Fx_supplier_user();
		$exist=$dao->checkExist($model->email);
	
		$exist && myerror(\StatusCode::msgExistEmail, '邮箱已存在');
		
		$r=$dao->insert($model);				//写库
		$r? $this->response(['user_id'=>$r, 'msg'=>'注册成功']): myerror(\StatusCode::msgDBInsertFail, '注册失败');

	}

	public function identify(){
		$q=$this->request;

		// $q=new \stdClass();

		// $q->user_id=1;
		// $q->apply_type=1;			//认证类型
		// $q->manager_category='232123';//
		// $q->apply_name='林澜叶';
		// $q->apply_idcard='5131234124412412';	
		// $q->apply_idcard_img=['asd.jpg','asd34.jpg'];	
		// $q->apply_idcard_img_hand=['asdd.jpg'];	//
		// $q->receiver_money_type=1;			
		// $q->receiver_account='asdho@api.com';
		// $q->receiver_account_name='lly';	
		// $q->qq='1009792';	
		// $q->wangwang='asdho@ho.com';	
		// $q->mobile='13979999991';

		$must=['user_id', 'manager_category', 'apply_name', 'apply_idcard',
			'apply_idcard_img', 'apply_idcard_img_hand', 'receiver_money_type', 'receiver_account',
			'receiver_account_name', 'qq', 'wangwang', 'mobile',
		];
		batch_isset($q, $must);
		$q->apply_type=(isset($q->apply_type) && $q->apply_type)? 1: 0;


		\Valid::has_valueInArray($q->apply_idcard_img)->withError('没有身份证照片');
		\Valid::has_valueInArray($q->apply_idcard_img_hand)->withError('没有手持身份证照片');
		\Valid::is_mobile($q->mobile)->withError('手机号码格式不对');

		if ($q->receiver_money_type==2) {
			// $q->bank_address='某某地址';

			batch_isset($q, ['bank_address']);
			\Valid::not_empty($q->bank_address)->withError('没有填写开户行地址');
		}
		if ($q->apply_type==1) {
			// $q->company_name='创想范公司';
			// $q->licence=['524123412312.jpg|asd.jpg'];
			// $q->legal_idcard_img=['ho.jpg|adsd.jpg'];

			batch_isset($q, ['company_name', 'licence', 'legal_idcard_img']);

			\Valid::not_empty($q->company_name)->withError('没有填写企业名称');
			\Valid::has_valueInArray($q->licence)->withError('没有上传营业执照');
			\Valid::has_valueInArray($q->legal_idcard_img)->withError('没有法人身份证');
		}
		/*校验*/
		


		/*赋值*/
		$model=\Model::Fx_supplier_user($q->user_id);

		$model->register_type=$q->apply_type;
		$model->manager_category=$q->manager_category;

		$model->receiver_account=$q->receiver_account;
		$model->receiver_account_name=$q->receiver_account_name;


		$model->idcard=$q->apply_idcard;		
		$model->realname=$q->apply_name;
		$model->applicant_idcard_img_hand=implode('|', $q->apply_idcard_img_hand);

		$model->wangwang=$q->wangwang;
		$model->qq=$q->qq;
		$model->mobile=$q->mobile;
		$model->lastupdatetime=date('Y-m-d H:i:s', time());
		$model->applicant_idcard_img=implode('|', $q->apply_idcard_img);
		$model->receiver_account_type=$q->receiver_money_type;

		if ($q->apply_type==1) {
			$model->business_license=implode('|', $q->licence);
			$model->company_name=$q->company_name;
			$model->legal_idcard_img=implode('|', $q->legal_idcard_img);
		}
		if ($q->receiver_money_type==2) {
			$model->open_bank_address=$q->bank_address;
		}

		/*赋值*/
		$dao=\Dao::Fx_supplier_user();
		$r=$dao->update($model);
		$r? $this->response('资质提交成功'): myerror(\StatusCode::msgDBUpdateFail, '执资提交失败');



	}

}