<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>文件上传</title>
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0" />
		<style type="text/css">
			.speed{ width: 0px; height: 20px; display: inline-block; background: deepskyblue; text-align: center; line-height: 20px; font-size: 14px;}
		</style>
	</head>
	<body>
		<form action="" method="post" enctype="multipart/form-data">
			<input type="file" id="oFile" name="myFile" />
			<input type="button" onclick="UploadFileFn()" value="上传文件" />
			<label id="speed" class="speed"></label>
		</form>
	</body>
	
	<script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">
		
//		注意：
//		1、上传文件的时候，在html里面的form表单一定要标注：enctype='multipart/form-data'
//		2、有种说法，要求一定要在form表单里面，在file前面加上隐藏域如：<input type=hidden name='MAX_FILE_SIZE' value='value'>
//		3、上传框的 name值 和后端接收的$_FILES['name值'] 一定要相同;


		function OnProgRess(event) {
			var event = event || window.event;
			//console.log(event);  //事件对象
			console.log("已经上传：" + event.loaded); //已经上传大小情况(已上传大小，上传完毕后就 等于 附件总大小)
			//console.log(event.total);  //附件总大小(固定不变)
			var loaded = Math.floor(100 * (event.loaded / event.total)); //已经上传的百分比  
			$("#speed").html(loaded +'%').css('width', (loaded * 4) +'px');
		};

		//开始上传文件
		function UploadFileFn() {

			$('.speed_box').show();
			var oFile = $("#oFile").get(0).files[0], //input file标签
				formData = new FormData(); //创建FormData对象
				xhr = $.ajaxSettings.xhr(); //创建并返回XMLHttpRequest对象的回调函数(jQuery中$.ajax中的方法)
				formData.append("myFile", oFile); //将上传name属性名(注意：一定要和 file元素中的name名相同)，和file元素追加到FormData对象中去

			$.ajax({
				type: "POST",
				url: 'uploadAction.php', // 后端服务器上传地址
				data: formData, // formData数据
				cache: false,   // 是否缓存
				async: true,    // 是否异步执行
				processData: false, // 是否处理发送的数据  (必须false才会避开jQuery对 formdata 的默认处理)
				contentType: false, // 是否设置Content-Type请求头
				xhr: function() {
					if(OnProgRess && xhr.upload) {
						xhr.upload.addEventListener("progress", OnProgRess, false);
						return xhr;
					}
				},
				success: function(returndata) {
					$("#speed").html("上传成功");
					//alert(returndata);  
				},
				error: function(returndata) {
					$("#speed").html("上传失败");
					console.log(returndata)
					alert('请正确配置后台服务！');
				}
			});
		};
	</script>
</html>