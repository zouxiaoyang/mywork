<h4>按照订单状态进行筛选</h4>
<?php
	$this->helpers('form');
	echo form_open('/amazon/upload/upload_file/getpost');
	echo '账户选择：<select name="shaixuan_status">'; 
//	echo '<option name="title">选择账户</option>';	
			echo '<option name="status" value="未出单">'.'未出单'.'</option>';
			echo '<option name="status" value="已出单">'.'已出单'.'</option>';
	echo '</select>';
	echo '<br>';
	echo '<br>';
	echo '<br>';
	echo '<input type="submit" value="提交" style="margin-left:150px"/>';
	echo '</form>';
?>