

<?php


ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.

set_time_limit(3000);// 通过set_time_limit(0)可以让程序无限制的执行下去

$interval=5;// 每隔5s运行

 

//方法1--死循环

// do{

//     echo '测试'.time().'<br/>'; 

//     sleep($interval);// 等待5s    

// }while(true);

 

//方法2---sleep 定时执行

    //require_once './curlClass.php';//引入文件

     

   // $curl = new httpCurl();//实例化

    $stime = $curl->getmicrotime();

    for($i=0;$i<=10;$i++){
 
        echo '测试'.time().'<br/>'; 

        sleep($interval);// 等待5s

    }

    ob_flush();

    flush();

    $etime = $curl->getmicrotime();

    echo '<hr>';

    echo round(($etime-stime),4);//程序执行时间 
?>