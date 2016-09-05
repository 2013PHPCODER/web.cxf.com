<?php
namespace Storage\Model;
use Think\Model;
class FxStorageListModel extends Model{
    protected $_validate = array(
            array('sname','require','{%STROAGE_REQUIER}'), //非空严验证 
            array('sname','','{%STROAGE_UBIQUE}',0,'unique',Model::MODEL_INSERT), // 在新增的时候验证sname字段是否唯一
            array('province','require','{%PROVINCE_REQUIER}'), //非空严验证
            array('city','require','{%CITY_REQUIER}'), //非空严验证
            array('area','require','{%AREA_REQUIER}'), //非空严验证
            array('address','require','{%ADDRESS_REQUIER}'), //非空严验证
            array('mobile','/^1[3|4|5|8][0-9]\d{4,8}$/','{%MOBILE_REQUIER}','0','regex',1),
            array('functionary','require','{%FUNCTIONARY_REQUIER}'), //非空严验证
            array('freight','require','{%FREIGHT_REQUIER}'), //非空严验证
        );
}