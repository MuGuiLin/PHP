<?php
    error_reporting(E_ALL ^ E_DEPRECATED); //开启PHP错误提示
    
    $user = $_POST["username"]; //用户名
    $upwd = $_POST["userpwd"];  //密码
    $code = $_POST["codes"];    //验证码
    
    if($user == "" )
    {
        exit("<script>alert('对不起：用户姓名不能为空！');</script>");
    }
    else if($upwd == "")
    {
        exit("<script>alert('对不起：用户密码不能为空！');</script>");
    }
    else 
    {  
        //var_dump($user.$upwd);
        
        $conn = mysql_connect("localhost" , "root" , "");//连接数据库
        
        if($conn)
        {
            echo "<script>alert('数据库连接成功！');</script>";
        }
        else 
        {
            exit("<script>alert('数据库连接失败！');</script>");
        }
        
        mysql_select_db("mu_piao" , $conn);//打开对应的数据库
        
        mysql_query("set names utf8;"); //设置sql写入时的编码格式【一定要设哦，否则及别数据添加成功，在数据库里面的中文都是乱码！】;
        
        $upwd = md5($upwd);//使用md5方式加密
        
        $sql = "SELECT * FROM mu_users WHERE user_name = '$user' AND password = '$upwd'";
        
//         exit( $sql);
        
        $result = mysql_query($sql);//执行aql语句
        
        if($result)
        {
            if($data = mysql_fetch_array($result))//将数据库返回的数据转为数组
            {
                echo  "$data[user_name] 登录成功！";
                var_dump($data);//打印变量的详细信息
            }
            else 
            {
                exit("<script>alert('登录失败：[用户名或密码不正确]！');</script>");
            }
            
//             while ($data = mysql_fetch_array($result)) //将数据库返回的数据转为数组
//             {
//                 echo
//                 "<table border='1'>
//                 <tr>
//                 <td>$data[user_id]</td>
//                 <td>$data[user_name]</td>
//                 <td>$data[password]</td>
//                 </tr>
//                 </table>";
//             }
            
        } 
        mysql_close($conn); //关闭数据连接
    }