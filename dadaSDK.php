<?php
/**
 * 达达配送SDK
 * formatData   数据格式化
 * signData     数据签名
 * dadaPost     请求接口
 * author 安震    anzhen9@hotmail.com    2018-04-28
 */
class dadaSDK{
    /**
     * 数据格式化
     * @param $body
     * @param $source_id
     * @param $app_id
     * @return array
     */
    public static function formatData($body,$source_id,$app_id){
        return [
            "body"          => $body,
            "format"        => "json",
            "timestamp"     => time(),
            "app_key"       => $app_id,
            "v"             => "1.0",
            "source_id"     =>$source_id
        ];
    }
    /**
     * 生成签名
     * @param $data
     * @param @app_secret
     * @return string
     */
    public static function signData($data,$app_secret){
        $sig = $app_secret."app_key".$data['app_key']."body".$data['body']."format".$data['format']."source_id".$data['source_id']."timestamp".$data['timestamp']."v".$data['v'].$app_secret;
        return strtoupper(md5($sig));
    }
     /**
     * POST请求
     * @param $url
     * @param $param
     * @return boolean|mixed
     */
    public static function dadaPost($url, $param, $method = "POST") { 
        if (!empty($param) and is_array($param)) {
            $param = urldecode(json_encode($param));
        } else {
            $param = strval($param);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     //  不进行ssl 认证
        curl_setopt($ch, CURLOPT_POST, true);
        $header = array();
        $header[] = 'Authorization:'.$tmp;
        $header[] = 'Accept:application/json';
        $header[] = 'Content-Type:application/json;charset=utf-8';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (!empty($result) and $code == '200') {
            return $result;
        }
        return false;
    }
}