<?php
namespace api\home;

class Taobao_authorizeDao extends Dao {
    /*     * 执行自定义增删改语句 */

    public function get_tb_user_info($user_id){
       $sql = 'select * from taobao_authorize where user_id=:user_id order by `default` desc limit 1';
       $info = $this->query($sql, array('user_id'=>$user_id));
       if(empty($info[0])){
           myerror(\StatusCode::msgFailStatus, '用户还未绑定淘宝账号！');
       }
       return $info[0];
    }



}
