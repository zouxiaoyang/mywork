<html>
<head>
<title>信息编辑页面</title>
</head>
<body>
<?php  $this->helpers('url');$this->helpers('form');?>

<script type="text/javascript" src="<?php echo base_url()?>tools/js/prototype.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>tools/js/plug_date/WdatePicker.js"></script>
<?php if(isset($_GET['page'])){$page = $_GET['page'];}
	else{
			$page=0;
		}
	if(isset($_GET['order_id'])){
		 $order_id =$_GET['order_id'];
	}
?>
<?php 
//组长权限；		
			if($role_id==1){
				if($page){echo anchor('/amazon/choose/showzuzhang/showmessage/'.$page,'返回');
							$backurl ='/amazon/choose/showzuzhang/showmessage/'.$page; }
						else{
							echo  anchor('/amazon/choose/showzuzhang/showmessage/','返回');
							$backurl ='/amazon/choose/showzuzhang/showmessage/';
						}
			}
// 组员权限			
			if($role_id==2){
				if($page){echo  anchor('/amazon/choose/showzuyuan/showmessage/'.$page,'返回');
							$backurl ='/amazon/choose/showzuyuan/showmessage/'.$page;
						}
					else{
						echo  anchor('/amazon/choose/showzuyuan/showmessage/','返回');
						$backurl ='/amazon/choose/showzuyuan/showmessage/';
					}
			}
			
//	管理员权限	
		if(in_array($role_id, array(3,4,5))){
				if($page){echo  anchor('/amazon/upload/upload_file/saixuan/'.$page,'返回');
							$backurl ='/amazon/upload/upload_file/saixuan/'.$page;
						}
						else{
							echo  anchor('/amazon/upload/upload_file/saixuan/','返回');
							$backurl ='/amazon/upload/upload_file/saixuan/';
						}
			}
		?>
			<a style="margin-left:30px;" id="logout" href="javascript:void(0)">退出系统</a>
<?php $arr_title = array(
				'产品分类','价格','采购负责人','采购状态','采购时间',
				'发货日期','商品成本','货运方式','销售历史','物流单号',
				'销售备注','亚马逊链接','实际采购链接','参考采购链接',
				'物流问题备注','采购实物图'
			);?>
			
