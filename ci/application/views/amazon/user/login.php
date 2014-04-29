<html>
<head>
<title>登陆页面</title>
<style type="text/css">
.mydiv{
background-color:#E6EAE9;
border: none;
/*
text-align: center;
line-height: 40px;
font-size: 12px;
font-weight: bold;*/
z-index:99;
/*
width: 300px;
height: 120px;
*/
left:50%;/*FF IE7*/
top: 50%;/*FF IE7*/

margin-left:-150px!important;/*FF IE7 该值为本身宽的一半 */
margin-top:-60px!important;/*FF IE7 该值为本身高的一半*/

margin-top:0px;

position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/
}
</style>
</head>
<body>
<script type="text/javascript" src="<?php echo base_url()?>tools/js/prototype.js"></script>

<?php 
	if(isset($info) && !$info){
		echo '<script>alert("检查登陆信息是否正确");</script>';
	}
?>
<div class="mydiv">
<h4 style="text-align:center;">填写登陆信息</h4>
	<?php echo "<font color='red'>".validation_errors()."</font>"; ?>
	<?php echo form_open('amazon/user/account/getpost'); ?>
	<table>
		<tr>
			<td>Username：</td>
			<td><input type="text" name="username" value="" size="50" /></td>
		</tr>
		
		<tr>
			<td>Password：</td>
			<td><input type="password" name="password" value="" size="50" /></td>
		</tr>
		<tr><td></td><td  style="vertical-align:middle; text-align:center;"><input type="submit" value="Submit" /></td></tr>
	</table>
	</form>
</div>
	<script type="text/javascript">
		$$('p')[0].style.textAlign='center';
		$$('p')[0].style.fontSize='10px';
		$$('p')[1].style.fontSize='10px';
		$$('p')[1].style.textAlign='center';
	</script>
</body>
</html>
