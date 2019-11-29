<?php
    error_reporting(E_ALL ^ E_DEPRECATED); //开启PHP错误提示
    
    $host = "localhost"; //服务器地址：如 12.25.124.1     
    $dbname = "mu_piao"; //数据库名：如 ecshop
    $user = "root"; //用户名：如 tony
    $password = ""; //用户密码 ：如abc123
    
    $title = $_POST["title"];
    $text = $_POST["text"];

    if($title == "")
    {
        exit("对不起：留言标题不能为空！");
    }
    if($text == "")
    {
        exit("对不起：留言内容不能为空！");
    }
    
    //PHP连接MySQL数据库的3种方法：http://www.111cn.net/database/mysql/58471.htm
   /*
    * mysqli_connect()面向过程 连接方式：注此方试已被PHP弃用了
    * $mysql_con = mysqli_connect('localhost','username','password','database');
    * 
    * new PDO()连接方式：
    * $mysql_pdo = new PDO($database, $user, $password);
    * 
    * new mysqli()面向对象 连接方式
    * $mysql_i = new mysqli('localhost','username','password','database');
    */

    $conn = mysql_connect($host , $user , $password);
  //$conn = mysql_connect("localhost" , "root" , "") or die("数据库连接失败");
    
    if(!$conn)
    {
       // die('MySQL数据连接失败!<br/>'); //阻止程序往下执行！
        exit('MySQL数据连接失败!<br/>'); //阻止程序往下执行！注：die()函数 和 exit()函数作用都一样，用于阻止程序向下执行的！
    }
    else 
    {
        echo "MySQL连接成功！<br/>";
        var_dump($conn);
    }
    
    mysql_select_db($dbname , $conn); //指定需要连接的数据库名

    mysql_query("set names utf8;"); //设置sql写入时的编码格式【一定要设哦，否则及别数据添加成功，在数据库里面的中文都是乱码！】;

   /*
    *  编写sql语句，主要分为两种：
    *  1.select 返回的是整张表， 返回的数据类型为资源类型
    *  2.insert, delete, update 返回的影响的行数，返回的数据类型为整数类型(注，它们返回赋给 $mupiao 的结果是 true 和 false)
    */
   
    $sql = "INSERT INTO mu_leave_message(id,title,text,time) VALUES('','$title','$text', now())";

    $mupiao = mysql_query($sql); //执行sql语句, 将返回的结果(注：除了serect 操作以外的操作返回的所有结果都只有 true 1 和 false 0)赋给$result变量

    if($mupiao)
    {
        echo "数据库操作成功！<br/>";
    }
    else
    {
        echo "数据库操作失败！<br/>";
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

