<?php

/*
 * 代理商Model
 * @author  shenlang
 */

namespace User\Model;

use Think\Model;

class FxActingUserModel extends Model {

    /**
     * 获取代理商列表
     * @param type $_where
     * @return type
     */
    public function getActingList($_where) {
        $_count = $this->alias('a')->join('fx_distribute_user ON fx_distribute_user.id=a.distribute_id')->where($_where)->count('a.id');
        $_page = getpage($_count);
        $field = "a.id,a.addtime,a.buy_account_num,a.receiver_money,fx_distribute_user.email,fx_distribute_user.leavel,fx_distribute_user.user_account,fx_distribute_user.usernick";
        $arr = $this->alias('a')
                ->field($field)
                ->where($_where)
                ->join('fx_distribute_user ON fx_distribute_user.id=a.distribute_id')
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->order('addtime desc')
                ->select();
        $_data['list'] = $arr;
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * 获取代理商销售详情
     * @param array $_where 搜索条件
     * @param type $_id  代理商id
     * @return type
     * 
     */
    public function getActingSaleDetail($_where, $_id) {
        $_where['parent_id'] = $_id;
        
        $_count = M('fx_distribute_user')->where($_where)->count('id');
        $_page = getpage($_count);
        $field = "id,addtime,user_account,last_login_time,leavel";
        $arr = $this->table('fx_distribute_user')
                ->field($field)
                ->where($_where)
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->order('id desc')
                ->select();
        $_data['list'] = $arr;
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * 获取代理商基本信息
     * @param type $_id  代理商id
     * @return type
     * 
     */
    public function getActingMsg($_id) {
        $field = "buy_account_num,receiver_money";
        return $this->field($field)
                        ->where(array('id' => $_id))
                        ->find();
    }

}
