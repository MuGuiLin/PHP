
<?php
	
	$page = intval($_POST['page']);  //每次请求都不一样的如：第一次是1，第二次是2，第三次。。。。。。。。
	$num = intval($_POST['num']);    //这个一般不建议从前传过来，因为如果给传个1000000，那数据库就不被挂了，所以一般都是后端自已定义的。

	//如果不查询数据库的话，最简单的就像下面这样做下判断，当然也可循环判断。
	if($page == 1){
		exit(json_encode('11111111111111111111111'))
	}elseif($page == 2){
		exit(json_encode('22222222222222222222222'))
	}elseif($page == 3){
		exit(json_encode('33333333333333333333333'))
	}elseif($page == 4){
		exit(json_encode('.......................'))
	}

	//如果要查询数据库的话，就把$page 和 $num 当做查询条件写到SQL语句里面去查询，这样可以根据每次前端传过来的参数 返回对应的数据了。
	
	select * from tableName where status = 1 limit ($num *($page-1)), $num  
	
	//大概的思路就这样，后端我也太懂，说错了别见笑哈，同时欢迎指证！！！
?>
