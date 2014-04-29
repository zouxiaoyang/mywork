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
<p>
		<?php
			echo "您在系统中的<label style='color:red'>角色</label>：{$arr[0]['role_name']}！<label style='color:red'>姓名</label>：{$arr[0]['name']}";
		?>
	</p>
<table id="zuzhang_info_table">
<tr><td><h4 ><a herf="javascript:void(0);" id="adduser">添加新组员</a></h4></td><td  class="add_user" style="display:none;">	
		<label>姓名</label><input type="text" name="user_name" id="user_name" />
		<br>
		<br>
		<br>
		<label>密码</label><input type="password" name="password" id="password"/>
		<br>
		<br>
		<input type="submit" value="提交" id="submit"/>
	</td></tr>
<tr><td><h4 ><a herf="javascript:void(0);" id="addzhanghu">添加新账户</a></h4></td><td  class="add_zhanghu" style="display:none;">
		<label>名称</label>：<input type="text" name="new_zhanghu" id="new_zhanghu" />
		<br>
		<br>
		<input type="submit" value="提交" id="submit_zhanghu"/>
	</div></td></tr>
<tr><td><h4 ><a herf="javascript:void(0);" id="updatepass">更改密码</a></h4></td><td class="add_pass" style="display:none;">
		<label>新密码</label>：<input type="text" name="updatepass" id="update_pass" value=""/>
		<br>
		<br>
		<input type="submit" value="提交" id="submit_pass"/>
	</td></tr>
<tr><td><div class="showmessage" ><?php echo anchor('/amazon/choose/showzuzhang/getallorder','显示本组的订单信息');?></div></td></tr>
	
<tr><td><div class="uploadxls" ><?php echo anchor('/amazon/upload/upload_file/','上传新的订单表格');?></div></td></tr>
</table>		
<!-- js	-->
<script type="text/javascript">
//  对div框进行操作！
	$('adduser').onclick=function(){
		
			if($$('.add_user')[0].style.display=='none'){
				
					$$('.add_user')[0].style.display='block';
					
				}else if($$('.add_user')[0].style.display=='block'){

					$$('.add_user')[0].style.display='none';
				}
		}
//  处理增加的组员数据;	
	$('submit').onclick=function(){

		var url = '/amazon/user/adduser/addzuyuan';
		
		var str='name='+$('user_name').value+'&'+'password='+$('password').value+'&'+'zuzhang_id='+'<?php echo $arr[0]['u_id']?>';
			
		new Ajax.Request(url, { 
			method: 'post',
			parameters:str,
			onSuccess: function(transport) {
				var callback = transport.responseText;
							if(callback){
									alert(callback);
								}else{
									alert("用户名或密码不能为空！");
						}
					}
				}
			); 
		
		}
//  添加本组新的账户;

//  对div框进行操作！
	$('addzhanghu').onclick=function(){
		
			if($$('.add_zhanghu')[0].style.display=='none'){
				
					$$('.add_zhanghu')[0].style.display='block';
					
				}else if($$('.add_zhanghu')[0].style.display=='block'){

					$$('.add_zhanghu')[0].style.display='none';
				}
		}	
	$('submit_zhanghu').onclick=function(){

		var url = '/amazon/user/updatepass/updatepassword';
		
		var str='password='+$('new_zhanghu').value+'&'+'u_id='+'<?php echo $arr[0]['u_id']?>';
			
		new Ajax.Request(url, { 
			method: 'post',
			parameters:str,
			onSuccess: function(transport) {
				var callback = transport.responseText;
							if(callback){
									alert(callback);
								}else{
									alert("新账户不能为空！");
						}
					}
				}
			); 
		
		}
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
