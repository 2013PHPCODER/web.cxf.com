<?php

namespace Goods\Controller;

use Think\Controller;
use Org\Util\Taobao;

class CrontabController extends Controller {

    /**
     * 自动更新类目下面有没有商品
     */
    public function category() {
        $sql = 'SELECT DISTINCT(goods_category) FROM goods_list WHERE goods_status=3 and is_delete=0 AND is_missing=0 and goods_sale=1';
        $category = D()->query($sql);
        if (!empty($category)) {
            $cat = array();
            foreach ($category as $value) {
                $list = $this->get_category($value['goods_category']);
                $cat = array_merge($cat, $list);
            }
        }
        array_unique($cat);
        if (!empty($cat)) {
            $update_sql = 'update goods_category set has_goods=0 where 1=1';
            D()->execute($update_sql);
            $cate_list = trim(implode(',', $cat), ',');
            $update_category_sql = 'update goods_category set has_goods=1 where cid in (' . $cate_list . ')';
            D()->execute($update_category_sql);
        }
        echo 'ok';
    }

    /**
     * 递归获取类目上级id
     */
    private function get_category($category_id) {
        $list = array();
        array_push($list, $category_id);
        $sql = 'SELECT parent_cid FROM `goods_category` WHERE cid="' . $category_id . '"';
        $data = D()->query($sql);
        while ($data[0]['parent_cid']) {
            array_push($list, $data[0]['parent_cid']);
            $sql = 'SELECT parent_cid FROM `goods_category` WHERE cid="' . $data[0]['parent_cid'] . '"';
            $data = D()->query($sql);
        }
        return $list;
    }

    /**
     * 上传图片到淘宝空间并修改对应商品图片地址
     */
    public function upload_tb_img() {
        set_time_limit(0);
        $sql = 'SELECT * FROM `goods_img_path` WHERE tb_path is NULL and upyun_path is not null';
        $imgs = D()->query($sql);
        if (empty($imgs)) die('ok');
        $s = 0;
        $targetFolder = '.' . C('UPLOAD_URL') . date('ymd') . '/';
        if (!is_dir(ROOT_DIR . $targetFolder)) mkdir(ROOT_DIR . $targetFolder, 0777, true);
        foreach ($imgs as $val) {
            $s++;
            //下载图片
            $path_info = pathinfo($val['upyun_path']);
            $filename = $targetFolder . $path_info['basename'];
            @unlink(realpath($filename));
            $imageData = file_get_contents($val['upyun_path']); //$this->getBytes(file_get_contents($val['upyun_path']));
            $tp = @fopen($filename, 'a');
            fwrite($tp, $imageData);
            fclose($tp);
            //将图片上传淘宝，返回淘宝图片地址
            $path = $this->get_taobao_url($filename, $path_info['basename']);
//            echo $path . "\n";
            if ($path) {
                M('goods_img_path')->where(array('md5_path' => $val['md5_path']))->save(array('tb_path' => $path));
            }
            if ($s % 10 == 0) {
                sleep(5);
            }
        }
        die('ok');
    }

    /**
     * 转换图片地址
     * @param type $pic
     */
    private function get_taobao_url($pic) {
        $path_parts = pathinfo($pic);
        $path = GrabImage($pic, $path_parts['basename'], $path_parts['dirname']);
        $params = array(
            'picture_category_id' => '199751270034194382', //开店助理图片空间分类id
            'img' => new \CURLFile(realpath($path)),
            'image_input_title' => $path_parts['basename']
        );
        $taobao_result = Taobao::curl_taobao_api_file('taobao.picture.upload', Taobao::TABAO_SYS_ACCESS_TOKEN, $params, NULL, TRUE);
//        print_r($taobao_result);
//        exit;
        if (!Taobao::get_taobao_response($taobao_result, 'picture_upload_response', $response)) {
            sleep(10);
            return false;
        }
        $img_path = $response->picture->picture_path;
        @unlink(realpath($path)); //删除上传的图片
        return $img_path;
    }

    /**
     * 虚拟订单检测
     */
    public function check_virtual_order() {
        $sql = 'select ';
    }

}
