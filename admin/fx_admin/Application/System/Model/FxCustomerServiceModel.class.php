<?php
namespace System\Model;
use Think\Model;
class FxCustomerServiceModel extends Model{
    protected $_validate = array(
            array('qq','require','{%SERVICE_NOT_NULL}'), //非空严验证 
            array('qq','','{%SERVICE_UNIQUE}',0,'unique'), // 在新增的时候验证sname字段是否唯一
            array('type','require','{%SENSITIVE_TYPE_NOT_NULL}'), //非空严验证
            array('status','require','{%SENSITIVE_STATUS_NOT_NULL}'), //非空严验证
        );
    
    protected $_auto = array ( 
        array('admin','getAdmin',3,'callback'), // 对password字段在新增和编辑的时候使md5函数处理
        array('datetime','time',1,'function'), // 对update_time字段在更新的时候写入当前时间戳
    );
    
    function getAdmin(){
        return session("user.id");
    }
}