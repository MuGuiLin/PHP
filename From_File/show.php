<?php
    $text = file_get_contents("data.txt"); //file_get_contents("文件名")打开获取文件

    echo str_replace("\n" , "<br/><br/>" , $text); //str_replace("替换目标" , "替换内容" , 在哪里替换)内空替换

    echo "<p><a href='index.html'>返回添回</p>";