<?php

    header("Content-Type:text/html;charset=utf8");

    $user = $_POST["username"];
    $upwd = $_POST["userpwd"];
    
    if($user == "" )
    {
        exit("对不起：用户姓名不能为空！");
    }
    else if($upwd == "")
    {
        exit("对不起：用户密码不能为空！");
    }
    else 
    {  
        //var_dump($user.$upwd);
        
        $conn = @mysqli_connect('localhost', 'root', '', 'mu_piao', 3306);//设置连接数据库
        
        if(mysqli_connect_error())
        {
            var_dump(mysqli_connect_error());
            exit("数据库连接失败！");
        }
        else 
        {
            echo "数据库连接成功！";
        }
        
        mysqli_set_charset($conn, 'utf8');//设置sql写入时的编码格式
        
        $upwd = md5($upwd);//使用md5方式加密
        
       // $sql = "SELECT * FROM mu_users WHERE user_name = '$user' AND password = '$upwd'"; //查询表指定的数据
        $sql = "SELECT * FROM mu_users";//查询表所有数据
        
//      exit( $sql);
        
        $result = mysqli_query($conn , $sql);//执行aql语句,并将返回来的结果集对象赋给$result变量。
        
        if($result)
        {
           
            //用索引数组获取方式1
            //var_dump(mysqli_fetch_row($result));//用索引数组方式获取一条记录 【注：该函数不返回的字段名】
              
            //用索引数组获取方式2
//             while ($data = mysqli_fetch_row($result))//用索引数组方式循环获取记录
//             {
//                 var_dump($data);
//             }
            
            
            //用关联数组获取方式1
            //var_dump(mysqli_fetch_assoc($result));//以关联数组的方式获取一条记录【注：该函数会返回的字段名】
           
            //用关联数组获取方式2
//             while ($data = mysqli_fetch_assoc($result))//用关联数组方式循环获取记录
//             {
//                 var_dump($data);
//             }

            
            //以索引数组 或 关联数组 获取方式1：mysqli_fetch_array($result) 第2个可选参数： MYSQLI_BOTH(默认)，MYSQLI_ASSOC，MYSQLI_NUM 
//             if($data = mysqli_fetch_array($result))//将数据库返回的数据(是一个结果集对象)转为数组 【注：该函数可以返回，也可以不返回字段名 根据传的参数而定如：mysqli_fetch_array($result,MYSQLI_NUM)不返回，mysqli_fetch_array($result,MYSQL_ASSOC)返回】
//             {
//                 echo  "$data[user_name] 登录成功！";
//                 var_dump($data);//打印变量的详细信息
//             }
//             else
//             {
//                 exit("登录失败：[用户名或密码不正确]！");
//             }
            
            //以索引数组 或 关联数组 获取方式2：
//             while ($data = mysqli_fetch_array($result)) //将数据库返回的数据转为数组，并循里面的数据！【注：该函数可以返回，也可以不返回字段名 根据传的参数而定如：mysqli_fetch_array($result,MYSQLI_NUM)不返回，mysqli_fetch_array($result,MYSQL_ASSOC)返回】
//             {
//                 var_dump($data);
//                 echo
//                 "<table border='1'>
//                     <tr>
//                         <td>$data[user_id]</td>
//                         <td>$data[user_name]</td>
//                         <td>$data[password]</td>
//                         <td>$data[email]</td>
//                         <td>$data[home_phone]</td>
//                         <td>$data[nowliving_address]</td>
//                         <td>$data[registration_date]</td>
//                     </tr>
//                 </table>";
//             }


            //以索引数组 或 关联数组 获取全部记录的数据【第2个可选参数： MYSQLI_BOTH，MYSQLI_ASSOC，MYSQLI_NUM(默认) 】
            //var_dump(mysqli_fetch_all($result,MYSQLI_BOTH));//这个不用循环，很常用！
            
            
            //获取结果集中的字段信息
//             $data = mysqli_fetch_field($result);
//             var_dump($data); //获取一条记录中的所有字段信息
//             echo  $data -> name." , "; //获取一条记录中的某一个字段信息
//             echo  $data -> table; //获取一条记录中的某一个字段信息
            
//             while ($data = mysqli_fetch_field($result)) //循环获取结果集中的字段信息
//             {
//                 var_dump($data);
//             }


            //获取一个代表结果集字段的对象数组
//             $data = mysqli_fetch_fields($result);
//             var_dump( $data);
           
            //获取一个代表结果集字段的对象数组中的某一个字段信息
//             $data = mysqli_fetch_fields($result);
//             echo $data[0] -> name;
            
            //获取结果集中行的数量【就是返回一个表中有多少条记录】
            $data = mysqli_num_rows($result);
            var_dump($data);
            
            mysqli_free_result($result); //释放结果集，释放内存！
        } 
        mysqli_close($conn); //关闭数据连接
    }