<?php

/*
 * 供应商Model
 * @author  shenlang
 */

namespace User\Model;

use Think\Model;

class FxSupplierUserModel extends Model {

    /**
     * 获取供应商列表
     * @param $_where
     * return Array
     */
    public function getSupplierList($_where) {
        $_count = $this->where($_where)->count();
        $_page = getpage($_count);
        $field = 'id,addtime,email,usernick,account_status,address,approve_time,mobile,qq,wangwang,leavel,approve_status,approve_remark,platform';
        $arr = $this->field($field)
                ->where($_where)
                ->order('id desc')
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->select();
        $_data['list'] = $arr;
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * 获取供应商详情
     * @param $id
     * return Array
     */
    public function getSupplierDetail($_id) {
        $field = "id,company_name,register_type,usernick,realname,idcard,email,mobile,qq,wangwang,applicant_idcard_img,legal_idcard_img,business_license,applicant_idcard_img_hand,receiver_account_type,open_bank_address,receiver_account_name,receiver_account";
        $arr = $this->field($field)->where('id=' . $_id)->find();
//        if(1==$arr['receiver_account_type']){
//           $arr['receiver_account_type']='支付宝';   
//        }elseif (2==$arr['receiver_account_type']) {
//           $arr['receiver_account_type']='银行卡'; 
//        }else{
//           $arr['receiver_account_type']='其他类型';
//        }
        return $arr;
    }

    /**
     * 更新代理商账号状态
     * @param type $_id 主键id
     * @param type $new_status 新状态 2 审核拒绝 3 审核通过
     * 
     */
    public function changeStauts($data) {
        $result = $this->save($data);
        if (false !== $result || 0 !== $result) {
            return true;
        } else {
            return false;
        }
    }

}
