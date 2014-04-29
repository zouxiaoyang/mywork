<html>
<head>
<?php $this->helpers('url');?>
<link rel="stylesheet" href="<?php echo base_url()?>tools/css/style.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url()?>tools/js/prototype.js"></script>
<title>Upload Form</title>
</head>
<body>
<p><a id="logout" href="javascript:void(0)">退出系统</a>
	<?php echo anchor('/amazon/user/account/login','返回主页');?>
</p>
<?php echo $error;?>

<div id="upload_form">
	<h4>有新的订单表格要导入？</h4>
	<br>
	<?php echo form_open_multipart('amazon/upload/upload_file/do_upload');?>
	
	<input type="file" name="userfile" size="20" />
	
	<br /><br />
	
	<input type="submit" value="upload" />
	
	</form>
</div>
<script>
//logout 退出系统;
	$('logout').onclick=function(){
		
		var bol = confirm("真的要退出系统吗？");
		
		if(bol){
			window.location.href="/amazon/user/account/logout";
		}
	}
</script>
</body>
</html>

