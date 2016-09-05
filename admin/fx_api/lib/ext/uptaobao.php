<?php

header("Content-type:text/html;charset=UTF-8");
ini_set('date.timezone', 'Asia/Shanghai');
require_once 'Taobao.php';

/**
 * 
 * @param type $url 是远程图片的完整URL地址，不能为空。
 * @param string $filename  是可选变量: 如果为空，本地文件名将基于时间和日期
 * @return boolean|string$url 
 */
function GrabImage($url, $filename, $file_path) {
    if ($url == "") return false;
    $filepath = $file_path . '/' . $filename;
    ob_start();
    readfile($url);
    $img = ob_get_contents();
    ob_end_clean();
    $size = strlen($img);
    $fp2 = @fopen($filepath, 'a');
    fwrite($fp2, $img);
    fclose($fp2);
    return $filepath;
}

class Uptaobao {

    /**
     * 图片上传淘宝
     * @param type $upyun_img
     */
    public static function get_taobao_url($upyun_img) {
//        $targetFolder = dirname(__FILE__).'../../../../../../data//run/tmp/tb';
        $targetFolder = '/tb';
        if (!is_dir($targetFolder)) mkdir($targetFolder, 0777, true);
        $path_info = pathinfo($upyun_img);
        $filename = $targetFolder . $path_info['basename'];
        @unlink(realpath($filename));
        $imageData = file_get_contents($upyun_img);
        $tp = @fopen($filename, 'a');
        fwrite($tp, $imageData);
        fclose($tp);
        $path_parts = pathinfo($filename);
        $path = GrabImage($filename, $path_parts['basename'], $path_parts['dirname']);
        $params = array(
            'picture_category_id' => '199751275281407248',
            'img' => new \CURLFile(realpath($path)),
            'image_input_title' => $path_parts['basename']
        );
        $taobao_result = \Taobao::curl_taobao_api_file('taobao.picture.upload', \Taobao::TABAO_SYS_ACCESS_TOKEN, $params, NULL, TRUE);
        if (!\Taobao::get_taobao_response($taobao_result, 'picture_upload_response', $response)) {
            // sleep(3);
            return null;
        }
        $img_path = $response->picture->picture_path;
        @unlink(realpath($path));
        return $img_path;
    }

}
