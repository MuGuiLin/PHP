<?php
header("Content-type: text/html; charset=utf-8");
$token = '1cd12c6dbbba90e076c98ea5dd8f791e';

$apitoken = $_GET['token'];

if($apitoken != $token){
    echo 'token error';
    exit;
}


$postStr = file_get_contents("php://input");


function other_curl($uri, $data = FALSE, $timeOut = 30, $is_post = 1){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $uri); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    curl_close($curl); // 关闭CURL会话
    return json_decode ($tmpInfo ,true);
}

$url = 'https://lincoln.iooo.net/media_test/core.php/api/apply/media';

$resp = other_curl($url, $postStr);

if($resp['STATUS_CODE'] <= 0){
    echo json_encode(['code'=>10000, 'msg'=>'success']);
}else{
    echo json_encode($resp);
}