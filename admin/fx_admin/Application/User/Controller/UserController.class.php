<?php

/*
 * 用户管理控制器
 * @author 沈浪
 * 2016/08/1
 */

namespace User\Controller;

use Think\Controller;

class UserController extends CommonController {

    function _initialize() {
        parent::_initialize();
    }

    /*
     * [index 分销商列表页面  默认进入]
     * 
     */

    public function index() {
        $_where = $this->disSearchWhere();
        $ob = new \User\Model\FxDistributeUserModel();
        $this->datas = $ob->getDisUserList($_where);
        $this->show();
    }

    /*
     * 分销商详情
     * 
     */

    public function distributeDetail() {
        $id = I('get.userid');
        $ob = new \User\Model\FxDistributeUserModel();
        $arr = $this->disUserDetail = $ob->getDisUserDetail($id);
        $this->ajaxReturn($arr);
    }

    /**
     * 供应商列表
     * 
     */
    public function supplierList() {
        $_where = $this->supplierSearchWhere();
        if (I('get.register_type') == 0 || I('get.register_type') !== false) {
            $_where['register_type'] = I('get.register_type');
        }
        $ob = new \User\Model\FxSupplierUserModel();
        $arr = $this->datas = $ob->getSupplierList($_where);
        $this->show();
    }

    /*
     * 供应商商详情
     * 
     */

    public function supUserDetail() {

        $id = I('get.userid');
        $ob = new \User\Model\FxSupplierUserModel();
        $arr = $this->supUserDetail = $ob->getSupplierDetail($id);
        //处理申请人身份证正反面图url
        if (!empty($arr['applicant_idcard_img'])) {
            $arr['applicant_idcard_img'] = explode('|', $arr['applicant_idcard_img']);
            for ($i = 0; $i < count($arr['applicant_idcard_img']); $i++) {
                $idcard_arr = array();
                $idcard_arr['img_path'] = imgUrl($arr['applicant_idcard_img'][$i], '', '', true); //原图
                $idcard_arr['img_thumb'] = imgUrl($arr['applicant_idcard_img'][$i], '', 100, true); //缩略图
                $arr['applicant_idcard_img'][$i] = $idcard_arr;
            }
        }
        //处理法人身份证正反面图url
        if (!empty($arr['legal_idcard_img'])) {
            $arr['legal_idcard_img'] = explode('|', $arr['legal_idcard_img']);
            for ($i = 0; $i < count($arr['legal_idcard_img']); $i++) {
                $legal_arr = array();
                $legal_arr['img_path'] = imgUrl($arr['legal_idcard_img'][$i], '', '', true);
                $legal_arr['img_thumb'] = imgUrl($arr['legal_idcard_img'][$i], '', 100, true);
                $arr['legal_idcard_img'][$i] = $legal_arr;
            }
        }
        //处理营业执照正反面图url
        if (!empty($arr['business_license'])) {
            $arr['business_license'] = explode('|', $arr['business_license']);
            $m = count($arr['business_license']);
            for ($i = 0; $i < $m; $i++) {
                $business_arr = array();
                $business_arr['img_path'] = imgUrl($arr['business_license'][$i], '', '', true);
                $business_arr['img_thumb'] = imgUrl($arr['business_license'][$i], '', 100, true);
                $arr['business_license'][$i] = $business_arr;
            }
        }
        //处理手持身份证正反面图url
        if (!empty($arr['applicant_idcard_img_hand'])) {
            $arr['applicant_idcard_img_hand'] = explode('|', $arr['applicant_idcard_img_hand']);
            $t = count($arr['applicant_idcard_img_hand']);
            for ($i = 0; $i < $t; $i++) {
                $hand_arr = array();
                $hand_arr['img_path'] = imgUrl($arr['applicant_idcard_img_hand'][$i], '', '', true);
                $hand_arr['img_thumb'] = imgUrl($arr['applicant_idcard_img_hand'][$i], '', 100, true);
                $arr['applicant_idcard_img_hand'][$i] = $hand_arr;
            }
        }

        $this->ajaxReturn($arr);
    }

    /**
     * 审核供应商信息
     */
    public function changeStatus() {
        $data = array();
        $data['id'] = I("post.id");
        $data['approve_status'] = I("post.stu");
        $data['approve_remark'] = I("post.stutext");
        $data['approve_time'] = date("Y-m-d H-i-s", time());
        $ob = new \User\Model\FxSupplierUserModel();
        $re = $ob->changeStauts($data);
        if (3 == $data['approve_status']) {
            $detail = "供应商资料审核，通过";
        } elseif (2 == $data['approve_status']) {
            $detail = "供应商资料审核，拒绝通过";
        }
        if ($re) {
            $this->log($detail);
            $this->ajaxReturn("审核成功");
        }
    }

    /**
     * 代理商列表
     * 
     */
    public function actinglist() {
        $_where = $this->actSearchWhere();
        $ob = new \User\Model\FxActingUserModel();
        $this->datas = $ob->getActingList($_where);
        $this->show();
    }

    /**
     * 代理商销售详情
     */
    public function actingDetail() {
        $_id = I('get.id');
        $_where = $this->actSaleSearch();
        $ob = new \User\Model\FxActingUserModel();
        $this->datas = $ob->getActingSaleDetail($_where, $_id);
        $_username = I('get.username');
        $actData = $ob->getActingMsg($_id);
        $actData['username'] = $_username;
        $this->assign('actData', $actData);
        $this->show();
    }

}
