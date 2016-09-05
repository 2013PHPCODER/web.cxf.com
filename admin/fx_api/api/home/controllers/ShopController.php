<?php

namespace api\home;

class ShopController extends Controller {

    private $user_id;
    private $access_token;
    private $tb_user_dao;

    public function __construct() {
        parent::__construct();
        import('Taobao');
    }

    public function tb_shop_list() {
        $data = $this->request;
        if (empty($data->tb_user_id)) {
            myerror(\StatusCode::msgCheckFail, '用户不能为空！');
        }
        $q = isset($data->keyword) ? $data->keyword : '';
        $this->tb_user_dao = \DAO::Fx_tb_user();
        $this->access_token = $this->tb_user_dao->get_taobao_access_token($data->tb_user_id);
        $list_type = isset($data->list_type) ? $data->list_type : 1; //列表类型 1:出售中的商品 2:仓库中的商品
        $sort = isset($data->sort) ? $data->sort : null;
        $page = isset($data->page) ? $data->page : 1;
        if (!in_array($sort, array('list_time', 'delist_time', 'num', 'modified', 'sold_quantity', 'price'))) {
            $sort = null;
        }
        $page_size = isset($data->per_page) ? $data->per_page : 20;
        if ($page > 100) myerror(\StatusCode::msgCheckFail, '最大页码只支持100');
        if ($page * $page_size > 20000) myerror(\StatusCode::msgCheckFail, '您当前获取的记录条数过多！');
        //$fields = 'approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id,sold_quantity';
        $fields = 'approve_status,num_iid,title,nick,type,cid,pic_url,num,valid_thru,price,modified,outer_id';
        $params = array(
            'fields' => $fields,
            'page_no' => $page,
            'page_size' => $page_size,
            'q' => $q,
        );
        $goods_array = array();
        $goods_total = 0;
        if (strlen($sort) > 0) $params['order_by'] = $sort . ':' . $data->desc;
        if ($list_type == 1) {
            //获取出售中的商品
            $taobao_result = \Taobao::curl_taobao_api('taobao.items.onsale.get', $this->access_token, $params);
            if (!\Taobao::get_taobao_response($taobao_result, 'items_onsale_get_response', $response)) myerror(\StatusCode::msgCheckFail, '获取出售中的商品失败:' . $response->msg);
            if (isset($response->items) && 0 < $response->total_results) {
                $goods_array = object_to_array($response->items->item);
                $goods_total = $response->total_results;
                if (!empty($goods_array)) {
                    array_walk($goods_array, function(&$d) {
                        $d['status'] = 1;
                    });
                }
            }
        }
        if ($list_type == 2) {
            //获取仓库中的商品
            $taobao_result = \Taobao::curl_taobao_api('taobao.items.inventory.get', $this->access_token, $params);
            if (!\Taobao::get_taobao_response($taobao_result, 'items_inventory_get_response', $response)) myerror(\StatusCode::msgCheckFail, '获取仓库中的商品失败:' . $response->msg);
            if (isset($response->items) && 0 < $response->total_results) {
                $goods_array = object_to_array($response->items->item);
                $goods_total = $response->total_results;
                array_walk($goods_array, function(&$d) {
                    $d['status'] = 2;
                });
            }
        }
        //查询商品的销量
        if (!empty($goods_array)) {
            foreach ($goods_array as $key => $val) {
                $goods_array[$key]['sellout_count'] = 0;
                $goods_array[$key]['goods_price'] = 0;
                $goods_array[$key]['goods_sale'] = 0;
                if (!isset($val['outer_id'])) {
                    $goods_array[$key]['outer_id']='';
                    continue;
                }
                $sell_info = $this->tb_user_dao->goods_sell_count($val['outer_id']);
                $goods_array[$key]['sellout_count'] = $sell_info['num'];
                $goods_array[$key]['goods_price'] = change_price($sell_info['price']);
                $goods_array[$key]['goods_sale'] = (int) $sell_info['goods_sale'];
            }
        }
        $this->response['page'] = $page;
        $this->response['per_page'] = $page_size;
        $this->response['total'] = $goods_total;
        $this->response['item'] = $goods_array;
        $this->response();
    }

