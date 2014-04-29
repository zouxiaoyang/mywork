<?php $this->helpers('url');?>
<link rel="stylesheet" href="<?php echo base_url()?>tools/css/style.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url()?>tools/js/prototype.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>tools/js/plug_date/WdatePicker.js"></script>
<p><h4 style="text-align:center">订单展示页面</h4></p>
	<ul id="shaixuan">
			<li><?php echo anchor('/amazon/upload/upload_file/getallorder','显示全部订单');?></li>
			<li><?php echo anchor('/tools/resource/download_export/contacts.csv','导出订单表格')?></li>
			<li><a id="logout_left" href="/amazon/user/account/getinfo">个人中心</a></li>
			<li><a id="logout_showmessage" href="javascript:void(0)">退出系统</a></li>
	</ul>
	<label>Search：</label>
	<div style="width:251px">
		<input id="search" type="text" name="search" value='' />
		<button type="submit" id="submit_search">search</button>
		<img id="ajax_loader" style="display:none;float:right;" src="<?php echo base_url()?>tools/images/opc-ajax-loader.gif" />
	</div>
	<br />
<div id="show_data">
	<?php
			echo $show_message[1].'<br>';
			echo $show_message[0];
			echo '<br>'.$show_message[1];
	?>
</div>
<!--/*弹出层的STYLE*/-->

<script type="text/javascript">
//$('manager').onclick=function(){
//	
//	if($('clssli').style.display=='none'){
//		$('manager').update('关闭操作中心');
//	
//			$('clssli').style.display='block';
//		}else if($('clssli').style.display=='block'){
//			$('manager').update('打开操作中心');
//			$('clssli').style.display='none';
//		}
//}
	//	搜索框！
		$('submit_search').onclick=function(){
			
			var attribute = $('search').value
				if(!attribute){
							alert("搜索条件不能为空！");
						}else{
					var url = '/amazon/search/getsearch/getsearch_post/';
	
					new Ajax.Request(url, { 
						method: 'post',
						parameters:'attribute='+attribute,
						onLoading:function(){
								$('ajax_loader').style.display="block";
							},
						onSuccess: function(transport) {
							
	//				为了保持页码的一致性！		
						
						window.location.href="/amazon/search/getsearch/showmessage/"
							
							}
						}
					); 
					
					}
		}
		
function showDiv(obj){
//  点击显示图片;
	$('showimg').src=obj.innerHTML;
	$('popDiv').style.height = $('showimg')+'20px';
	$('popDiv').style.width = $('showimg');
	$('popDiv').style.display='block';
	$('bg').style.display='block';
}
function closeDiv(){
	$('popDiv').style.display='none';
	$('bg').style.display='none';
	}
	// logout 退出系统;
	$('logout_showmessage').onclick=function(){
		
		var bol = confirm("真的要退出系统吗？");
		
		if(bol){
			window.location.href="/amazon/user/account/logout";
		}
	}
	//	按日期筛选！
		$('date_title').onclick=function(){
			var date = $('time').value
				if(!date){
							alert("筛选日期不能为空！");
						}
				else{
					var url = '/amazon/upload/upload_file/gettime/';
	
					new Ajax.Request(url, { 
						method: 'post',
						parameters:'time='+date,
						onSuccess: function(transport) {
							
	//				为了保持页码的一致性！		
	
						window.location.href="/amazon/upload/upload_file/saixuan/"
							
							}
						}
					); 
					
					}
		}

//		账户筛选;

	$('shaixuan_zhanghu').onchange=function(){

				var zhanghu=this.value;

				if(zhanghu!='账户选择'){

					var url = '/amazon/upload/upload_file/getpost/';
					
					new Ajax.Request(url, { 
						method: 'post',
						parameters:'shaixuan_zhanghu='+zhanghu,
						onSuccess: function(transport) {
							
	//				为了保持页码的一致性！		
	
						window.location.href="/amazon/upload/upload_file/saixuan/"

//							$('shaixuan_zhanghu').select='selected';
							
							}
						}
					); 
			}
		}
	
//  按订单状态选择;


	$('shaixuan_status').onchange=function(){

				var status=this.value;
				
				if(status!='订单状态'){

					var url = '/amazon/upload/upload_file/getpost/';
					
					new Ajax.Request(url, { 
						method: 'post',
						parameters:'shaixuan_status='+status,
						onSuccess: function(transport) {
							
	//				为了保持页码的一致性！		
	
						window.location.href="/amazon/upload/upload_file/saixuan/"
							
							}
						}
					); 
			}
		}
	
	</script>
</head>
<body>

<div id="popDiv" class="mydiv" style="display:none;"><img id="showimg" src='' /><br/>
<a href="javascript:closeDiv()">close</a></div>
<div id="bg" class="bg" style="display:none;"></div>

<div style="padding-top: 20px;">
</div>