<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 图片自动生成不同尺寸
 */
class ImageController extends Controller{

    /**
     * 获取图片地址
     */
    public function url(){
        $url = urldecode(I('get.u','',false));
        $param = I('get.p','');
        $key = I('get.k','');
        $lmd5 = md5($url . $param . C('IMAGE_CHECK_KEY'));
        $newPath = '/auto/' . substr($lmd5,0,2) . '/';
        $newurl = $newPath . $lmd5 . '.jpg';

        //验证md5
        if(!$key || $key != substr($lmd5,8,16)){
            return;
        }

        //查看新图片是否存在
        $fullurl = get_upload_url($newurl);
        if(is_file(C('UPLOAD_PATH') . $newurl)){
            header('Location: ' . $fullurl);
            return;
        }

        //查看原始图片是否存在
        if(!is_file($_SERVER['DOCUMENT_ROOT'] . $url)){
            return $url;
        }


        //获取参数
        $parr = array();
        $arr = explode('-',$param);
        for($i = 0; $i < count($arr) / 2; $i++){
            $parr[$arr[$i * 2]] = $arr[($i * 2) + 1];
        }

        //验证高宽
        if(empty($parr['w']) || empty($parr['h'])){
            return;
        }

        //压缩图片方式，默认为居中裁剪
        $type = !empty($parr['tp']) ? intval($parr['tp']) : 3;

        //创建路径
        if(!is_dir(C('UPLOAD_PATH') . $newPath)){
            mkdir(C('UPLOAD_PATH') . $newPath,0777,true);
        }


        //生成图片
        $image = new \Think\Image();
        $image->open($_SERVER['DOCUMENT_ROOT'] . $url);
        $image->thumb($parr['w'],$parr['h'],$type)->save(C('UPLOAD_PATH') . $newurl);

        //水印
        if(!empty($parr['wa'])){
            
        }
        //转到新图片
        header('Location: ' . $fullurl);
    }

//    public function test(){
//        $u = img_url_by_arr(array(
//            'u'=>'Public/upload/20160616/6bd5aaf9bdc2cb85e9b9b98fb2842a9c.jpg',
//            'w'=>200,
//            'h'=>200,
//            'tp'=>1,
//            'wa'=>1,
//        ));
//
//        echo '<img src="' . $u . '" />';
//    }

}
