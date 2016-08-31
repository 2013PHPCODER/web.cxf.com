<?php

namespace api\home;

class GoodsController extends Controller {

    private $goods_dao;

    public function __construct() {
        parent::__construct();
        $this->goods_dao = \DAO::Goods_list();
    }

    /**
     * 货源中心
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608161554
     */
    public function goods_center() {
        //获取7个一级分类
        $_goods_list_dao = \Dao::Goods_list();
        $_re_goods_center = $_goods_list_dao->goods_center();
        if (empty($_re_goods_center)) myerror(\StatusCode::msgCheckFail, \goods::goods_data_nnot);
        //热销商品
        $_hot_goods = $_goods_list_dao->hot_goods_rand_eight();
        $this->response(array('good_center' => $_re_goods_center, 'hot_goods' => $_hot_goods));
    }

    /**
     * 获取二级分类十个随机商品
     * @param int $_goods_category 商品类目
     * @return array 
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608171601
     */
    public function goods_center_two() {
        batch_isset($this->request, array('cid'));
        \Valid::has_number($this->request->cid)->withError('二级分类错误');
        $_re_goods_center = \Dao::Goods_list()->rand_goods($this->request->cid);
        if (!$_re_goods_center) myerror(\StatusCode::msgCheckFail, \goods::goods_data_nnot);
        $this->response($_re_goods_center);
    }

    public function index() {
//        $goods_dao = \DAO::Goods_list();
//        $goods_list_model = \Model::Goods_list();
//        $sql = 'select * from goods_list where goods_id=:id';
//        print_r($goods_dao->query($sql, array('id' => 1)));
//        exit;
//        print_r($goods_dao->count($goods_list_model));
    }

    /**
     * 商品详情页接口
     */
    public function goods_detail() {
        $request = $this->request;
        $goods_id = isset($request->goods_id) ? $request->goods_id : null;
        \Valid::has_number($goods_id)->withError('错误的商品！');
        $platform = isset($request->platform) ? $request->platform : null;
        if (!in_array($platform, array(1, 2))) {
            myerror(\StatusCode::msgCheckParmeterStatus, '错误的商品！');
        }
        $detail = $this->goods_dao->get_goods_detail($goods_id, $platform);
        $detail['detail']['is_collect'] = false;
        //检查用户是否收藏了该商品
        $user_id = isset($request->user_id) ? $request->user_id : null;
        if ($user_id) {
            $goods_collect_dao = \Dao::Fx_goods_collect();
            $detail['detail']['is_collect'] = $goods_collect_dao->check_collect($user_id, $goods_id);
        }
        $this->response($detail);
    }

    /**
     * 根据sku组合查询sku信息
     */
    public function get_goods_sku_info() {
        $request = $this->request;
        $goods_id = isset($request->goods_id) ? $request->goods_id : null;
        $sku_str = isset($request->sku_str) ? $request->sku_str : null;
        \Valid::has_number($goods_id)->withError('错误的商品！');
        \Valid::has_string($sku_str)->withError('错误的商品属性！');
        $sku_info = $this->goods_dao->get_sku_comb($goods_id, $sku_str);
        $sku_info['price'] = change_price($sku_info['original_price']);
        unset($sku_info['original_price']);
        $this->response(array('sku_info' => $sku_info));
    }