<h4>信息修改</h4>
			<table><!--
				<tr>
					<?php foreach ($arr_title as $title){
						echo "<td>{$title}</td>";
					}?>
				</tr>  
				-->
					<tr><td><?php echo $arr_title[0]?></td><td><input type="text" name="f_buy_catalog" size="20" id="catalog"/></td></tr>
					<tr><td><?php echo $arr_title[1]?></td><td><input type="text" name="f_o_price" size="20" id="price"/></td></tr>
					<tr><td><?php echo $arr_title[2]?></td><td><input type="text" name="f_buy_buy_name" size="20" id="name"/></td></tr>
					<tr><td><?php echo $arr_title[3]?></td><td><input type="" name="f_buy_status" size="20" id="status"/></td></tr>
					<tr><td><?php echo $arr_title[4]?></td><td>
						<input id="buy_time" name="f_buy_buy_time" class="Wdate" type="text" onclick="WdatePicker()">
					</td></tr>
					<tr><td><?php echo $arr_title[5]?></td><td><input id="s_time" name="f_s_s_time" class="Wdate" type="text" onclick="WdatePicker()"></td></tr>
					<tr><td><?php echo $arr_title[6]?></td><td><input type="text" name="f_p_price" size="20" id="p_price"/></td></tr>
					<tr><td><?php echo $arr_title[7]?></td><td><input type="text" name="f_s_s_way" size="20" id="s_way"/></td></tr>
					<tr><td><?php echo $arr_title[8]?></td><td><input type="text" name="f_p_sale_history" id="salor_history" /></td></tr>
					<tr><td><?php echo $arr_title[9]?></td><td><input type="text" name="f_s_s_number" size="20" id="send_number"/></td></tr>
					<tr><td><?php echo $arr_title[10]?></td><td><textarea name="f_o_message" id="salor_beizhu"></textarea></td></tr>
					<tr><td><?php echo $arr_title[11]?></td><td><textarea name="f_buy_am_links" id="am_links"></textarea></td></tr>
					<tr><td><?php echo $arr_title[12]?></td><td><textarea name="f_buy_sj_links" id="sj_links"></textarea></td></tr>
					<tr><td><?php echo $arr_title[13]?></td><td><textarea name="f_buy_ck_links"  id="ck_links"></textarea></td></tr>
					<tr><td><?php echo $arr_title[14]?></td><td><textarea  name="f_s_s_problem"  id="send_problem"></textarea></td></tr>
					<!--<tr><td>提交数据</td><td><input type="submit" value="提交数据" id="submit"/></td></tr>
					--><tr><td><?php echo $arr_title[15]?></td><td>
					<form enctype="multipart/form-data" action="/amazon/image/pic/upload_pic" id="upimage" method="POST">
						<?php /*echo form_open_multipart('/amazon/image/pic/upload_pic');*/?>
						<input type="file" name="userfile" size="20" id="upfile"/>
						<?php if($page){?>
							<input name="url" type="hidden" value="/amazon/edit/edit_table/?&page=<?php echo $page;?>&order_id=<?php echo $order_id;?>" />
							<input name="orderid" type="hidden" value="<?php echo $order_id;?>" />
						<?php }else{?>
							<input name="url" type="hidden" value="/amazon/edit/edit_table/?&order_id=<?php echo $order_id;?>" />
							<input name="orderid" type="hidden" value="<?php echo $order_id;?>" />
						<?php }?>
						
						<input type="hidden" name="backurl" value="<?php echo $backurl;?>" />
						<br /><br />
					</form>
					<input type="submit" value="提交数据" id="submit"/>
				</td>
			</tr>
		</table>
<!--js-->
<script type="text/javascript">
//	根据权限，限制某些操作；
var quanxian = <?php echo $role_id;?>;
function setedit(arr){
	if(quanxian!=3){
		var len = arr.length;
				for(i=0;i<len;i++){
					arr[i].disable();
					arr[i].style.border="1px red dotted";
				}
	}
}	
if(quanxian==4){
	var arr = $('catalog','price',
			's_way','salor_beizhu','salor_history','am_links',
			'ck_links','send_number','send_problem','s_time'
			);
	}
if(quanxian==5){
	var arr = $('catalog','price','name','status','p_price',
			's_way','salor_beizhu','salor_history','am_links','sj_links',
			'ck_links','buy_time'
		);
	}

if(quanxian==1 || quanxian==2){
	var arr = $('name','status','p_price','sj_links','send_number','send_problem','buy_time','s_time'
				
		);
	}
setedit(arr,quanxian);
// 按钮事件;		
		$('submit').onclick=function(){
//	参数的处理		
		
		var arr = $('catalog','price','name','status','p_price',
				's_way','salor_beizhu','salor_history','am_links','sj_links',
				'ck_links','send_number','send_problem','buy_time','s_time'
			);
			var str='';
			var len = arr.length;

				for(i=0;i<len;i++){
						if(arr[i].value){
								str+=arr[i].name+'='+arr[i].value+'&';
						}
					}
			str+='time=<?php echo $order_id;?>';
			
			var url='/amazon/edit/edit_table/eidt_message';
			var page = <?php echo $page;?>;
			var $role_id =<?php echo $role_id;?>;
//			var url = '/proxy?url=' + encodeURIComponent('http://www.google.com/search?q=Prototype');
			// 注意：使用 proxy 是为了避开 SOP（参见：SOP)
			new Ajax.Request(url, { 
				method: 'post',
				parameters:str,
				onSuccess: function(transport) {
					
					alert("数据处理成功");
					
					$('upimage').submit();
				}
			});
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