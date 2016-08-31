<?php
namespace api\home;
class UsersController extends Controller{
    /**
     * 验证并修改用户信息
     * @param int $_user_id 用户ID值
     * @param string $_field 查询字段
     * @param string $_field_data 提交数据
     * @return JSON 
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608161337
     */
    public function update_user_data(){
        //echo json_encode(array('field_data'=>'18580250064','field'=>'mobile',"user_id"=>1,'code'=>'954394','target'=>'get_verfiy_code'));exit;
        //{"field_data":"18580250064","field":"mobile","user_id":1,"code":"954394","target":"get_verfiy_code"}
        batch_isset($this->request,array('user_id','field','field_data','code','target'));
        switch ($this->request->field) {
            case 'mobile':
                    //验证手机
                    \Valid::is_mobile($this->request->field_data)->withError(\DistributeUser::distribute_user_mobile_not);
                    if(!empty($this->request->update_data)) 
                    \Valid::is_mobile($this->request->update_data)->withError(\DistributeUser::distribute_user_mobile_not);
                break;
            case 'email':
                    //验证邮箱
                    \Valid::is_email($this->request->field_data)->withError(\DistributeUser::distribute_user_email_not);
                    if(!empty($this->request->update_data)) 
                    \Valid::is_email($this->request->field_data)->withError(\DistributeUser::distribute_user_mobile_not);
                break;        
            default:
                    myerror(\StatusCode::msgCheckFail, \DistributeUser::distribute_user_fail);
                break;
        }
        $_verify_dao = \Dao::Fx_verify();
        $_verify_code_re = $_verify_dao->verify_code($this->request->target,$this->request->code
                ,$this->request->field,$this->request->field_data);
        if(!$_verify_code_re) myerror(\StatusCode::msgCheckFail, \DistributeUser::distribute_verify_fail);
        
        if(!empty($this->request->update_data)){
            if(!\Dao::Fx_distribute_user()->update_user_info($this->request->user_id,$this->request->field,$this->request->update_data)) 
                myerror(\StatusCode::msgCheckFail, \DistributeUser::distribute_update_fail);
        }
        $this->response(\DistributeUser::distribute_verify_success);
    }

    /**
     * 发送验证码到用户邮箱或手机
     * @param int $_uid 用户的ID值
     * @param string moblie 用户原有手机号
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 2016091301
     */
    public function get_verfiy_code(){
        //echo json_encode(array('field_data'=>'18580250064','field'=>'mobile'));exit;
        //{"field_data":"18580250064","field":"mobile"}
        batch_isset($this->request,array('field_data','field'));
        switch ($this->request->field) {
            case 'mobile':
                    //验证手机
                    \Valid::is_mobile($this->request->field_data)->withError(\DistributeUser::distribute_user_mobile_fail);
                break;
            case 'email':
                    //验证邮箱
                    \Valid::is_email($this->request->field_data)->withError(\DistributeUser::distribute_user_email_not);
                break;        
            default:
                    myerror(\StatusCode::msgCheckFail, \DistributeUser::distribute_user_fail);
                break;
        }
        if(!send_verify_code($this->request->field,$this->request->field_data))
        myerror(\StatusCode::msgCheckFail, \DistributeUser::distribute_send_verify_code_fail);
        $this->response(array('msg'=>\DistributeUser::distribute_send_verify_code_success,'target'=>'get_verfiy_code'));
    }
    
    /**
     * 设置-账户设置-获取用户信息
     * @param int $_uid 用户UID
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608101311
     */
    public function user_info(){
        //echo json_encode(array('userid'=>1,'username'=>'test1')); 
        //{"user_id":1,"username":"test1"}
        batch_isset($this->request,array('user_id'));
        $_distribute_user = \Dao::Fx_distribute_user()->get_user_info($this->request->user_id);
        if(empty($_distribute_user)){
            $this->response(\DistributeUser::userid_username_error);
        }else{
            $this->response($_distribute_user);
        }
    }
}

