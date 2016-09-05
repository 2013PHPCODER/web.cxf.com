<?php

/**
 * 首页
 */

namespace api\home;

class IndexController extends Controller {
    /**
     * 首页-1.类目-2.公告-3.热销商品
     * @param int $_to_client 客户端
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608111252
     */
    public function index() {
        //echo json_encode(array('to_client'=>1)); exit;
        //{"to_client":1}
        //公告验证客户端
        if (!isset($this->request->to_client))
            myerror(\StatusCode::msgCheckFail, \Index::to_client_not_null);
        \Valid::has_number($this->request->to_client)->withError(\Index::to_client_not_null);
        //类目数据
        $_goods_category_dao = \Dao::Goods_category();
        $_list = $_goods_category_dao->all_status_1_menu();
        foreach ($_list as $_key => $_value) {
            if (1 == $_value['level']) {
                $_level_1[] = $_value;
            } else {
                $_level_2[] = $_value;
            }
        }
        unset($_list);
        foreach ($_level_1 as $_key => $_value) {
            $_tmp_child = array();
            foreach ($_level_2 as $_v) {
                if ($_value['category_id'] == $_v['parent_id']) {
                    //$_tmp_child[] = array('cid' => $_v['cid'], 'name' => $_v['name'],'ico'=>$_v['ico']);
                    $_tmp_child[] = array('cid' => $_v['cid'], 'name' => $_v['name']);
                }
            }
            $_category_datas[] = array('name' => $_value['name'], 'cid' => $_value['cid'],
                'title' => $_value['title'], 'big_ico' => $_value['big_ico'], 'ico' => $_value['ico'],
                'child' => $_tmp_child);
            unset($_tmp_child);
        }
        if (empty($_category_datas)) {
            $this->response(\Index::category_datas_not);
            exit;
        }
        //公告
        $_notice_datas = \Dao::Fx_notice()->notice_index($this->request->to_client);
//        if (empty($_notice_datas)) {
//            $this->response(\Index::notice_datas_not);
//            exit;
//        }
        //热销商品
        $_hot_goods = \Dao::Goods_list()->hot_goods_rand_eight();
//        if (empty($_hot_goods)) {
//            $this->response(\Index::goods_datas_not);
//            exit;
//        }
        $this->response(array('category' => $_category_datas, 'notice' => $_notice_datas, 'goods' => $_hot_goods));
    }

//    /* 淘宝回调地址 */
//
//    public function tb_callback() {
//        if (isset($_GET["code"])) {
//            $call_parmeter = $_GET["code"];
//            $_custom_uid = $_GET["state"];
//            if (!empty($call_parmeter) && strlen($call_parmeter) > 0 && !empty($_custom_uid)) {
//                $ybc = $this->curlPost("https://oauth.taobao.com/token", $call_parmeter, 40, FALSE);
//                $_tb_data_arr = json_decode($ybc, true);
//                if (empty($_tb_data_arr))
//                    myerror(\StatusCode::msgCheckFail, \TbUser::tb_user_data_fail);
//                if (!\DAO::Fx_tb_user()->user_data_operation($_tb_data_arr, $_custom_uid))
//                    myerror(\StatusCode::msgCheckFail, \TbUser::tb_user_data_save_fail);
//                $this->response(\TbUser::tb_user_data_save_success);
//            }
//        } else {
//            myerror(\StatusCode::msgCheckFail, \TbUser::tb_user_data_fail);
//        }
//    }

    /* 首页新菜单接口 */

    public function index_category() {

        // $result = array(array("时尚服饰" => array("女鞋", "男鞋", "童装")), array("经典鞋靴" => array("男鞋", "女鞋", "童鞋")), array("服饰箱包" => array("服饰配件", "箱包")), array("美妆日化" => array("彩妆/香水/美妆工具")), array("运动户外" => array("户外/登山/野营/旅行用品", "运动/瑜伽/健身/球迷用品", "体育/健身/运
//动装")), array("家居家电" => array("家居饰品", "居家日用", "生活电器")), array("数码3C/其他" => array("3C数码配件", "软件")));
//           $j = new \stdClass; //实例化stdclass，这是php内置的空类，可以用来传递数据，由于json_decode后的数据是以对象数组的形式存放的，
////所以我们生成的时候也要把数据存储在对象中
//        foreach ($result as $key => $value) {
//            $j->$key = $value;
//        }        
//        $j = array(array(array("name" => "时尚服饰", "child" => array("女装", "男装", "童装"))), array(array("name" => "经典鞋靴", "child" => array("男鞋", "女鞋", "童鞋"))),
//            array(array("name" => "服饰箱包", "child" => array("服饰配件", "箱包"))), array(array("name" => "美妆日化", "child" => array("彩妆/香水/美妆工具"))),
//            array(array("name" => "运动户外", "child" => array("户外/登山/野营/旅行用品", "运动/瑜伽/健身/球迷用品", "体育/健身/运动装"))),
//            array(array("name" => "家居家电", "child" => array("家居饰品", "居家日用", "生活电器"))),
//            array(array("name" => "数码3C/其他", "child" => array("3C数码配件", "软件")))
//        );
//        die(json_encode($j));
        //类目数据
        $_goods_category_dao = \Dao::Goods_category();
        $model = \MODEL::Goods_category();
        $model->status = 1;
        $_list = $_goods_category_dao->get_index_category_test($model);

        $jobj = new \stdClass; //实例化stdclass，这是php内置的空类，可以用来传递数据，由于json_decode后的数据是以对象数组的形式存放的，
//所以我们生成的时候也要把数据存储在对象中
        foreach ($_list as $key => $value) {
            $jobj->$key = $value;
        }

        die(json_encode($jobj));
    }

    public function search_category() {
        //类目数据
        $_goods_category_dao = \Dao::Goods_category();
        $model = \MODEL::Goods_category();
        $model->status = 1;
        $_list = $_goods_category_dao->get_search_category($model);
    }

//    public function curlPost($url, $code, $timeout = 30, $CA = true) {
//        $data = array("client_id" => '23431728', "client_secret" => "dc6af151a34081f4689bd562066b47a5", "grant_type" => "authorization_code", "code" => $code, "redirect_uri" => "http://api.mycxf.com/callback");
//        //$arr = curlPost("https://oauth.taobao.com/token", $data, 40, FALSE);
//
//        $cacert = getcwd() . '/cacert.pem'; //CA根证书  
//        $SSL = substr($url, 0, 8) == "https://" ? true : false;
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout - 2);
//        if ($SSL && $CA) {
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书  
//            curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）  
//            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配  
//        } else if ($SSL && !$CA) {
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书  
//            //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名  
//            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名  
//        }
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题  
//        curl_setopt($ch, CURLOPT_POST, true);
//        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode  
//
//        $ret = curl_exec($ch);
//        //var_dump(curl_error($ch));  //查看报错信息  
//
//        curl_close($ch);
//        return $ret;
//    }

}
