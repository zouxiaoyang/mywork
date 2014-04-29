<html>
<head>
<title>登陆页面</title>
</head>
<body>
<?php  $this->helpers('url');?>
<link rel="stylesheet" href="<?php echo base_url()?>tools/css/style.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url()?>tools/js/prototype.js"></script>
<p><a id="logout" href="javascript:void(0)">退出系统</a></p>
<h3>恭喜，登陆成功</h3>
	<div class="log_success">
		<?php
			echo "您在系统中的<label style='color:red'>角色</label>：{$arr[0]['role_name']}！<label style='color:red'>姓名</label>：{$arr[0]['name']}";
		?>
	</div>
	<h4 style="margin-top:150px;"><a herf="javascript:void(0);" id="updatepass">更改密码</a></h4>
	
	<div class="add_pass" style="display:none;">
		<label>新密码</label>：<input type="text" name="updatepass" id="update_pass" value=""/>
		<br>
		<br>
		<input type="submit" value="提交" id="submit_pass"/>
	</div>
	<div class="showmessage" style="margin-top:150px;"><?php echo anchor('/amazon/upload/upload_file/getallorder/','查看订单信息');?></div>
<!-- js	-->
<script type="text/javascript">
//	更改密码！
	$('updatepass').onclick=function(){
		
		if($$('.add_pass')[0].style.display=='none'){
			
				$$('.add_pass')[0].style.display='block';
				
			}else if($$('.add_pass')[0].style.display=='block'){

				$$('.add_pass')[0].style.display='none';
			}
	}

//  处理增加的账户数据;	
	$('submit_pass').onclick=function(){
		
		var url = '/amazon/user/updatepass/updatepassword';
		
		var str='password='+$('update_pass').value+'&'+'u_id='+'<?php echo $arr[0]['u_id']?>';
		if($('update_pass').value){
			new Ajax.Request(url, { 
				method: 'post',
				parameters:str,
				onSuccess: function(transport) {
					var callback = transport.responseText;
								if(callback){
										alert(callback);
									}else{
										alert("更新密码失败！");
							}
						}
					}
				); 
			}else{
					alert('新账户不能为空！');
				}
	}
// logout 退出系统;
	$('logout').onclick=function(){
		
		var bol = confirm("真的要退出系统吗？");
		
		if(bol){
			window.location.href="/amazon/user/account/logout";
		}
	}
</script>
</body>
</html>
