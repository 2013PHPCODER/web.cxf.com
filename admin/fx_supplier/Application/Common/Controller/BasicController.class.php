<?php

namespace Common\Controller;

use Think\Controller;

/**
 * 公共入口
 * @author shengjiangtou
 */
//不需要的auth验证的顶级控制器
class BasicController extends Controller {

    protected $user_info;
    public $sessionKey;
    public $appkey;
    public $secretKey;
    public $redirect_uri;

    public function __construct() {
        parent::__construct();
        $this->user_info = session('user_info');
        if (empty($this->user_info) || empty($this->user_info['id'])) {
//            $jumpUrl = U('user/login/index');
            if (IS_AJAX) {
                $this->msg = '请重新登录!';
//                echo "<script>window.location.href='" . $jumpUrl . "';</script>";
                $this->redirect('user/login/index');
                die;
            } else {
                $this->redirect('user/login/index');
                exit;
//                $this->assign("jumpUrl", $jumpUrl);
//                $this->error('请重新登录！');
            }
        } else {
            if ($this->user_info['account_status'] == 1) {
                $this->redirect('user/login/index', array('msg' => '用户被禁用!'));
            }
            session('user_info', $this->user_info, 3600);
            $this->assign('username', $this->user_info['user_account']);
        }
        //记录后台所有POST到表
//        if(IS_POST){
//            M("post")->add(array("user_id"=>$this->admin_id,"url"=>$_SERVER["REQUEST_URI"],"content"=>json_encode($_POST),"add_time"=>time()));
//        }
    }

    /**
     * 操作日志记录
     * @param type $user_id 用户id
     * @param type $user_name 用户名
     * @param type $detail 日志详情
     */
    protected function log($detail) {
        $objSystemLog = M("fx_operate_logs");
        $data = array();
        $data["user_id"] = $this->user_info['id'];
        $data['user_name'] = $this->user_info['user_account']; //用户类型，1供货商，2后台管理员
        $data['user_type'] = 1;
        $data['module'] = MODULE_NAME;
        $data['url'] = U();
        $data["detail"] = $detail;
        $data['add_time'] = time();
        $data["ip"] = getIp();
        $data['request'] = json_encode(I());
        $objSystemLog->add($data);
    }

    protected function aReturn($status = 1, $message, $data = false) {
        $d['status'] = $status;
        $d['message'] = $message;
        $d['returnData'] = $data;
        die($this->ajaxReturn($d, 'JSON'));
    }

}
