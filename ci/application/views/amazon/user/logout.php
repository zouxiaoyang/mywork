<?php
	$this->helpers('url');
	echo "<h4>退出系统成功！</h4>";
	
?>
<span id="time" style="background: red">3</span>秒钟后自动跳转，如果不跳转，请点击下面的链接
	<?php echo anchor('/','返回系统首页');?>
<script type="text/javascript">
	function delayURL(url) {
		var delay = document.getElementById("time").innerHTML;
		if(delay > 0) {
			delay--;
			document.getElementById("time").innerHTML = delay;
		} else {
			window.top.location.href = url;
		}
		setTimeout("delayURL('" + url + "')", 1000);
	}
	delayURL("/");
</script>