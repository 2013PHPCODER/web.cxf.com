<?php

namespace Home\Controller;

use Think\Controller;
use Org\Util\YHttp;

class TbApiController extends CommonController{

    public $sessionKey = '6201e23b861da48209f3a6987028c01ZZ4df9caaa4c0533360541765';

    function _initialize(){
        parent::_initialize();
        date_default_timezone_set('Asia/Shanghai');
        vendor("TBAPI.TopSdk",'','.php');
        $this->c = new \TopClient;
        $this->c->appkey = $this->appkey;
        $this->c->secretKey = $this->secretKey;
    }

    public function getCode(){
        $_login_url = "https://oauth.taobao.com/authorize?response_type=code&client_id={$this->appkey}&redirect_uri=" . C('cas_logOut_service') . U('TbApi/taobaoLoginReturn');
        header("Location:" . $_login_url);
    }

    public function taobaoLogin(){
        $req = new \UserSellerGetRequest;
        $req->setFields("nick,sex");
        $resp = $this->c->execute($req,session('sessionKey'));
    }

    public function taobaoLoginReturn(){
        $this->data = $this->getAcessToken(I('get.code'));
        $this->show();
    }

    public function getAcessToken($code){
        $url = 'https://oauth.taobao.com/token';
        $post_data = array('grant_type'=>'authorization_code',
            'client_id'=>$this->appkey,
            'client_secret'=>$this->secretKey,
            'code'=>$code,
            'redirect_uri'=>C('cas_logOut_service') . U('TbApi/taobaoLoginReturn'));
        $_phpCAS = session('phpCAS');
        $result = YHttp::sendHttpRequest($url,$post_data,'POST');
        $returnData = array();
        if(isset($result->error)){
            $returnData['statu'] = 0;
            $returnData['info'] = '错误：' . $result->error_description;
            return $returnData;
        }
        $_data['user_id'] = $_phpCAS['user'];
        $_data['taobao_user_nick'] = $result->taobao_user_nick;
        $_data['return_data'] = serialize($result);
        $_data['re_expires_in'] = $result->re_expires_in;
        $_data['expires_in'] = $result->expires_in;
        $_data['expire_time'] = $result->expire_time;
        $_data['r1_expires_in'] = $result->r1_expires_in;
        $_data['w2_valid'] = $result->w2_valid;
        $_data['w2_expires_in'] = $result->w2_expires_in;
        $_data['taobao_user_id'] = $result->taobao_user_id ? $result->taobao_user_id : 0;
        $_data['w1_expires_in'] = $result->w1_expires_in;
        $_data['r1_valid'] = $result->r1_valid;
        $_data['r2_valid'] = $result->r2_valid;
        $_data['w1_valid'] = $result->w1_valid;
        $_data['r2_expires_in'] = $result->r2_expires_in;
        $_data['token_type'] = $result->token_type;
        $_data['refresh_token'] = $result->refresh_token;
        $_data['refresh_token_valid_time'] = $result->refresh_token_valid_time;
        $_data['access_token'] = $result->access_token;
        $_data['raw'] = $result->raw;
        $_taobao_auth = M('taobao_authorize');

        if($_taobao_auth->where("taobao_user_id = {$_data['taobao_user_id']}")->select()){
            $_staus = $_taobao_auth->where("taobao_user_id = {$_data['taobao_user_id']}")->save($_data);
            session('sessionKey',$_data['access_token']);
        }else{
            $_staus = $_taobao_auth->add($_data);
            session('sessionKey',$_data['access_token']);
        }

        if($_staus){
            $returnData['statu'] = 1;
            $returnData['info'] = '授权成功';
        }else{
            $returnData['statu'] = 0;
            $returnData['info'] = '授权失败';
        }
        return $returnData;
    }

    //取13位时间戳
    public function getMillisecond(){
        list($t1,$t2) = explode(' ',microtime());
        return $t2 . ceil(($t1 * 1000));
    }

    /**
     * [checkAcess 检查是授权是否过期]
     * @return [type] [description]
     */
    public function checkAcess(){
        $_user = session('phpCAS')['user'];
        $_expire_time = M('taobao_authorize')->where("user_id = {$_user}")->getField('expire_time');
        $_expire_time = $_expire_time ? $_expire_time : 0;
        $_time = $this->getMillisecond();
        if($_expire_time < $_time){
            $this->aReturn(0,'授权过期');
        }
        $this->aReturn(1,'授权正常');
    }

}
