<?php

namespace api\home;

/**
 * 修改用户密码 get_verify
 * @author shenlang
 * 2016‎/8‎/15
 */
class PwdChangeController extends Controller {

    /**
     * 校验验证码 check_verify
     */
    public function verifyCheck() {
        $request = $this->request;
        $target = $request->target;
        $field_data = $request->field_data;
        $verify = $request->verify;
        $must = ['verify', 'field_data', 'target'];
        batch_isset($request, $must);
        $result = checkVerifyCode($target, $field_data, $verify);
        if ($result) {
            $this->response['sucess'] = 1;
            $this->response['msg'] = '验证成功！';
        }
        $this->response();
    }

    /**
     * 修改密码
     * 
     */
    public function changePwd() {
        $request = $this->request;
        $user_id = $request->user_id;
        $type = $request->type;       //修改类型（1，修改密码，2 修改支付密码）
        $pwd = trim($request->pwd);
        $repwd = trim($request->repwd);
        $must = ['user_id', 'type', 'pwd', 'repwd'];
        batch_isset($request, $must);
        \Valid::has_number($user_id)->withError('用户id错误');
        \Valid::has_number($type)->withError('请求类型错误');
        \Valid::not_empty($pwd)->withError('密码为空');
        \Valid::not_empty($repwd)->withError('再次输入密码为空');
        if (strcmp($pwd, $repwd) !== 0) {
            myerror(\ChangePwd::pwdDiff, '两次密码不一致!');
        }
        if (1 == $type) {
            $pwdType = 'userpwd';
            $checkre = $this->checkPwd($user_id, $pwd, $pwdType);
            $pwd = encodePwd($pwd);
            if ($checkre) {
                $distribute_user_model = \Model::fx_distribute_user($user_id, '', $pwd);
                $distribute_user_dao = \Dao::fx_distribute_user();
                $result = $distribute_user_dao->update($distribute_user_model);
                if (1 == $result) {
                    $this->response['sucess'] = 1;
                    $this->response['msg'] = "修改登陆密码成功";
                }
            }
        } elseif (2 == $type) {
            $pwdType = 'pay_pwd';
            $checkre = $this->checkPwd($user_id, $pwd, $pwdType);
            if ($checkre) {
                $distribute_user_model = \Model::fx_distribute_user();
                $distribute_user_dao = \Dao::fx_distribute_user();
                $distribute_user_model->id = $user_id;
                $distribute_user_model->pay_pwd = encodePwd($pwd);
                $result = $distribute_user_dao->update($distribute_user_model);
                if (1 == $result) {
                    $this->response['sucess'] = 1;
                    $this->response['msg'] = "修改支付密码成功";
                }
            }
        }
        $this->response();
    }

    /**
     * 验证更新密码是否和之前密码一样
     * @param type $user_id  用户Id
     * @param type $pwd      更新密码
     * 
     */
    public function checkPwd($user_id, $pwd, $pwdType) {
        $distribute_user_model = \Model::fx_distribute_user($user_id);
        $distribute_user_dao = \Dao::fx_distribute_user();
        $user_info = $distribute_user_dao->getList($distribute_user_model, [$pwdType]);
        $userpwd = $user_info['list'][0][$pwdType];
        if (verifyPwd($pwd, $userpwd)) {
            myerror(\ChangePwd::pwdEqual, '密码不能和当面密码相同!');
        } else {
            return TRUE;
        }
    }

}
