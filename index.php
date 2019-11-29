<?php
// echo 向屏幕打印所指定的内容。
    echo "Hello PHP!";
    echo 3 + 2 - (5 * 0) . "<br/>";
    
    echo 1 + 1.00;

// PHP的变量是用$开头的。
    $mupiao = 88.000009 + 2;
    $name = "小穆";

// PHP的连接符是用. 就相当于js中的+连接符。

    if ($mupiao <= 100 && $mupiao >= 90) 
    {
        echo $name . "的成绩为" . $mupiao . "分，属于优秀级别！";
    }
    else if($mupiao < 90 && $mupiao >=80 )
    {
        echo $name . "的成绩为" . $mupiao . "分，属于良好级别！";
    }
    else if($mupiao < 80 && $mupiao >=70 )
    {
        echo $name . "的成绩为" . $mupiao . "分，属于一般级别！";
    }
    else
    {
        echo $name . "的成绩为" . $mupiao . "分，哎兄弟：加把油哦！";
    }
    
// PHP数组的定义。
    $arr = array("小明","小强","小熊熊"); //定义一个空数组 arr;
    var_dump($arr); //var_dump()判断一个变量的类型与长度,并输出变量的数值

    
// PHP数组的循环。
    $arrJson = array("1"=>"苹果" , "2"=>"香蕉" , "3"=>"芒果");
    foreach ($arrJson as $key => $value)
    {
        echo $value."<br/><br/>";
        echo "键：".$key.", 值：".$value.",<br/><br/>";
    }
