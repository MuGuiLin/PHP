<?php
    header('Access-Control-Allow-Origin:*');//注意！跨域要加这个头
    header("Content-Type:text/html;charset=utf8"); //设置头文件信息：输出类型 和 字符编码
    
    error_reporting(E_ALL ^ E_DEPRECATED); //开启PHP错误提示
    date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”date_default_timezone_set('Asia/Shanghai');//修复时间相差8小时
    

    function userLogin() {
        $user = $_POST["username"]; //用户名
        $upwd = $_POST["userpwd"];  //密码
        $code = $_POST["codes"];    //验证码
        
        if(!$user)
        {
            echo json_encode(['message' => '对不起：用户姓名不能为空！']);
            exit;
        }
        else if("" == $upwd)
        {
            echo json_encode(['message' => '对不起：用户密码不能为空！']);
            exit;
        }
        else if("" == $code)
        {
            echo json_encode(['message' => '对不起：验证码不能为空！']);
            exit;
        }
        else
        {
            $conn = mysql_connect("localhost", "root", "");//连接数据库
            
            if($conn)
            {
                echo 'OK, 数据库连接成功！';
            }
            else
            {
                echo 'AO, 数据库连接失败！';
                exit;
            }
        
            mysql_select_db("mu_piao" , $conn);//打开对应的数据库
        
            mysql_query("set names utf8;"); //设置sql写入时的编码格式【一定要设哦，否则及别数据添加成功，在数据库里面的中文都是乱码！】;
        
            $upwd = md5($upwd);//使用md5方式加密
        
            $sql = "SELECT * FROM mu_users WHERE user_name = '$user' AND password = '$upwd'; SELECT `code` FROM mu_iscode";
            $resultA = mysql_query($sql);//执行sql语句
           
            $resultB = mysql_query("SELECT `code` FROM mu_iscode");//执行sql语句
            
            //exit( $sql);
            //$result = mysql_queryAll($sql);//执行sql语句

            if($resultA)
            {
                if($data = mysql_fetch_array($resultA))//将数据库返回的数据转为数组
                {
                    echo $data[user_name].'OK, 登录成功！';
                    
                    var_dump('1111111111111');//打印变量的详细信息
                }
                else
                {
                    echo '登录失败：[用户名或密码不正确]！';
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
            
            
            if($resultB)
            {
                if($data = mysql_fetch_array($resultB))//将数据库返回的数据转为数组
                {
                    
                    if($code != $data[code]){
                        echo json_encode(['message' => '验证码不对头！']);
                    } else {
                        echo $data[code];
                    }
                }
            }


            mysql_close($conn); //关闭数据连接
        }
    };
    
    userLogin();
