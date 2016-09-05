<?php
namespace Storage\Controller;
use Common\Controller\BasicController;
use Think\Controller;
use Org\Util\YHttp;
class TbApiController extends BasicController{
    public $sessionKey = '6201e23b861da48209f3a6987028c01ZZ4df9caaa4c0533360541765';
    function _initialize(){
        date_default_timezone_set('Asia/Shanghai');
        vendor("TBAPI.TopSdk",'','.php');
        $this->c = new \TopClient;
        $this->c->appkey = C('taobaoAppKey');
        $this->c->secretKey = C('taobaosecretKey');
    }
    public function getCode(){
        $_login_url = "https://oauth.taobao.com/authorize?response_type=code&client_id=".C('taobaoAppKey').""
                . "&redirect_uri=http://" .$_SERVER['SERVER_NAME'] . U('TbApi/taobaoLoginReturn');
        header("Location:" . $_login_url);
    }
    public function taobaoLogin(){
        $req = new \UserSellerGetRequest;
        $req->setFields("nick,sex");
        $resp = $this->c->execute($req,session('sessionKey'));
    }

    public function taobaoLoginReturn(){
        $_get_code = I('get.code');
        if(empty($_get_code)) $this->error ('授权获取验证码失败',U('goods/goods/index'));
        $this->data = $this->getAcessToken($_get_code);
        $this->show();
    }

    public function getAcessToken($code){
        $url = 'https://oauth.taobao.com/token';
        $post_data = array('grant_type'=>'authorization_code',
            'client_id'=>C('taobaoAppKey'),
            'client_secret'=>C('taobaosecretKey'),
            'code'=>$code,
            'redirect_uri'=>'http://'.$_SERVER['SERVER_NAME'] . U('TbApi/taobaoLoginReturn'));
        import('Org.Util.YHttp');
        $result = YHttp::sendHttpRequest($url,$post_data,'POST','','','https');
        $returnData = array();
        if(isset($result->error)){
            $returnData['statu'] = 0;
            $returnData['info'] = '错误：授权失败！';// . $result->error_description;
            return $returnData;
        }
        $_data['user_id'] = $this->user_info['id'];
        $_data['taobao_user_nick'] = urldecode($result->taobao_user_nick);
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

        if(0 < $_taobao_auth->where("taobao_user_id = {$_data['taobao_user_id']}")->count()){
            $_staus = $_taobao_auth->where("taobao_user_id = {$_data['taobao_user_id']}")->save($_data);
        }else{
            $_staus = $_taobao_auth->add($_data);
        }
        session('sessionKey',$_data['access_token']);

        if($_staus){
            //向用户仓库写入授权数据
            
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
        $_expire_time = M('taobao_authorize')->where(array('user_id'=>  $this->user_info['id']))->getField('expire_time');
        $_expire_time = $_expire_time ? $_expire_time : 0;
        $_time = $this->getMillisecond();
        if($_expire_time < $_time){
            $this->aReturn(0,'授权过期');
        }
        $this->aReturn(1,'授权正常');
    }
    
    /**
     * [checkAcess 检查是授权是否过期]
     * @return [type] [description]
     */
    public function check_acess(){
//        $_expire_time = M('taobao_authorize')->where(array('user_id'=>  $this->user_info['id']))->getField('expire_time');
//        $_expire_time = $_expire_time ? $_expire_time : 0;
//        $_time = $this->getMillisecond();
//        if($_expire_time < $_time){
            $this->aReturn(0,'请授权后继续操作');
//        }
//        $this->aReturn(1,'授权正常');
    }
}
