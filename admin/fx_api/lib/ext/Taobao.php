<?php

/**
 * 淘宝API
 *
 * @author 燕十三
 * @version 2015/10/20
 */
class Taobao {

    const TAOBAO_APP_KEY = '23431529';
    const TAOBAO_APP_SECRET = 'dc6af151a34081f4689bd562066b47a5';

    //const TAOBAO_ACCESS_TOKEN = '';

    public static function sign_taobao_params(array $params) {
        ksort($params);
        $to_sign = self::TAOBAO_APP_SECRET;
        foreach ($params as $key => $value) {
            $to_sign .= "$key$value";
        }
        unset($key, $value);
        $to_sign .= self::TAOBAO_APP_SECRET;
        return strtoupper(md5($to_sign));
    }

    public static function curl_taobao_api($method, $access_token, $params = NULL, $fields = NULL, $multipart = false, $retry_times = 0) {
        $url = 'https://eco.taobao.com/router/rest';
        $post_data = array(
            'method' => $method,
            'app_key' => self::TAOBAO_APP_KEY,
            'format' => 'json',
            'sign_method' => 'md5',
            'timestamp' => date('Y-m-d H:i:s'),
            'v' => '2.0'
        );
        if (!is_null($access_token)) {
            $post_data['session'] = $access_token;
        }
        $post_data = array_merge($post_data, $params);
        $post_data['sign'] = self::sign_taobao_params($post_data);
        $post_fields = http_build_query($post_data, null, '&', PHP_QUERY_RFC3986);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $result = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        $info = $curl_info['url'] . '|' . $curl_info['http_code'] . '|' . $curl_info['total_time'];
        $header_size = $curl_info['header_size'];
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        $uri = $_SERVER["REQUEST_URI"];
        curl_close($ch);
        $post_fields_text = is_array($post_fields) ? http_build_query($post_fields, null, '&', PHP_QUERY_RFC3986) : $post_fields;
        if ($curl_info['http_code'] == 0 || $curl_info['http_code'] >= 400) {
            write_log("get-taobao-api-$method", "[req_url=>$uri]\n[url=>$url]\n[info:$info]\n[header=>$header]\n[body=>$body]\n\n", "error");
        } else {
            if (Config('debug')) write_log("get-taobao-api-$method", "[req_url=>$uri]\n[url=>$url]\n[post=>$post_fields_text]\n[info:$info]\n[header=>$header]\n[body=>$body]\n\n", "debug");
            $result = json_decode($body, false, 512, JSON_BIGINT_AS_STRING);
            $result->raw = $body;
            if (!isset($result) || (isset($result->error_response) && $result->error_response && $result->error_response->code !== 7)) write_log("get-taobao-api-$method", "[req_url=>$uri]\n[url=>$url]\n[body=>$body]\n\n", "TBERRRSP");
            if (isset($result->error_response) && $result->error_response && $result->error_response->code === 7 && $retry_times < 3) {
                // This ban will last for 1 more seconds
                if (stripos($result->error_response->sub_msg, 'This ban will last for') !== false) {
                    //write_log("get-taobao-api-ban", "[$method] Retry for ban with $retry_times times", "TBBANRETRY");
                    $seconds = (int) trim(cut_str($result->error_response->sub_msg, 'This ban will last for', 'more seconds'));
                    //if ($seconds < 5) $seconds = 5;
                    if ($seconds < 1) $seconds = 1;
                    sleep($seconds);
                    $retry_times++;
                    return self::curl_taobao_api($method, $access_token, $params, $fields, $multipart, $retry_times);
                }
            }
            return $result;
        }
        return false;
    }

    public static function get_taobao_response($result, $root_response_name, &$response) {
        if (isset($result) && isset($result->error_response)) {
            $response = $result->error_response;
            $response->is_error = true;
            return false;
        }
        if (!isset($result) || !$result->$root_response_name) {
            $response = new \stdClass();
            $response->code = -1;
            $response->msg = "unknown error";
            $response->sub_code = "unknown error";
            $response->sub_msg = "未知错误";
            $response->is_error = true;
            return false;
        }
        $response = $result->$root_response_name;
        $response->is_error = false;
        return true;
    }

}
