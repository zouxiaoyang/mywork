<h4>按照账户进行筛选</h4>
<?php
	$this->helpers('form');
	echo form_open('/amazon/upload/upload_file/getpost');
	echo '账户选择：<select name="shaixuan_zhanghu">'; 
//	echo '<option name="title">选择账户</option>';
		foreach ($zhanghu as $value){
			echo '<option name="zhanghu">'.$value.'</option>';
		}
	echo '</select>';
	echo '<br>';
	echo '<br>';
	echo '<br>';
	echo '<input type="submit" value="提交" style="margin-left:150px"/>';
	echo '</form>';
?>