# dadaSDK
# 达达配送开放平台上提供的demo压缩文件损坏
自己尝试做了个SDK
具体使用请结合达达开放平台提供的开发文档使用
# exampleFunction.php里写了个示例请求方法，可以直接使用
```PHP
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
```