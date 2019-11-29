<?php
    
//一、设置时区：
    date_default_timezone_set('Asia/Shanghai');//设置时区 亚洲/上海
    /*
            默认情况下，PHP解释显示的时间为“格林威治标准时间”，与我们本地的时间相差8个小时。
       php5后都要自己设置时区，要么修改php.ini的设置，要么在代码里修改。
    
    1、在PHP.INI中设置时区：
       date.timezone = PRC
    
    2、在代码中设置时区：
       date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai'   亚洲/上海
       date_default_timezone_set('Asia/Chongqing');//其中Asia/Chongqing'为“亚洲/重庆”
       date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”
       ini_set('date.timezone','Etc/GMT-8');
       ini_set('date.timezone','PRC');
       ini_set('date.timezone','Asia/Shanghai');
       ini_set('date.timezone','Asia/Chongqing');
     */
    echo '<h1 style="text-align: center;">PHP日期/时间 函数【time() ，mktime() ，microtime() ，date()】</h1><hr/>';
    
//二、获取当前Unix时间戳：【从Unix纪元（格林威治时间1970年1月1日00时00分00秒）开始 到 当前的秒数】
    $time = time(); //获取当前Unix时间戳的函数 【返回的是整数据类型】
    var_dump($time,'Unix时间戳：【从Unix纪元（格林威治时间1970年1月1日00时00分00秒）开始 到 当前的秒数】');
    
    
//三、获取自定义指定的时间戳：
    $mak = mktime(0,0,0,10,1,2016); //一定根据顺序：(时，分，秒，月，日，年)来设置 是里是2015年国庆的时间戳
    $mun = $mak - $time;
    echo '离2016年国庆还有：'.$mun.'秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    
    $mak = mktime(0,0,0,10,1,2018);
    echo '离2018年国庆还有：'.($mak - $time).'秒<br/><br/>';
    
    $mak = mktime(0,0,0,1,1,2020);
    $d = ($mak - $time)/60 /60 /24; //天
    $h = ($mak - $time)/60/60; //时
    $m = ($mak - $time)/60; //分
    $s = $mak - $time; //秒
    
    echo '离2020年元旦还有：'.(int)$d.'天，'.(int)$h.'时，'.(int)$m.'分，'.(int)$s.'秒';
    
/*【PHP 中的类型强制转换和 C 中的非常像：在要转换的变量之前加上用括号括起来的目标类型。】
        如：
        $a = 3.1615926;
        $b = (int)$a;
    
    php允许的强制转换有：
    (int)，(integer) - 转换成整型
    (bool)，(boolean) - 转换成布尔型
    (float)，(double)，(real) - 转换成浮点型
    (string) - 转换成字符串
    (array) - 转换成数组
    (object) - 转换成对象
*/
    echo '<br/>';

    
//四、获取Unix时间戳和微秒数：
    $mic = microtime();
    echo '<br/>微秒数 , Unix时间戳:'.$mic;
    
    $mic = microtime(true);
    echo '<br/>秒数 , 微秒数:'.$mic;
    
    $seep = 10000000;
    $kaishiTime = microtime(true);//开始时间
    //实例：计算一个for循环花费多少时间：
    for($i = 0; $i < $seep; $i++)
    {
        //这时暂时什么都不做！
    }
    $jieshuTime = microtime(true);//结束时间
    
    $num = round($jieshuTime - $kaishiTime ,4); //结束时间 -减去 开始时间 就得出了所用时间啦！ round(浮点变量 ,4)函数用于，让浮点类型的值四舍五入后 再保留 4位小数;
    
    echo '<br/><br/>这个for循环在：'.$num.'秒执行了'.$seep.'次！';
    
    
//五、格式化Unix时间戳：
    echo '<br/><br/><a target="_blank" href="http://php.net/manual/zh/function.date.php">进入php官方文档查看data()函数的用法</a><br/><br/>';
    
    $date = date('Y-m-d G:i:s');
    echo '当前日期/时间格式1: '.$date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    
    $date = date('Y 年 m 月 d 日 G 时 i 分 s 秒');
    echo '当前日期/时间格式2: '.$date.'<br/>';

    $weekarray = array("日","一","二","三","四","五","六");
    
    $week = $weekarray[date('w')];
    echo '<br/>今天是星期：'.$week;
    
    $apm = date('a');
    if($apm == 'am')
    {
        $apm = '上午';
    }
    else 
    {
        $apm = '下午';
    }
    echo '<br/><br/>现在是：'.$apm.' 时段啦！';
    
    echo '<br/><br/>现在完整时间：' . date('Y年 m月 d日') . ' 星期' . $week . ' ' . $apm . date(' G点 i分 s秒');
    
    
    echo '<style type="text/css">
			 *{font-size: 30px; font-weight: bold; font-family: "微软雅黑";}
		  </style>
        
          <script type="text/javascript">
		     sets();
    		 function sets()
    		 {
    			 window.location.reload();
    			 window.setTimeout(sets() , 1000);
    		 }
	      </script>';//1秒钟刷新1次！
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    