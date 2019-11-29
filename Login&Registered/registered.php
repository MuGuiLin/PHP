<?php
    header("Content-Type:text/html;charset=utf8"); //设置头文件信息：输出类型 和 字符编码
    error_reporting(E_ALL ^ E_DEPRECATED); //开启PHP错误提示
    
    //默认情况下，PHP解释显示的时间为“格林威治标准时间”，与我们本地的时间相差8个小时。
    /*
     * php5后都要自己设置时区，要么修改php.ini的设置，要么在代码里修改。
     * 在PHP.INI中设置时区
     * date.timezone = PRC
     * 在代码中设置时区
     * 1 date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai'   亚洲/上海
     * 2 date_default_timezone_set('Asia/Chongqing');//其中Asia/Chongqing'为“亚洲/重庆” */
    date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”date_default_timezone_set('Asia/Shanghai');//修复时间相差8小时
    /* 4 ini_set('date.timezone','Etc/GMT-8');
     * 5 ini_set('date.timezone','PRC');
     * 6 ini_set('date.timezone','Asia/Shanghai');
     * 7 ini_set('date.timezone','Asia/Chongqing');
     *
     */

    $user = $_POST["username"]; //用户名称
    $upwd = $_POST["userpwd"]; //用户密码
    $mobile = $_POST["usermobile"]; //联系电话
    $email = $_POST["useremail"]; //电子邮箱
    $address = $_POST["useraddress"]; //常住地址
    $sex = $_POST["sex"]; //性别
    
    
    $hobby = $_POST["hobby"]; //爱好[多选的 数组]
    //print_r($hobby); //输出数组
    /*
     * echo和print都可以做输出，不同的是，
     * echo不是函数，没有返回值，
     * print是一个函数有返回值，所以相对而言如果只是输出 echo 会更快，而print_r通常用于打印变量的相关信息，通常在调试中使用。
     * print   是打印字符串
     * print_r 则是打印复合类型  如数组 对象
     */
    $hobby = implode(',', $hobby); //把数组元素组合为字符串格式,并且在每个数组元素之间用逗号隔开！
    
    
    $datetime = date("Y-m-d H:i:s");//获取当前日期和时间
//  $datetime = date(Y."年".m."月".d."日".G."时".i."分");

    
    if($user == "" )
    {
        exit("对不起：用户姓名不能为空！");
    }
    else if($upwd == "")
    {
        exit("对不起：用户密码不能为空！");
    }
    else if($mobile == "")
    {
        exit("对不起：用户手机不能为空！");
    }
    else
    {
        $conn = mysql_connect("localhost" , "root" , "");//设置数据库连接
        if($conn)
        {
            echo "数据库连接成功！";
        }
        else 
        {
            exit("数据库连接失败！");
        }
        
        mysql_query("set names utf8;"); //设置sql写入时的编码格式【一定要设哦，否则及别数据添加成功，在数据库里面的中文都是乱码！】;
        
        mysql_select_db("mu_piao" , $conn);//选择用于数据库查询的默认数据库
        
        $upwd = md5($upwd);//密码md5方式加密
        
//      exit("INSERT INTO mu_users(user_name , password , sex , home_phone , hobby , email , nowliving_address , registration_date) VALUES('$user' , '$upwd' , '$sex' , '$mobile' , '$hobby' , '$email' , '$address' , '$datetime')");//查看当前插入的数据
        
//      $sql = "INSERT INTO mu_users(user_name , password , sex , home_phone , hobby , email , nowliving_address , registration_date) VALUES('$user' , '$upwd' , '$sex' , '$mobile' , '$hobby' , '$email' , '$address' , '$datetime')";
        $sql = "INSERT INTO mu_users(user_name , password , sex , home_phone , hobby , email , nowliving_address , registration_date) VALUES('$user' , '$upwd' , '$sex' , '$mobile' , '$hobby' , '$email' , '$address' , now())"; //now()当前日期和时间
        
        
        $result = mysql_query($sql); //执行上面的sql语句
        
        if($result)
        {
            echo "用户注册成功！";
        }
        
        mysql_close($conn); //关闭数据连接
    }