<?php
    header("Content-Type:text/html;charset=utf8"); //设置头文件信息：输出类型 和 字符编码
    
    //默认情况下，PHP解释显示的时间为“格林威治标准时间”，与我们本地的时间相差8个小时。
    /*
     * php5后都要自己设置时区，要么修改php.ini的设置，要么在代码里修改。              
     * 在PHP.INI中设置时区              
     * date.timezone = PRC              
     * 在代码中设置时区      
     * 1 date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai'   亚洲/上海     
     * 2 date_default_timezone_set('Asia/Chongqing');//其中Asia/Chongqing'为“亚洲/重庆” */    
         date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”  
    /* 4 ini_set('date.timezone','Etc/GMT-8');      
     * 5 ini_set('date.timezone','PRC');     
     * 6 ini_set('date.timezone','Asia/Shanghai');
     * 7 ini_set('date.timezone','Asia/Chongqing');
     *
     */
    
    $title = $_POST['title'];  //$_POST['name'] 接收html页面中的form表单传过来的name属性元素的值
    $content = $_POST['content'];  
    
    $weekarray = array("日","一","二","三","四","五","六");
    $date = date("Y-m-d")." 星期".$weekarray[date("w")].date(" A h:i:s"); //日期 . 星期 . [A上下午]时间
    
    if($title == "" || $content == "")
    {
        echo "对不起：添加失败，因为你没有输入任何内容！";
        echo '<li><a href="index.html">反加添加</a></li>';
        return false;
    }
    else 
    {
        echo $title."<br/>";
        echo $content."<br/>";
        
        var_dump($title , $content); //判断一个变量的类型与长度,并输出变量的数值,如果变量有值输的是变量的值并回返数据类型.
        //doc xls ppt
        file_put_contents("data.txt" , $title.",".$content.",".$date."\n" , FILE_APPEND); //[将一个字符串写入文件]创建一个data.txt的文件，把$title和$content拼接在一起，中间用逗号隔开，写入 并FILE_APPEND（不覆盖）：追加到data.txt文本文件中
        
        echo '数据添加成啦!<br/><br/>';
        echo '<div><a href="data.txt">打开data文件</a></div>';
        echo '<p><a href="show.php">进入查看</a></p>';
        echo '<li><a href="index.html">反加添加</a></li>';
    }
   