    /**
     * 淘宝店铺商品上下架（支持批量）
     */
    public function tb_shelf() {
        set_time_limit(0);
        $this->user_id = isset($this->request->tb_user_id) ? $this->request->tb_user_id : null;
        if (empty($this->user_id)) myerror(\StatusCode::msgCheckFail, '用户id不能为空！');
        $this->tb_user_dao = \DAO::Fx_tb_user();
        $this->access_token = $this->tb_user_dao->get_taobao_access_token($this->user_id);
        $data = $this->request;
        $opt = isset($data->opt) ? $data->opt : null;
        $num_iid = isset($data->num_iid) ? $data->num_iid : null;
        $num = isset($data->num) ? $data->num : null;
        if (!preg_match('/^\d{10,12}(,\d{10,12})+$|^\d{10,12}$/', $num_iid)) {
            myerror(\StatusCode::msgCheckFail, '参数错误');
        }
        if (!preg_match('/^\d{1,9}(,\d{1,9})+$|^\d{1,9}$/', $num)) {
            myerror(\StatusCode::msgCheckFail, '参数错误');
        }
        $num_iids = explode(',', $num_iid);
        $nums = explode(',', $num);
        if (empty($num_iids) || empty($nums) || count($num_iids) != count($nums)) myerror(\StatusCode::msgCheckFail, '参数无效');
        $taobao_api_name = $opt == 1 ? 'taobao.item.update.listing' : 'taobao.item.update.delisting';
        $taobao_api_response_root_name = $opt == 1 ? 'item_update_listing_response' : 'item_update_delisting_response';
        for ($i = 0; $i < count($num_iids); $i++) {
            $params = array(
                'num_iid' => $num_iids[$i]
            );
            if ($opt == 1) $params['num'] = $nums[$i];
            $taobao_result = \Taobao::curl_taobao_api($taobao_api_name, $this->access_token, $params);
            if (!\Taobao::get_taobao_response($taobao_result, $taobao_api_response_root_name, $response)) myerror(\StatusCode::msgCheckFail, '操作失败:' . $response->msg);
            sleep(2);
        }
        $this->response(array('sucess' => true, 'msg' => 'ok'));
    }

    /**
     * 淘宝店铺商品删除（支持批量）
     */
    public function tb_godos_delete() {
        $this->tb_user_id = isset($this->request->tb_user_id) ? $this->request->tb_user_id : null;
        if (empty($this->tb_user_id)) myerror(\StatusCode::msgCheckFail, '用户id不能为空！');
        $this->tb_user_dao = \DAO::Fx_tb_user();
        $this->access_token = $this->tb_user_dao->get_taobao_access_token($this->tb_user_id);
        set_time_limit(0);
        $data = $this->request;
        $num_iid = isset($data->num_iid) ? $data->num_iid : null;
        if (!preg_match('/^\d{10,12}(,\d{10,12})+$|^\d{10,12}$/', $num_iid)) {
            myerror(\StatusCode::msgCheckFail, '参数错误');
        }
        $num_iids = explode(',', $num_iid);
        if (empty($num_iids)) myerror(\StatusCode::msgCheckFail, '尚未选择任何商品！');
        for ($i = 0; $i < count($num_iids); $i++) {
            $params = array(
                'num_iid' => $num_iids[$i],
                'session' => $this->access_token
            );
            $taobao_result = \Taobao::curl_taobao_api('taobao.item.delete', $this->access_token, $params); //curl_taobao_api('taobao.item.delete', $access_token, $params);
            if (!\Taobao::get_taobao_response($taobao_result, 'item_delete_response', $response)) myerror(\StatusCode::msgCheckFail, '操作失败:' . $response->msg);
            sleep(2);
        }
        $this->response(array('sucess' => true, 'msg' => 'ok'));
    }

