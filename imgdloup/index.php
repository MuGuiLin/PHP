
<h1>需要抓取的远程图片</h1><hr />
<input type="url" name="" id="" value="" /><br />
<input type="file" name="" id="reply-img" value="" />
<script src="jquery-1.12.4.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
	$(document.body).on("change", "#reply-img", function(){
		alert($(this).val())
		imgsrc = window.URL.createObjectURL($(this).get(0).files[0]);
		alert(imgsrc)
		$.ajax({
    		type: 'POST',
    		url: '/index.php/wxmsg/wxmsg/send',
    		data: {
    			wxid: wxid,
    			type: type,
    			imgsrc: imgsrc
    		},
    		timeout: 30000,
    		cache: false,
    		dataType: 'JSON',
    		success: function(data) {
    			if(data){
    			}
    		}
    	});
	});
</script>

<?php
	header("Content-type: text/html; charset=utf-8");
	error_reporting(7);
	
	
	$url = 'blob:http://localhost/39df6f3c-1f95-48ee-96ce-2664e69b9e92';
	$fileInfo = get_headers($url, true)['Content-Type'];
	$type = end(explode('/', $fileInfo));
	$newName = md5(microtime()).'.'. $type;
	if (file_put_contents($newName, file_get_contents($url))) {
		echo 1;die;
	}
	
	echo '<pre>';
	var_dump($fileInfo);
	die;
	
	require_once 'GrabImage.php';
	$object = new GrabImage();
	$img_url = "http://www.bidianer.com/img/icon_mugs.jpg";
	// 需要抓取的远程图片
	$base_dir = "./uploads/image";
	// 本地保存的路径
	echo $object -> getInstances($img_url, $base_dir);
?>

	