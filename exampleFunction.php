<?php
// 达达配送使用方法
/**
 * 达达配送对接
 * @param  string   $body           业务参数，JSON字符串，详见具体的接口文档
 * @param  string   $url            请求URL
 * @param  int      $source_id      商户编号,测试环境默认为：73753
 * @return boolean|mixed 
 */
function dadaRequest($body,$url,$source_id){
    include_once "dadaSDK.php";
    $app_id = '';//填写你的开发者app_id
    $app_secret = '';//填写你的开发者app_secret
    $baseUrl = 'http://newopen.qa.imdada.cn';//测试API地址
    // $baseUrl = 'http://newopen.imdada.cn';//正式API地址
    $_url = $baseUrl.$url;
    $data = dadaSDK::formatData($body,$source_id,$app_id);
    $data['signature'] = dadaSDK::signData($data,$app_secret);
    $_data = json_encode($data);
    $res = dadaSDK::dadaPost($_url,$_data);
    return json_decode($res,true);
}