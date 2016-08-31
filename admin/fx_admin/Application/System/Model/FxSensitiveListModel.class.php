<?php
namespace System\Model;
use Think\Model;
class FxSensitiveListModel extends Model{
    protected $_validate = array(
            array('sensitive','require','{%SENSITIVE_NOT_NULL}'), //非空严验证 
            array('sensitive','','{%SENSITIVE_UNIQUE}',0,'unique'), // 在新增的时候验证sname字段是否唯一
            //array('type','require','{%SENSITIVE_TYPE_NOT_NULL}'), //非空严验证
            //array('grade','require','{%SENSITIVE_GRADE_NOT_NULL}'), //非空严验证
        );
    
    protected $_auto = array ( 
        array('admin','getAdmin',3,'callback'), // 对password字段在新增和编辑的时候使md5函数处理
        array('datetime','time',1,'function'), // 对update_time字段在更新的时候写入当前时间戳
        //array('status','1'), // 默认状态为1
    );
    
    function getAdmin(){
        return session("user.id");
    }
}