    /**
     * 一键铺货接口
     */
    public function item_add_taobao() {
        $request = $this->request;
        $goods_id = isset($request->goods_id) ? $request->goods_id : null;
        $platform = isset($request->platform) ? $request->platform : null;
        $user_id = isset($request->user_id) ? $request->user_id : null;
        $tb_user_id = isset($request->tb_user_id) ? $request->tb_user_id : null;
        $user_account = isset($request->user_account) ? $request->user_account : null;
        //运费方式
        $freight_type = isset($request->freight_type) ? $request->freight_type : 0;
        //运费自填
        $freight_fee = isset($request->freight_fee) ? $request->freight_fee : 0;
        //运费模板id
        $template_id = isset($request->template_id) ? $request->template_id : null;
        if (!$tb_user_id) myerror(\StatusCode::msgCheckFail, '淘宝信息错误！');
        \Valid::has_number($goods_id)->withError('错误的商品！');
        \Valid::has_number($platform)->withError('错误的平台信息！');
        \Valid::has_number($user_id)->withError('错误的用户信息！');
        \Valid::has_number($freight_type)->withError('错误的模板信息！');
        //运费
        if ($freight_type == 1 && ($freight_fee < 0.01 || $freight_fee > 999)) myerror(\StatusCode::msgCheckFail, '运费有效区间为:0.01-999！');
        if ($freight_type == 2 && $template_id <= 0) myerror(\StatusCode::msgCheckFail, '请选择运费模板！');
        $freight_payer = $freight_type > 0 ? 'buyer' : 'seller';
        //获取用户的淘宝信息
        $tb_dao = \DAO::fx_tb_user();
        $tb_user_info = $tb_dao->get_taobao_user_info($user_id, $tb_user_id);
        if ($tb_user_info) $access_token = $tb_user_info['access_token'];
        if (!isset($access_token) || strlen($access_token) <= 0) myerror(\StatusCode::msgCheckFail, '淘宝令牌失效！');
        //获取商品信息
        $goods_info = $this->goods_dao->get_goods_info_tb($goods_id);
        $taobao_imgs = $this->goods_dao->change_imgs_tb($goods_info['img_paths']);
        $goods_property = $this->goods_dao->get_goods_propety($goods_id);
        $sku_props_array = $this->goods_dao->get_sku_props_string_array(get_property_val($goods_property, 'price'), get_property_val($goods_property, 'num'), get_property_val($goods_property, 'skuProps'), $goods_id);
//        $item_price = bcadd(get_property_val($goods_property, 'price'), bcmul(get_property_val($goods_property, 'price'), 0.1, 2), 2); //商品价格在分销价基础上提高10%
        $level_price = change_price($goods_info['price']);
        $item_price = $level_price['distribution_price']; //bcadd(get_property_val($goods_property, 'price'), bcmul(get_property_val($goods_property, 'price'), 0.1, 2), 2); //商品价格在分销价基础上提高10%
        if (0 >= $item_price) {
            $this->goods_dao->add_uptaobao_log($user_id, $user_account, $goods_id, $goods_info['goods_name'], $item_price, 0, $tb_user_info['nick'], '商品价格为0！');
            myerror(\StatusCode::msgCheckFail, '商品价格为0！');
        }
        //强制让每个sku价格和商品价格保持一致
        $sku_price_arr = array_pad(array(), substr_count($sku_props_array['sku_prices'], ',') + 1, $item_price);
        $sku_props_array['sku_prices'] = implode(',', $sku_price_arr);
        //上传淘宝需要的参数
        $params = array(
            'num' => get_property_val($goods_property, 'num'),
            'price' => $item_price,
            'type' => 'fixed',
            'stuff_status' => 'new',
            'location.state' => get_property_val($goods_property, 'location_state'),
            'location.city' => get_property_val($goods_property, 'location_city'),
            'title' => $goods_info['goods_name'], //get_property_val($goods_property, 'title'),
            'cid' => $goods_info['goods_category'], // get_property_val($goods_property, 'cid'),
            'outer_id' => get_property_val($goods_property, 'outer_id'),
            'props' => get_property_val($goods_property, 'cateProps'),
            'property_alias' => get_property_val($goods_property, 'propAlias'),
            'input_pids' => get_property_val($goods_property, 'inputPids'),
            'input_str' => get_property_val($goods_property, 'inputValues'),
            'freight_payer' => get_property_val($goods_property, 'freight_payer'),
            'qualification' => get_property_val($goods_property, 'qualification'),
            'features' => get_property_val($goods_property, 'features'),
            'input_custom_cpv' => get_property_val($goods_property, 'input_custom_cpv'),
            'sku_properties' => $sku_props_array['sku_properties'],
            'sku_quantities' => $sku_props_array['sku_quantities'],
            'sku_prices' => $sku_props_array['sku_prices'],
            'sku_outer_ids' => $sku_props_array['sku_outer_ids'],
            'freight_payer' => $freight_payer,
            'pic_path' => $goods_info['img_path'],
            'desc' => $goods_info['desc'],
            'wireless_desc' => $goods_info['wireless_desc'],
            'approve_status' => 'instock' //默认上传到仓库中
        );
        if (isset($request->cid) && !empty($request->cid)) {
            $params['seller_cids'] = $request->cid;
        }
        //运费
        if ($freight_type == 1) {
            $params['post_fee'] = $freight_fee;
            $params['express_fee'] = $freight_fee;
            $params['ems_fee'] = $freight_fee;
        } elseif ($freight_type == 2) {
            $params['postage_id'] = $template_id;
        }
        $upload_item_result = $this->goods_dao->internal_upload_item($access_token, $params, get_property_val($goods_property, 'picture'), $taobao_imgs, $err_msg);
        if (!$upload_item_result) {
            $reject_taobao_error_msg_array = array(
                '超过此类目宝贝数量限额',
                '需要提交保证金'
            );
            foreach ($reject_taobao_error_msg_array as $error_msg) {
                if (strpos($err_msg, $error_msg) !== false) {
                    $this->goods_dao->add_uptaobao_log($user_id, $user_account, $goods_id, $goods_info['goods_name'], $item_price, 0, $tb_user_info['nick'], $err_msg);
                    myerror(\StatusCode::msgCheckFail, $err_msg);
                }
            }
            if (strpos($err_msg, '属性出错:在标准属性中不存在') !== false) {
                
            } else {
                $this->goods_dao->add_uptaobao_log($user_id, $user_account, $goods_id, $goods_info['goods_name'], $item_price, 0, $tb_user_info['nick'], $err_msg);
                myerror(\StatusCode::msgCheckFail, $err_msg);
            }
        }
        //铺货完成记录对应记录
        $this->goods_dao->add_uptaobao_log($user_id, $user_account, $goods_id, $goods_info['goods_name'], $item_price, 0, $tb_user_info['nick'], $err_msg);
        //修改收藏记录表记录
        $this->goods_dao->update_collect_log($user_id, $goods_id);
        $this->response(array('sucess' => true, 'msg' => '铺货成功'));
    }

