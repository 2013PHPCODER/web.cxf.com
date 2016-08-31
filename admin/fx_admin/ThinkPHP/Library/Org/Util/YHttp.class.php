<?php
namespace Org\Util;
/**
 * 模拟http请求
 *
 * @author 生姜头
 * @version 2016/6/23
 */
class YHttp{

    /**
     * 发送HTTP请求
     * @param type $url url地址
     * @param type $params 发送的参数，字符串或数组都可以
     * @param type $method GET或POST方式
     * @param type $header 请求头
     * @param type $timeout 超时时间
     * @return array
     */
    static public function sendHttpRequest($url,$params = array(),$method = 'GET',$header = array(),$timeout = 5){
        if(function_exists('curl_init')){
            $ch = curl_init();
            if($method == 'GET'){
                $data = is_array($params) ? http_build_query($params) : $params;
                if(strpos($url,'?'))
                    $url .= '&' . $data;
                else
                    $url .= '?' . $data;
                curl_setopt($ch,CURLOPT_URL,$url);
            }elseif($method == 'POST'){
                $post_data = is_array($params) ? http_build_query($params) : $params;
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
                curl_setopt($ch,CURLOPT_POST,true);
            }
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            if(!empty($header)){
                //curl_setopt($ch, CURLOPT_NOBODY,FALSE);
                curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
                curl_setopt($ch,CURLINFO_HEADER_OUT,TRUE);
            }
            if($timeout)
                curl_setopt($ch,CURLOPT_TIMEOUT,$timeout); //设置超时
            $content = curl_exec($ch);
            $info = curl_getinfo($ch);
            $errors = curl_error($ch);
            $header_size = $info['header_size'];
            $body = substr($content,$header_size);
            $uri = $_SERVER["REQUEST_URI"];
            if(!empty($errors)){
                //write_log("get-supply-api-","[req_url=>$uri]\n[url=>$url]\n[post=>" . json_encode($params) . "]\n[info:$info]\n[header=>$header]\n[body=>$body]\n\n', 'error");
            }else{
                if(DEBUG_MODE)
                    //write_log("get-supply-api-","[req_url=>$uri]\n[url=>$url]\n[post=>" . json_encode($params) . "]\n[info:$info]\n[header=>$header]\n[body=>$body]\n\n","debug");
                $content = json_decode($content,false,512,JSON_BIGINT_AS_STRING);
                $content->raw = $body;
                if(!isset($content) || !isset($content->status) || strcmp($content->status,'1') !== 0){
                    //write_log("get-supply-api-","[req_url=>$uri]\n[url=>$url]\n[post=>" . json_encode($params) . "]\n[body=>$body]\n\n","SUPPLYERRRSP");
                }
                return $content;
            }
            return false;
        }else{
            $data_string = http_build_query($params);
            $context = array(
                'http' => array('method' => $method,
                    'header' => 'Content-type: application/x-www-form-urlencoded' . "\r\n" .
                    'Content-length: ' . strlen($data_string),
                    'content' => $data_string)
            );
            $contextid = stream_context_create($context);
            $sock = fopen($url,'r',false,$contextid);
            if($sock){
                $result = '';
                while(!feof($sock))
                    $result.=fgets($sock,4096);
                fclose($sock);
            }
            return $result;
        }
    }

}
