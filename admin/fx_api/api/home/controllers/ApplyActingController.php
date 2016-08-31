<?php

namespace api\home;

/**
 * 申请代理商
 * @author shenlang
 * 2016‎/8‎/11
 */
class ApplyActingController extends Controller {

    public function actingAdd() {
        $request = $this->request;
        $distribute_id = $request->user_id;
        $must = ['user_id'];
        batch_isset($request, $must);
        \Valid::has_number($distribute_id)->withError('用户id错误');
        $addtime = date('Y-m-d H:i:s', time());
        $acting_user_model = \Model::fx_acting_user('', '', $distribute_id);
        $acting_user_dao = \Dao::fx_acting_user();
        $result = $acting_user_dao->getList($acting_user_model);
        //判断是否已经为代理商
        if (!empty($result['list'])) {
            $this->response['fail'] = 0;
            $this->response['msg'] = "您已是代理商，不能重复申请！";
            $this->response();
            die;
        }
        $model = \Model::fx_acting_user('', $addtime, $distribute_id, '', '');
        $dao = \Dao::fx_acting_user();
        $re = $dao->insert($model);
        if (is_numeric($re) && 0 !== $re) {
            $this->response['sucess'] = 1;
            $this->response['msg'] = "申请成功！";
        } else {
            $this->response['fail'] = 0;
            $this->response['msg'] = "申请失败！";
        }
        $this->response();
    }

}