    /**
     * 店铺概况
     * @return string JSON
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function tb_shop_detail() {
        $q = $this->request;
        if (empty($q->user_id)) {
            myerror(\StatusCode::msgCheckFail, '用户id不能为空！');
        }
        $order_count = $this->getOrderCount($q->user_id);
        $fx_tb_user_dao = \Dao::Fx_tb_user();
        $shop_list = $fx_tb_user_dao->getShopList($q->user_id);
        $shop_goods_list = $this->getShopPublicCount($shop_list);
        $this->response['shop'] = $shop_goods_list;
        $this->response['order_count'] = $order_count;
        $this->response();
    }

    /**
     * 获取订单数量
     * @param type $user_id
     * @return type
     * @return string array
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    private function getOrderCount($user_id) {
        $param = array();
        $param['buyer_id'] = $user_id;
        $dao = \Dao::Order_list();
        $condition_1 = "buyer_id=:buyer_id and order_state=:order_state and is_pay<>1";
        $param['order_state'] = 0; //待付款
        $order_count['1'] = $dao->getOrderCount($condition_1, $param);
        $condition = "buyer_id=:buyer_id and order_state=:order_state";
        $param['order_state'] = 2; //待发货
        $order_count['2'] = $dao->getOrderCount($condition, $param);
        $param['order_state'] = 6; //异常
        $order_count['3'] = $dao->getOrderCount($condition, $param);
        $condition_2 = "buyer_id=:buyer_id and is_cus=:is_cus";
        $param_1['buyer_id'] = $user_id;
        $param_1['is_cus'] = 1; //售后
        $order_count['4'] = $dao->getOrderCount($condition_2, $param_1);
        return $order_count;
    }

    /**
     * 获取淘宝店铺列表分个商品数
     * @param type $shop_list
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    private function getShopPublicCount($shop_list) {
        import("Taobao");
        $params = array(
            'fields' => "num_iid",
            'page_no' => 1,
            'page_size' => 1
        );
        $zs_count_total = 0;
        $ck_count_total = 0;
        foreach ($shop_list as &$shop) {
            $this->checkAccessTokenPast($shop);
            $taobao_result = \Taobao::curl_taobao_api('taobao.items.inventory.get', $shop['access_token'], $params);
            if (!\Taobao::get_taobao_response($taobao_result, 'items_inventory_get_response', $response)) myerror(\StatusCode::msgCheckFail, '获取仓库中的商品失败:' . $response->sub_msg);
            $zs_count = $response->total_results;
            $zs_count_total += $zs_count;
            $taobao_result_1 = \Taobao::curl_taobao_api('taobao.items.onsale.get', $shop['access_token'], $params);
            if (!\Taobao::get_taobao_response($taobao_result_1, 'items_onsale_get_response', $response_1)) myerror(\StatusCode::msgCheckFail, '获取出售中的商品失败:' . $response_1->sub_msg);
            $ck_count = $response_1->total_results;
            $ck_count_total += $ck_count;
            $shop['goods_count'] = $zs_count + $ck_count;
            unset($shop['access_token']);
        }
        $result['zs_count_total'] = $zs_count_total;
        $result['ck_count_total'] = $ck_count_total;
        $result['shop_list'] = 0 < count($shop_list) ? $shop_list : array();
        return $result;
    }

    /**
     * 检查淘宝账号授权是否过期
     * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
     * @param type $shop
     * @since  20160902
     */
    public function checkAccessTokenPast($shop) {
        if ($shop['addtime'] >= $shop['expire_time'] / 1000) {
            myerror(\StatusCode::msgTokenAccessOvertime, $shop['nick'] . " 店铺授权已过期，请重新授权！");
        }
    }

    /**
     * 获取淘宝授权
     */
    public function get_tb_authorize() {
        //https://oauth.taobao.com/authorize?spm=a219a.7386781.0.0.qOgstw&response_type=code&client_id=23329158&redirect_uri=http://api.mycxf.com/callback&state=2366&view=web#
        // 这个是淘宝回调
        // state 传入我们帐号的id
        //，会把token存入fx_tb_user 里面
        //web:web、tmall或wap
        $data = $this->request;
        $user_id = isset($data->user_id) ? $data->user_id : null;
        \Valid::has_number($user_id)->withError('错误的用户信息！');
        $taobao_app_key = \Taobao::TAOBAO_APP_KEY;
        $taobao_oauth_redirect_url = \Taobao::TAOBAO_OAUTH_REDIRECT_URL;
        $state = array(
            'source' => 'cxf_web',
            'userid' => $user_id,
        );
        $auth_url = 'https://oauth.taobao.com/authorize?spm=a219a.7386781.0.0.qOgstw&response_type=code&client_id=' . $taobao_app_key . '&redirect_uri=' . $taobao_oauth_redirect_url . '&state=' . base64_encode(json_encode($state)) . '&view=web';
        $this->response(array('redirect_url' => $auth_url));
    }

}