    /**
     * 获取店铺分类和运费模板
     */
    public function tb_template() {
        import('Taobao');
        $user_id = isset($this->request->user_id) ? $this->request->user_id : null;
        $shop_id = isset($this->request->shop_id) ? $this->request->shop_id : null;
        \Valid::has_number($user_id)->withError('错误的用户信息！');
        \Valid::has_number($shop_id)->withError('错误的店铺信息！');
        $tb_dao = \DAO::fx_tb_user();
        $tb_user = $tb_dao->get_taobao_user_info($user_id, $shop_id);
        $params = array(
            'nick' => $tb_user['nick']
        );
        $taobao_result = \Taobao::curl_taobao_api('taobao.sellercats.list.get', $tb_user['access_token'], $params);
        if (!\Taobao::get_taobao_response($taobao_result, 'sellercats_list_get_response', $response)) myerror(\StatusCode::msgDBFail, '获取运费模板失败:' . $response->msg);
        $seller_cats = (array) $response->seller_cats->seller_cat;
        $tparams = array(
            'fields' => 'template_id,template_name'
        );
        $tem_result = \Taobao::curl_taobao_api('taobao.delivery.templates.get', $tb_user['access_token'], $tparams);
        if (!\Taobao::get_taobao_response($tem_result, 'delivery_templates_get_response', $response)) myerror(\StatusCode::msgDBFail, '获取运费模板失败:' . $response->msg);
        $delivery_templates = (array) $response->delivery_templates->delivery_template;
        $this->response(array('seller_cats' => $seller_cats, 'delivery_templates' => $delivery_templates));
    }

    /* 生成商品csv数据包 */

    public function downloadcsv() {
        $q = new \stdClass(); //$this->request;
        if (!isset($_POST['goods_ids']) || empty($_POST['goods_ids'])) {
            myerror(\StatusCode::msgCheckFail, '商品订单id不能为空！');
        }
        $q->goods_ids = $_POST['goods_ids'];
        define('BASE_PATH', str_replace('\\', '/', realpath($_SERVER["DOCUMENT_ROOT"] . "/../public")) . "/");
        $Y = BASE_PATH;
        $goods_ids = $q->goods_ids; //'1,2,3';// 
        //获得数据包生成数据(获取csv内容数据，读取数据库)
        $arr = $this->goods_dao->get_good_data($goods_ids);
        //获得数据包主图图片数组
        $ppp = $this->goods_dao->getImgs($arr);
        //拼装csv 头部
        $list = $this->goods_dao->GetCsvContent($arr);
        $bagname = date("YmdHis");
        $opath = $this->goods_dao->format("{0}tmp/{1}", BASE_PATH, $bagname);
        $this->goods_dao->mk_dir($opath);
        $filename = $this->goods_dao->format("{0}tmp/{1}.csv", BASE_PATH, $bagname);
        $fp = fopen($filename, 'w');

        /** 更新 By aidi 201607227 S */
        $str = iconv('utf-8', 'gbk', '$');
        foreach ($list as $line) {
            $arr = explode($str, $line);
            fputcsv($fp, $arr);
        }
        /** 更新 By aidi 201607227 E */
        fclose($fp);
        $zip = new \ZipArchive();
        $flo = date("YmdHis");
        $apb = BASE_PATH . 'tmp/end.zip';
        if ($zip->open($apb, \ZipArchive::OVERWRITE)) {
            //    $txt = file_get_contents(BASE_PATH . iconv('utf-8', 'gb2312', $txt_name));
            $ff = file_get_contents($filename);
            unlink($filename);
            $na = basename($filename);
            $zip->addFromString($na, $ff);
            //$zip->addFromString(iconv('utf-8', 'gb2312', $txt_name), $txt);
            $zip->addEmptyDir($flo);
            foreach ($ppp as $key => $file) {
                //  $newJpgName ="old"; //dealUploadJpg($file);
                // $zip->addFromString($flo . '/' . basename($newJpgName), file_get_contents($file));
                //  $zip->addFromString($flo . '/' . basename($file), file_get_contents($file));
                $zip->addFromString($flo . '/' . $key, file_get_contents($file));
            }
            $zip->close();
        }
        header("Content-disposition: attachment; filename=$flo.zip");
        header('Content-type: application/zip');
        readfile($apb);
        unlink($apb);
        rmdir(BASE_PATH . 'tmp');
    }

}
