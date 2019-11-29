<?php
	error_reporting(0);
	echo '<pre>';
	print_r($_FILES);
    
	$file = $_FILES['myFile'];
	$tmp_name = $file['tmp_name'];
	$name = $file['name'];
	$error = $file['error'];
	$filePath = './upload/';

	//判断文件上传路径是否存在，是否在写入权限
	if (!is_dir($filePath)) {
	    mkdir($filePath, 0777 , true);
	}
	
	//截取上传文件的扩展名
	$name = end(explode('.',$name));
	
	//重新 命名 文件
	$newName = time().'.'.$name;

	//$error === 0 表示 没有错误发生，文件上传成功。  不一定真的有文件上传了，有可能你查看发现size是0。
	
	// A 移动
    if($error === UPLOAD_ERR_OK){
 		move_uploaded_file($tmp_name, $filePath.$newName);
		echo 'OK，上传成功 A 移动！';
		exit;
    }
    else{
       	errorTextFn($error);
    }
	
	// B 复制
	if ($error > 0) {		
		errorTextFn($error);
	}
	else{
		copy($tmp_name, $filePath.$newName);
		echo 'OK，上传成功 B 复制！';
		exit;
	}
    
    // C 写入
	if ($error === 0) {   
		file_put_contents($filePath.$newName, $tmp_name);
		echo 'OK，上传成功 C 写入！';
		exit;
	}
	else{
		errorTextFn($error);
	}

	function errorTextFn($ero){
		echo $ero;
		switch ($ero){ 		
	       	case 1:
	           	echo '上传的文件超过了 PHP.ini 中 upload_max_filesize 选项限制的值。';
	           	break;
			case 2:
	           	echo '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。  ';
	           	break;
			case 3:
	           	echo '文件只有部分被上传 或 上传不完整（可能因为请求时间过长被终止）';
	           	break;
			case 4:
	           	echo '没有文件随着这个请求上传。 是指表单的file域没有内容，是空字符串。';
	           	break;
			case 6:
	           	echo '在php.ini中没有指定临时文件夹。';
	           	break;
			default:
				echo '文件上传失败！';
	   	}
		exit;
	}
