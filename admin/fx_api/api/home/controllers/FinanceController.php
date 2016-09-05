<?php

/* * *
 * 财务-资金
 */

namespace api\home;

class FinanceController extends Controller {

    /**
     * 资金明细
     * @param int $_trade_type 交易 类型
     * @param int $_start_time 开始时间
     * @param int $_end_time 结束时间
     * @param string $_trade_no 订单号
     * @param int $_page 分页
     * @param int $_user_id 分销商ID
     * @param string $_user_name 用户名
     * @return array 
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608112018
     */
    public function statement_list() {
        //echo json_encode(array('page'=>1,'user_id'=>1,'user_name'=>'test1','trade_type'=>1,'start_time'=>'','end_time'=>'','trade_no'=>''));exit;
        //{"page":1,"user_id":1,"user_name":"test1","trade_type":"1","start_time":"2016-8-5","end_time":"2016-8-6","trade_no":"1160719035332928408"}
        if (!isset($this->request->user_id)) myerror(\StatusCode::msgCheckFail, \Finance::fiance_user_id_not_null); //必须
        if (!isset($this->request->user_name)) myerror(\StatusCode::msgCheckFail, \Finance::fiance_username_not_null); //必须
        if (!isset($this->request->page)) myerror(\StatusCode::msgCheckFail, \Finance::fiance_page_not_null); //必须
        if (!isset($this->request->trade_type)) $this->request->trade_type = ''; //可选
        if (!isset($this->request->start_time)) $this->request->start_time = ''; //可选
        if (!isset($this->request->end_time)) $this->request->end_time = ''; //可选
        if (!isset($this->request->trade_no)) $this->request->trade_no = ''; //可选

        $_datas = \Dao::fx_statement()->statement_list($this->request->user_id, $this->request->user_name, $this->request->trade_type, $this->request->start_time, $this->request->end_time, $this->request->trade_no, $this->request->page);
        $this->response($_datas);
    }

    /**
     * 获取收款账户信息
     * @author Ximeng <ximeng@xingmima.com>
     * @since 201608112018
     */
    public function get_receiver_account() {
        $dao = \Dao::Fx_receiver_account();
        $result = $dao->get_receiver_account();
        if (!$result || count($result) <= 0) {
            $this->response['sucess'] = 0;
            $this->response['msg'] = "获取失败！";
        } else {
            $this->response['sucess'] = 1;
            $this->response['msg'] = "获取成功！";
            $this->response['data'] = $result;
        }
        $this->response();
    }

}
