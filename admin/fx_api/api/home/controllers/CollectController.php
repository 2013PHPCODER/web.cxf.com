<?php

namespace api\home;

/**
 * 分销商中心收藏夹
 * @author shenlang
 * 2016‎/8‎/9‎
 */
class CollectController extends Controller {

    /**
     * 添加商品到收藏夹
     */
    public function collectAdd() {
        $request = $this->request;
        $goods_id = $request->goods_id;
        $user_id = $request->user_id;
        $must = ['user_id', 'goods_id'];
        batch_isset($request, $must);
        \Valid::has_number($user_id)->withError('用户id错误');
        \Valid::has_number($goods_id)->withError('商品id错误');
        $collect_model = \Model::fx_goods_collect();
        $collect_dao = \Dao::fx_goods_collect();
        //判断是否已经收藏该商品
        $collect_model->user_id = $user_id;
        $collect_model->goods_id = $goods_id;
        $collectArr = $collect_dao->getList($collect_model);
        if (!empty($collectArr['list'])) {
            $this->response['fail'] = 0;
            $this->response['msg'] = "该商品已收藏！";
            $this->response();
            exit;
        }
        $collect_model->addtime = date("Y-m-d H:i:s",  time());
        $re = $collect_dao->insert($collect_model);
        if (is_numeric($re) && 0 !== $re) {
            //改变商品收藏总量
            $changere = $collect_dao->changeCollectCount($goods_id, 1);
            $this->response['sucess'] = 1;
            $this->response['msg'] = "添加成功！";
        } else {
            $this->response['fail'] = 0;
            $this->response['msg'] = "添加失败！";
        }
        $this->response();
    }

    /**
     * 获取商品收藏列表
     */
    public function collectList() {
        $request = $this->request;
        if (empty($request->user_id)) {
            myerror(\StatusCode::msgCheckFail, '用户id错误');
        }
        $user_id = $request->user_id;
        $page = isset($request->page) ? $request->page : 1;
        //  搜索是否已经上传到淘宝
        $is_up_taobao = isset($request->is_up_taobao) ? $request->is_up_taobao : '';
        $dao = \Dao::fx_goods_collect();
        $collectList = $dao->getCollectList($user_id, $page, 20, $is_up_taobao);
        if (NULL == $collectList) {
            $this->response['sucess'] = NULL;
            $this->response['msg'] = '收藏夹为空!';
            $this->response();
        }else{
           $this->response($collectList); 
        }
        
    }

    /**
     * 删除收藏
     */
    public function collectDelete() {
        $request = $this->request;
        $user_id = $request->user_id;
        $goods_id = $request->goods_id;
        $must = ['user_id', 'goods_id'];
        batch_isset($request, $must);
        \Valid::has_number($user_id)->withError('用户id错误');
        \Valid::not_empty($goods_id)->withError('商品id错误');
        $dao = \Dao::fx_goods_collect();
        $re = $dao->delCollect($user_id, $goods_id);
        if (is_numeric($re) && 0 !== $re) {
            $this->response['sucess'] = 1;
            $this->response['msg'] = "删除成功！";
        } else {
            $this->response['fail'] = 0;
            $this->response['msg'] = "删除失败！";
        }
        $this->response();
    }

}
