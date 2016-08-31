<?php

namespace api\home;

/**
 * 获取用户绑定淘宝店铺
 * @author shenlang
 * 2016‎/8‎/16
 */
class BandShopController extends Controller {

    public function bandList() {
        $request = $this->request;
        $user_id = $request->user_id;
        $must = [ 'user_id'];
        batch_isset($request, $must);
        \Valid::has_number($user_id)->withError('用户id错误');
        $tb_user_model = \Model::fx_tb_user('',$user_id);
        $tb_user_dao = \Dao::fx_tb_user();
        $band_list = $tb_user_dao->getList($tb_user_model, ['tb_user_id', 'nick', 'access_token', '`default`']);
        if (empty($band_list['list'])) myerror(\StatusCode::msgCheckFail, '无绑定店铺');
        $this->response($band_list['list']);
    }

}
