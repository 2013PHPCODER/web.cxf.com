<?php
namespace api\home;

class OtherController extends Controller{

	private $verify_conf;				//验证码配置
	private $verify_target;				//请求的验证码有效范围

	public function img(){					//获得上传图片token
		$q=$this->request;

		// $q=new \stdclass();
		// $q->file_name=["45ca58d7018c502be5d8532202792dab.jpeg"];		//必传
		// $q->file_type = 'goods';			//可选
		// $q->secret = 1;			//可选
		

		batch_isset($q, ['file_name']);
		\Valid::has_valueInArray($q->file_name)->withError('上传文件名不正确');

		$type=isset($q->file_type)? $q->file_type: '';
		$secret=isset($q->secret) && $q->secret ? (bool)$q->secret: false;
		$data=uploadKey($q->file_name, $type, $secret);
		$this->response($data);
	}

	public function sendVerify(){					//发送验证码接口
		$q=$this->request;
		// $q=new \stdclass();
		// $q->type='email';
		// $q->to='237239859@qq.com';
		// $q->target='gh_registe';

		// 验证
		batch_isset($q, ['type', 'to', 'target']);
		if ($q->type=='email') {					//通过邮件发送
			\Valid::is_email($q->to)->withError('邮箱格式不正确');
		}elseif($q->type=='mobile'){										//通过短信发送
			\Valid::is_mobile($q->to)->withError('不是手机号码');
		}else{
			is_mobile($q->to) && $q->type='mobile' or is_email($q->to) && $q->type='email' or myerror(\StatusCode::msgCheckFail, '不是手机号或邮箱') ;
		}

		//获取配置并验证发送目的
		$this->verify_conf=\Config::verify();		
		$this->verify_target=$q->target;							
		batch_isset($this->verify_conf['target'], [$this->verify_target], '发送目的不合法');


		//先查询数据库是否具有验证码
		$target_code=$this->verify_conf['target'][$this->verify_target];
		$type=$q->type=='mobile'? 'mobile': 'email';
		$dao=\Dao::fx_verify();
		$r=$dao->getVerifyDetail($target_code, $q->to, $type);


		//存在记录则进行判断，
		if ($r) {				//1判断是否过期，错误过期和时效过期。
			$expire=$this->getVeirfyConf('expire');
			$wrong_times=$this->getVeirfyConf('wrong_times');
			$is_expire=time() > $r['add_time']+ $expire  or $r['wrong_times'] > $wrong_times;


			if (!$is_expire) {									//没有过期，判断是否可以再次发送
				$timespan=$this->getVeirfyConf('timespan');
				$is_send_again=time() > $timespan+$r['update_time'];
				if (!$is_send_again) {																
					myerror(\StatusCode::msgVerifySendAgain, '请稍后发送验证码');
				}
			}
			//可再次发送和已过期都要更新原数据，然后再插入新数据
			$dao->setStatusExpire($target_code, $q->to, $type);
		}

		//发送验证码，

		$code=$this->create_code();
		$model=\Model::Fx_verify('', $code, $target_code);
		$model->$type=$q->to;
		$model->add_time=time();
		$model->update_time=time();
		$r=$dao->insert($model);
		
		!$r && myerror(\StatusCode::msgDBUpdateFail, '验证码生成失败, 请重新尝试');

		if ($type=='mobile') {
			$r=sendSms($q->to, $code);
			!$r && myerror(\StatusCode::msgVerifySendSmsFail, '由于运营商限制，目标手机接收次数已超限制');
		}else{

			//根据目标邮箱选择最合适的发送邮箱
			$main_domin=explode('@', $q->to)[1];
			$main_domin=explode('.', $main_domin)[0];			//获得邮箱主域名

			$best='';
			foreach ($this->verify_conf['email'] as $k => &$v) {
				if (stripos($k, $main_domin) !==false) {
					$best=$k;
					break;
				}
			}		
			$best=$best? : 'default';				//获得最佳发送邮件配置
			$conf=$this->verify_conf['email'][$best];
			$setting=['host' => $conf['host'],'account' => $conf['account'], 'pwd'=>  $conf['pwd'] ];
			$template=isset($this->verify_conf['email'][$best]['template']['verify'])? $this->verify_conf['email'][$best]['template']['verify']: $this->verify_conf['email']['default']['template']['verify'];

			$code=str_replace("{}", "<font style='colore:red'>$code</font>", $template);
			$r=sendEmail($q->to, $code, $setting);			//发送邮件
			$r !==0 && myerror(\StatusCode::msgVerifySendMailFail, '邮件验证码发送失败'.$r);

		}
		$this->response('验证码发送成功');

	}

	private function create_code(){
		return substr(mt_rand(),0, 5);
	}


	private function getVeirfyConf($key){						//获得验证码的配置
		return isset($this->verify_conf[$this->verify_target][$key])? $this->verify_conf[$this->verify_target][$key]: $this->verify_conf['default'][$key];
	}	
}