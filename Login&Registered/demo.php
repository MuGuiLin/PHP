<?php
    header("Content-Type:text/html;charset=utf8");
    error_reporting(E_ALL ^ E_DEPRECATED);
    date_default_timezone_set('PRC');
    
    $data = array(
        'tid' => 100,
        'name' => '标哥的技术博客',
        'site' => 'www.huangyibiao.com');
     
    $response = array(
        'code'  => 200,
        'message' => 'success for request',
        'data'  => $data,
    );
    
    echo json_encode($response);