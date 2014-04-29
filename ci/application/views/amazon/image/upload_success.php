<html>
	<head>
		<title>Upload Form</title>
	</head>
	<body>
		<h3>Your file was successfully uploaded!</h3>
		<ul>
		<?php
			foreach($upload_data as $item => $value){?>
					<li><?php echo $item;?>: <?php echo $value;?></li>
			<?php } ?>
		</ul>
		<ul>
				<li style="padding-right:25px;list-style:none; float:left"><a href="<?php echo $url;?>">继续编辑</a></li>
				<li style="list-style:none;float:left "><a href="<?php echo $backurl;?>">去看订单</a></li>
		</ul>
	</body>
</html>