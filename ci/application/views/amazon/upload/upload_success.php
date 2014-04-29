<html>
<head>
<title>Upload Form</title>
</head>
<body>
<?php $this->helpers('url');?>
<link rel="stylesheet" href="<?php echo base_url()?>tools/css/style.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url()?>tools/js/prototype.js"></script>
<h3>Your file was successfully uploaded!</h3>

<ul>
<?php foreach($upload_data as $item => $value):?>
	<?php if(!strpos($item,'mage')){?>
		<li><?php echo $item;?>: <?php echo $value;?></li>
	<?php }?>
<?php endforeach; ?>
</ul>

<ul id="next_info">
	<li><?php echo anchor('amazon/upload/upload_file', '返回继续上传!'); ?></li>
	<li><?php echo anchor('/amazon/user/account/login/', '返回我的主页!');?></li>
</ul>

</body>
</html>