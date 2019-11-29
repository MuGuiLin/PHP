<?php
    header('Content-type:text/html;charset=utf8');//设置浏览器输出类型：默认：header('Content-type:text/html;charset=utf8');
    /*
     *  php不仅限于处理文本数据，还可以创建不同格式的动态图像，如：GIF ，PNG JPEG，BMP，XMP等。
     *  在php中可以通过 GD扩展库 来实现对图像的处理，不仅可以创建新图像，而且还可以处理已有的图像。
     * 
     *  
     *  注：通过GD库处理图像的操作都是先在内存中处理，等操作完成以后再以文件流的方式，输出到浏览器或服务器磁盘中。
     *  使用前先开启GD扩展库【当前用的是wampServer服务器 点击服务器图标 ——> PHP ——> PHP扩展 ——> 在 php_gd2前打勾即可！】;
     */


    //1、创建图像：
    $img = imagecreatetruecolor(400, 200);//创建图像，并设定 宽w ，高h;
    
    
    //2、绘制图像：
    $bg_color1 = imagecolorallocate($img, 255, 0, 0);//设定要填充的背景色（红R ，绿G ，蓝B）可设定多个不同的颜色 供下面调用！;
    $bg_color2 = imagecolorallocate($img, 0, 255, 0);
    $bg_color3 = imagecolorallocate($img, 0, 0, 255);
    $bg_color4 = imagecolorallocate($img, 128, 201, 180);
    
    imagefill($img, 0, 0, $bg_color3);//填充背色（目标 ，x位置 ，y位置 ，背景色）;
    
    
    //3、生成图像：
   //imagejpeg($img);//输出到浏览器 注：这里一定要设置 header('Content-type:image/jpeg;charset=utf8');
    if(imagejpeg($img , "mupiao2.jpg"));//生成指定文件名,并保存到当前(默认)文件路径下。注：这里要设置：header('Content-type:text/html;charset=utf8');
    {
        echo "图片已生成，并保存成功！";
    }
    
    imagefill($img, 0, 0, $bg_color2);//填充背色（目标 ，x位置 ，y位置 ，背景色）;
    if(imagejpeg($img , "image/img.jpg"));//生成指定文件名,并保存到自定义路径 image文件夹里面【也可以用服务器的绝对路径如：D:/mupiao/images/img.jpg】。注：这里要设置：header('Content-type:text/html');
    {
        echo "图片已生成，并保存成功！";
    }
    
    //4、释放图像（用完后，就销毁,释放内存）
    imagedestroy($img);