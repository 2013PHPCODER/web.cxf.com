<?php

namespace api\home;

/**
 * 获取在线客服列表
 * @author shenlang
 * 2016‎/8‎/11
 */
class CustomerController extends Controller {

    public function customerList() {
        $model = \Model::fx_customer_service('', '', '', '', 1);
        $dao = \Dao::fx_customer_service();
        $customers = $dao->getList($model, ['type', 'qq']);
        $this->response['qq_list'] = $customers['list'];
        $this->response();
    }

}
