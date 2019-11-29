<?php
    error_reporting(E_ALL ^ E_DEPRECATED); //开启PHP错误提示
    
    $host = "localhost"; //服务器地址：如 12.25.124.1     
    $dbname = "mu_piao"; //数据库名：如 ecshop
    $user = "root"; //用户名：如 tony
    $password = ""; //用户密码 ：如abc123
    
    $conn = mysql_connect($host , $user , $password) or die("数据库连接失败");  
    
    mysql_select_db($dbname , $conn); //指定需要连接的数据库名
    
    mysql_query("set names utf8;"); //设置sql写入时的编码格式【一定要设哦，否则及别数据添加成功，在数据库里面的中文都是乱码！】;
    
   /*
    *  编写sql语句，主要分为两种：
    *  1.select 返回的是整张表， 返回的数据类型为资源类型
    *  2.insert, delete, update 返回的影响的行数，返回的数据类型为整数类型(注，它们返回赋给 $mupiao 的结果是 true 和 false)
    */
   
    //$sql = "INSERT INTO mu_leave_message(id,title,texe,time) VALUES('','$title','$text', now())";
    
    $sql = "SELECT * FROM mu_leave_message";
    
    $datas = mysql_query($sql);
    
    // 如果执行的是select操作，那么返回的是一个结果集(记录集)，可以看成一个二维数组
    while($row = mysql_fetch_array($datas)) //把返回的结果集$datas 转换成数组 再赋给$row变量(当$datas变量有值就执行循环体)
    {
       //输出方式1：
       /*
        * $arr[] = $row; //将数据库里面的值赋值给$arr数组
        * print_r($arr); //需要停止后面的执行在查看结果集后加exit;
        */
        echo "
            <table border='1'cellspacing='0' cellpadding='0' style='text-align: center;'>
                <tr height='40'>
                    <td width='100'>{$row['id']}</td>
                    <td width='100'>{$row['title']}</td>
                    <td width='100'>{$row['type']}</td>
                    <td width='200'>{$row['text']}</td>
                    <td width='200'>{$row['time']}</td>
                </tr>
            </table>";
    }

 
    /*
     * echo和print都可以做输出，不同的是，
     * echo不是函数，没有返回值，
     * print是一个函数有返回值，所以相对而言如果只是输出 echo 会更快，而print_r通常用于打印变量的相关信息，通常在调试中使用。
     * print   是打印字符串
     * print_r 则是打印复合类型  如数组 对象
     */
    
    mysql_close($conn);//关闭数据库链接


?>

