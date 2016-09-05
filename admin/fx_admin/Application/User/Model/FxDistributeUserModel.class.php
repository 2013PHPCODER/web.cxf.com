<?php

/*
 * 分销商Model
 * @author  shenlang
 */

namespace User\Model;

use Think\Model;

class FxDistributeUserModel extends Model {

//    protected $tableName = 'fx_distribute_user';

    /*
     * 获取分销商列表
     * @param  $_where
     * return Array
     */
    public function getDisUserList($_where) {
        $_count = $this->where($_where)->count('id');
        $_page = getpage($_count);
        $field = "id,addtime,email,user_account,mobile,qq,wangwang,source,leavel";
        $arr = $this->field($field)
                ->where($_where)
                ->order('addtime desc')
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->select();
//        foreach ($arr as $k => &$v) {
//            if (1 == $v['source']) {
//                $v['source'] = "星密码";
//            } elseif (2 == $v['source']) {
//                $v['source'] = "创想范";
//            } elseif (3 == $v['source']) {
//                $v['source'] = "代理商";
//            }
//        }
        $_data['list'] = $arr;
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * 获取分销商详情
     * @param $id
     * return Array
     */
    public function getDisUserDetail($_id) {
        $field = "user_account,realname,idcard,email,mobile,qq,wangwang,source,acting_account";
        $arr = $this->field($field)->where(array('id' => $_id))->find();
        if (1 == $arr['source']) {
            $arr['source'] = "星密码";
        } elseif (2 == $v['source']) {
            $arr['source'] = "创想范";
        } elseif (3 == $v['source']) {
            $arr['source'] = "代理商";
        }
        return $arr;
    }

}
