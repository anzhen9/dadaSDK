# dadaSDK
达达配送开放平台上提供的demo压缩文件损坏
自己尝试做了个SDK
具体使用请结合达达开放平台提供的开发文档使用
exampleFunction.php里写了个示例请求方法，可以直接使用<br>
[达达配送开放平台地址](https://newopen.imdada.cn/#/development/file/index)
### 2018-04-24
达达的demo文件已更新，[下载地址](https://newopen.imdada.cn/static/Demo.zip)
# dadaSDK.php
```php
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
```
# exampleFunction.php
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
