<?php
    header("Content-type:image/jpeg; charset=utf8");

    $w = 160;
    $h = 44;
    $codes_arr = array('A','a','B','b','C','c','D','d','E','e','F','f','G','g','H','h','I','i','J','j','K','k','L','l','M','m',1,2,3,4,5,6,7,8,9,0,'N','n','O','o','P','p','Q','q','R','r','S','s','T','t','U','u','V','v','W','w','X','x','Y','y','Z','z');
    
    $text = '';
    for($i = 0; $i < 4; $i++)
    {
        $text.=$codes_arr[rand(0,count($codes_arr)-1)];//随机的显示，拼接4个字符
    }
    
    $img = imagecreatetruecolor($w, $h);//创建图像
    $color_a = imagecolorallocate($img, rand(200, 255), rand(200, 255), rand(200, 255)); //设置图像背景色 ( R , G , G 都是随数在200至255之间);
    imagefill($img, 0, 0, $color_a); //填充背景色

    for($i = 0; $i < 100; $i++)
    {
        imagesetpixel($img, rand(0, $w-1), rand(0, $h-1), imagecolorallocate($img, rand(10, 200), rand(10, 200), rand(10, 200)));//随机循环生成1000个像素点imagesetpixel($img , 起始x,结束y,随机色);
    }
    
    for($i = 0; $i < 6; $i++)
    {
        imageline($img, rand(0, $w/2), rand(0, $h), rand($w/2 , $w), rand(0, $h), imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255)));//随机循环生成6条线imageline($img , 起始x,起始y,结束x,结束y,线条色)
    }
    
    imagerectangle($img, 0, 0, $w-1, $h-1, imagecolorallocate($img, 0, 0, 0));//绘制一个矩形imagerectangle($img , 起始x,起始y,结束x,结束y,边框色);
    
    imagettftext($img, 18, rand(-5, 5),  rand(20, $w/4), rand(20, $h/1.3), imagecolorallocate($img, rand(100, 200), rand(100, 200), rand(100, 200)), 'font/POSTOFFICE.ttf', $text);//用自定义字体向图像写入文本【推荐用】
    
    imagejpeg($img); //向页输出图像
    
    imagedestroy($img);  //4释放图像（用完后，就销毁,释放内存）
    
    
    //将每次生成的验证码存入数据库
    $conn = mysql_connect("localhost" , "root" , "");//设置数据库连接
    if($conn)
    {
        echo "数据库连接成功！";
    }
    else
    {
        echo "数据库连接失败！";
        exit;
    }
    
    mysql_query("set names utf8;"); //设置sql写入时的编码格式【一定要设哦，否则及别数据添加成功，在数据库里面的中文都是乱码！】;
    
    mysql_select_db("mu_piao" , $conn);//选择用于数据库查询的默认数据库
    
    $sql = "UPDATE mu_iscode set code = '$text' "; //将生成的验证码存入数据库
    
    $result = mysql_query($sql); //执行上面的sql语句
    
    if($result)
    {
        echo "验证码保存成功！";
    }
    
    mysql_close($conn); //关闭数据连接
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    