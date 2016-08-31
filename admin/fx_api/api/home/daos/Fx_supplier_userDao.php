<?php
namespace api\home;

class Fx_supplier_userDao extends Dao {
    /*     * 执行自定义增删改语句 */
    /**
     * 查询用户手机号
     * @param int $uid
     * @param int $mobile
     * @return boolean
     */
    public $table='fx_supplier_user';

    public function get_users_info($_uid,$_field,$_post_data){
        $_sql = 'SELECT mobile FROM fx_supplier_user WHERE id =:uid AND '.$_field.'=:field';
        $_arr_where = array('uid'=>$_uid,"$_field"=>$_post_data);
        return $this->query($_sql,$_arr_where);
    }

    public function checkExist($checkEmail){
        $sql='select count(*) from '. $this->table. ' where email=:email';
        $param=['email'=>$checkEmail];
        $r=$this->query($sql, $param, 'fetch_string');  
        return  $r;
    }
}
