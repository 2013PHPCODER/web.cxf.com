<?php

namespace Finance\Controller;

use Common\Controller\AuthController;

//收款相关
class CollectionController extends AuthController {

    private $confirm_success_trade_model;

    public function __construct() {
        parent::__construct();
        $this->confirm_success_trade_model = new \Finance\Model\ConfirmSuccessTradeModel();
    }

    public function index() {
        $condition = $this->searchCondition();
//        print_r($condition);
        $export = I('get.explode_list');
        if ($export == 1) {
            $this->export_excel($condition);
        }
        $page_count = $this->confirm_success_trade_model->where($condition)->count();
        $_page = getpage($page_count, 50);
        $list = $this->confirm_success_trade_model
                ->field('id,user_type,user_name,source_id,source_sn,type,`status`,confirm_money,trade_no,pay_account,pay_type,pay_time,confirm_time,receiver_account')
                ->where($condition)
                ->order(' pay_time desc,add_time desc')
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->select();
//        echo M()->getLastSql();die;
        $_data['list'] = $list;
        $this->user_type = C('user_type');
        $this->receiver_platform = C('receiver_platform');
        $_data['page'] = $_page->show();
        $this->list_data = $_data;
        $this->confirm_type = C('confirm_success_money_type');
        $this->pay_type = C('receiver_platform');
        $this->pay_status = C('confirm_success_money_status');
        $this->display();
    }

    /**
     * 创建搜索条件
     */
    private function searchCondition() {
        $condition = array();
        $group_id = I('get.group_id') ? I('get.group_id') : 1;
        switch ($group_id) {
            case 1:
                break;
            case 2:
                $condition['type'] = 1;
                break;
            case 3:
                $condition['type'] = 2;
                break;
            case 4:
                $condition['type'] = 3;
                break;
            case 5:
                $condition['type'] = 4;
                break;
        }
        $pay_type = I('get.pay_type');
        if (!empty($pay_type)) {
            $condition['pay_type'] = $pay_type;
        }
        $start_time = I('get.start_time');
        if (!empty($start_time)) {
            $condition['pay_time'] = array('GT', $start_time);
        }
        $end_time = I('get.end_time');
        if (!empty($start_time)) {
            $condition['pay_time'] = array('LT', $end_time);
        }
        $status = I('get.status');
        if ($status != '' && ($status == 0 || $status == 1)) {
            $this->status = $condition['`status`'] = $status;
        }
        $search_key = I('get.search_key');
        $search_words = I('get.search_words');
        if ($search_key && $search_words) {
            $condition[$search_key] = array('LIKE', '%' . $search_words . '%');
        }
        return $condition;
    }

    /**
     * 导出收款列表
     * @param type $condition
     */
    private function export_excel($condition) {
        $xlsCell = array(
            array('id', 'id勿改动'),
            array('user_type', '用户类型'),
            array('status', '状态(0，未打款 1 已打款)'),
            array('true_status', '状态(0，未打款 1 已打款)'),
            array('user_name', '供货商账户'),
            array('confirm_money', '结算金额'),
            array('type', '类型：1-订单收款,2-充值,3-补款'),
            array('trade_no', '第三方流水号'),
            array('pay_type', '支付方式:1:支付宝,2:银行卡,3:微信'),
            array('pay_account', '付款账户'),
            array('receiver_account', '收款账户'),
            array('pay_time', '支付时间'),
        );
        $page_count = $this->confirm_success_trade_model->where($condition)->count();
        $_page = getpage($page_count, 50);
        $list = $this->confirm_success_trade_model->where($condition)
                ->field('id,user_type,user_name,source_id,type,`status`,confirm_money,trade_no,pay_account,pay_type,pay_time,confirm_time,receiver_account')
                ->order('add_time asc')
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->select();
        $_data = array();
        $confirm_type = C('confirm_success_money_type');
        foreach ($list as $key => $value) {
            $type = $confirm_type[$value['type']];
            $_data[$key]['id'] = $value['id'];
            $_data[$key]['user_type'] = $value['user_type'] == 1 ? '供货商' : '分销商';
            $_data[$key]['true_status'] = $_data[$key]['status'] = $value['status'];
            $_data[$key]['user_name'] = $value['user_name'];
            $_data[$key]['confirm_money'] = $value['confirm_money'];
            $_data[$key]['type'] = $type;
            $_data[$key]['trade_no'] = $value['trade_no'];
            $_data[$key]['pay_account'] = $value['pay_account'];
            $_data[$key]['receiver_account'] = $value['receiver_account'];
            $_data[$key]['pay_type'] = $value['pay_type'];
            $_data[$key]['pay_time'] = date('Y-m-d H:i:s', $value['pay_time']);
        }
        exportExcel('收款表', $xlsCell, $_data);
        exit;
    }

    /**
     * 单条数据确认收款
     */
    public function suer() {
        $id = I('post.id');
        $confirm = $this->confirm_success_trade_model->confirm($id);
        echo json_encode($confirm);
        exit;
    }

    /**
     * 导入收款列表
     */
    public function importListExcel() {
        layout(false);
        $this->display();
    }

    public function importListAdd() {
        $targetFolder = C('UPLOAD_URL');
        if (!is_dir(ROOT_DIR . $targetFolder)) mkdir(ROOT_DIR . $targetFolder, 0777, true);
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 20971520; // 设置附件上传大小
        $upload->exts = array('xls'); // 设置附件上传类型
        $upload->rootPath = "." . $targetFolder; // 设置附件上传根目录
        $upload->subName = array('date', 'Ymd'); // 设置附件上传根目录
        $upload->saveName = '';
        $upload->replace = true;
        // 上传文件
        $info = $upload->upload();
        if (!$info) {
            //上传错误提示错误信
            $this->aReturn(0, $upload->getError(), '');
        } else {
            $_file_path = $targetFolder . $info['file']['savepath'] . $info['file']['savename'];
            //上传成功
            $_returnData = $this->importExcel($_file_path);
            $this->aReturn(1, L('_GOODS_IMPLODE_SUCCESS_'), $_returnData);
        }
        $this->aReturn(0, L('_FIEL_UPLOAD_FAILURE_'));
    }

    private function importExcel($_file_path) {
        vendor("PhpExcel.implodeExecl", '', '.php');
        $data = importExecl(ROOT_DIR . $_file_path);
        $suc_num = 0;
        $_error_num = 0;
        foreach ($data as $value) {
            $id = $value['A'];
            $status = $value['C'];
            $true_status = $value['D'];
            if ($status != $true_status && $true_status == 1) {
                $change = $this->confirm_success_trade_model->confirm($id);
                if ($change['status'] == 1) {
                    $suc_num ++;
                } else {
                    $_error_num++;
                }
            } else {
                $_error_num++;
                continue;
            }
        }
        if (0 == $_error_num) {
            $this->aReturn(1, '更新成功！');
        }
        $this->aReturn(1, '更新完成！共更新' . $suc_num . '条记录！失败' . $_error_num . ' 条数据!');
    }

}
