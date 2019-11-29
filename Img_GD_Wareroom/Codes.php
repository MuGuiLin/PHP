<?php

    //header('Content-type:text/html;charset=utf8');
    header('Content-type:image/jpeg');
    
     
    //echo rand(50, 180);//随机整数生成 函数（最小值 ， 最大值）;
    $w = 500;
    $h = 200;
    $codes_arr = array('A','a','B','b','C','c','D','d','E','e','F','f','G','g','H','h','I','i','J','j','K','k','L','l','M','m',1,2,3,4,5,6,7,8,9,0,'N','n','O','o','P','p','Q','q','R','r','S','s','T','t','U','u','V','v','W','w','X','x','Y','y','Z','z');
    //$codes = $codes[rand(0, count($codes) - 1)];用数组的下标来随机的显示对应的值
    
    $text = '';
    for($i = 0; $i < 4; $i++)
    {
        $text.=$codes_arr[rand(0,count($codes_arr)-1)];//随机的显示，拼接4个字符
    }
    //echo $text;
    
    $img = imagecreatetruecolor($w, $h);//创建图像
    $color_a = imagecolorallocate($img, rand(200, 255), rand(200, 255), rand(200, 255)); //设置图像背景色 ( R , G , G 都是随数在200至255之间);
    imagefill($img, 0, 0, $color_a); //填充背景色
    
    //imagesetpixel($img, rand(0, $w-1), rand(0, $h), $color_b); //绘制一个像素点imagesetpixel($img , 起始x,结束y,小点色);
    
    for($i = 0; $i < 300; $i++)
    {
        imagesetpixel($img, rand(0, $w-1), rand(0, $h-1), imagecolorallocate($img, rand(10, 200), rand(10, 200), rand(10, 200)));//随机循环生成1000个像素点imagesetpixel($img , 起始x,结束y,随机色);
    }
    
    //imageline($img, rand(0, $w/2), rand(0, $h), rand($w/2 , $w), rand(0, $h), imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255)));//绘制一条线imageline($img , 起始x,起始y,结束x,结束y,线条色);
    
    for($i = 0; $i < 6; $i++)
    {
        imageline($img, rand(0, $w/2), rand(0, $h), rand($w/2 , $w), rand(0, $h), imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255)));//随机循环生成6条线imageline($img , 起始x,起始y,结束x,结束y,线条色)
    }
    
//     imagestring($img, $font, $x, $y, $string, imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255)));
    
    imagerectangle($img, 0, 0, $w-1, $h-1, imagecolorallocate($img, 0, 0, 0));//绘制一个矩形imagerectangle($img , 起始x,起始y,结束x,结束y,边框色);
    
    imagestring($img, 5, 10, 10, $text, imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255)));//水平地画一行字符串imagestring($img, 文字大小, 起始x, 结束y, '要绘制的字符或变量名', 文字色)
    
    imagettftext($img, 64, rand(-10, 10),  rand(60, 100), rand(100, 150), imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255)), 'font/POSTOFFICE.ttf', $text);//用自定义字体向图像写入文本【推荐用】
    
    imagejpeg($img); //向页输出图像
    
    
    imagedestroy($img);  //4释放图像（用完后，就销毁,释放内存）
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    