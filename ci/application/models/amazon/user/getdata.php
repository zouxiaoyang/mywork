<?php
	class Getdata extends CI_Model{
//	初始化		
		public function __construct(){
			parent::__construct();
			$db = $this->load->database();
		}
		
// 获取数据，并以表格形式在文档中显示;
		public function getexcel($valuecc,$cur_page,$per_page,$choose){
//			$tables = array('send','buy','product')
						$this->db->select('
											order.time,
											order.zhanghu,
											buy.catalog,
											order.order_id,
											product.product_name,
											order.ANSI,
											order.jine,
											send.s_time,
											send.s_number,
											send.s_way,
											order.message,
											send.s_address,
											product.sale_history,
											send.country_beizhu,
											buy.am_links,
											buy.ck_links,
											buy.sj_links,
											product.price,
											order.yunfei,
											send.s_problem,
											buy.buy_time,
											buy.pic,
											buy.status,
											buy.buy_name
										');
			$this->db->from('order');
//	and order.zhanghu='."'{$zhanghu}'"
			if($choose==1){	
				$this->db->join('buy','buy.o_time = order.time');
				$this->db->join('send','send.o_time  = order.time and order.zhanghu='."'{$valuecc}'");
				$this->db->join('product','product.o_time = order.time');
			}
			if($choose==2){
		 			$this->db->join('buy','buy.o_time = order.time');
					$this->db->join('send','send.o_time  = order.time and order.time like '."'%{$valuecc}%'");
					$this->db->join('product','product.o_time = order.time');
			}
			if($choose==3){
				$this->db->join('buy','buy.o_time = order.time');
				
				if($valuecc=='已出单'){

					$this->db->join('product','product.o_time = order.time and product.sale_history='."'{$valuecc}'");
				}else{

					$this->db->join('product','product.o_time = order.time and product.sale_history is null');
				}
				$this->db->join('send','send.o_time  = order.time');
				
			}
//	统计出全部订单；		
		if($choose==4){
				$this->db->join('send','send.o_time  = order.time');
				$this->db->join('buy','buy.o_time = order.time');
				$this->db->join('product','product.o_time = order.time');
			}
//			
//			$this->db->order_by('order.time',"asc"); 

			$query = $this->db->get();
			$res  = $query->result_array();
$arr_title=array(
					"订单导出日期",
					"订单生成账户",
					"产品分类",
					"订单号",
					"商品名称",
					"SKU",
					"订单金额",
					"发货日期",
					"物流单号",
					"货运方式",
					"销售备注",
					"发货地址",
					"销售历史",
					"备注国籍",
					"亚马逊链接",
					"参考采购链接",
					"实际链接",
					"商品成本",
					"运费",
					"物流问题备注",
					"采购时间",
					"采购实物图",
					"采购状态",
					"采购负责人",
					"编辑"
				);
	//输出表头； 
			$file = fopen("./tools/resource/download_export/contacts.csv","a");
						    $serial_str = mb_convert_encoding(serialize($arr_title),'gbk','utf-8');
						    $serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
						    $serial_str= str_replace("\r", "", $serial_str);     
						  	fputcsv($file,unserialize($serial_str));
						  	
//	输出内容；替换存入数据库时里面的<br>标签;
		foreach ($res as $v){
			foreach($v as $key=>$value){
				$value_cc[$key]=str_replace('<br />', "", $value);
			}
//	将值传入表格中;		
				$serial_str = mb_convert_encoding(serialize($value_cc),'gbk','utf-8');
				$serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
				$serial_str= str_replace("\r", "", $serial_str);  
				fputcsv($file,unserialize($serial_str));		   
		}	
		fclose($file);
		
//在页面上以表格形式显示信息;	
		if($res){
				return $this->showpage($arr_title,$valuecc,$cur_page,$per_page,$choose);
		} else{
						echo '<script>alert("没有符合条件的数据,请重新选择筛选条件!");
								window.location.href="/amazon/upload/upload_file/getallorder";
							</script>';
				}
			}
//	...............................................................................................................\\
		
	public function showpage($arr_title,$valuecc,$cur_page,$per_page,$choose){
// 从数据库获取数据;		
						$this->db->select('
											order.time,
											order.zhanghu,
											buy.catalog,
											order.order_id,
											product.product_name,
											order.ANSI,
											order.jine,
											send.s_time,
											send.s_number,
											send.s_way,
											order.message,
											send.s_address,
											product.sale_history,
											send.country_beizhu,
											buy.am_links,
											buy.ck_links,
											buy.sj_links,
											product.price,
											order.yunfei,
											send.s_problem,
											buy.buy_time,
											buy.pic,
											buy.status,
											buy.buy_name
										');
			$this->db->from('order');
//	and order.zhanghu='."'{$zhanghu}'"	

//根据choose 的状态 ，确定筛选的条件;
		if($choose==1){	
				$this->db->join('buy','buy.o_time = order.time');
				$this->db->join('send','send.o_time  = order.time and order.zhanghu='."'{$valuecc}'");
				$this->db->join('product','product.o_time = order.time');
			}
		 if($choose==2){
		 			
		 			$this->db->join('buy','buy.o_time = order.time');
					$this->db->join('send','send.o_time  = order.time and order.time like '."'%{$valuecc}%'");
					$this->db->join('product','product.o_time = order.time');
			}
			if($choose==3){
				$this->db->join('buy','buy.o_time = order.time');
				
				if($valuecc=='已出单'){
					$this->db->join('product','product.o_time = order.time and product.sale_history='."'{$valuecc}'");
				}else{

					$this->db->join('product','product.o_time = order.time and product.sale_history is null');
				}
				$this->db->join('send','send.o_time  = order.time');
			}
//	统计出全部订单；		
		if($choose==4){
				$this->db->join('send','send.o_time  = order.time');
				$this->db->join('buy','buy.o_time = order.time');
				$this->db->join('product','product.o_time = order.time');
			}
//			$this->db->order_by('order.time',"asc"); 

			$this->db->limit($per_page,$cur_page);
			$query = $this->db->get();
			$res  = $query->result_array();
//		echo count($res);	
//	................................................................................................................................\\		
	//将数据在页面上显示出来；
		$str_table='';
		$showtable ='';
		$str_table.='<table style="width:98%;margin:0 auto;"><tr>';
			foreach ($arr_title as $value){
				if($value == '发货地址'){
					$str_table.='<th style="width:27%;">'.$value.'</th>';
				}else if($value == '商品名称'){
					$str_table.='<th style="width:6%;">'.stripslashes($value).'</th>';
				} else if($value == '订单生成账户'){
					$str_table.='<th style="width:1%;">'.$value.'</th>';
				}else{
					$str_table.='<th style="width:3%">'.$value.'</th>';
				}
			}	
		$str_table.'</tr>';
		
//	输出筛选条件

/*获取系统中的账户*/
$this->db->select('zhanghu');
			$query = $this->db->get('total');
			$res_zhanghu = $query->result_array();
			
			foreach ($res_zhanghu as $arr_zhanghu){
				
				foreach ($arr_zhanghu as $value){
					if($value){
						$zhanghu_cc[]=$value;
					}
				}
}
/*获取账户完毕*/
		$str_table.= '<tr>';
			foreach ($arr_title as $value){
				if($value=='订单导出日期'){
					$str_table.='<td>
							<input id="time" name="time" class="Wdate" type="text" onclick="WdatePicker()">
							<br><br>
							<label id="date_title"><button style="cursor:pointer;">提交</button></label>
						</td>';
				}else if($value=='销售历史'){
					$str_table.='<td>
						<select name="shaixuan_status" id="shaixuan_status">
							<option name="订单状态" value="状态">状态</option>
							<option name="已出单" value="已出单">已出单</option>
							<option name="未出单" value="未出单">未出单</option>
						</select>
					</td>';
				}else if($value=='订单生成账户'){	
						$str_table.='<td>';
						$str_table.='<select name="shaixuan_zhanghu" id="shaixuan_zhanghu">';
						$str_table.='<option name="title" value="选择账户">选择账户</option>';
						foreach ($zhanghu_cc as $cc){
							
							$str_table.='<option name="zhanghu">'.$cc.'</option>';
										
						}
						$str_table.='</select>';
						$str_table.='</td>';
				}else{
					 $str_table.='<td></td>';
				}
			}	
		$str_table.'</tr>';
		
		foreach ($res as $arr){
			$showtable.='<tr>';
				foreach ($arr as $key=>$value){
					if($key=='time'){
							$_SESSION['TIME'] = $value;
							$showtable.='<td id="order_'.$value.'">'.$value.'</td>';
						}else if($key=='s_address'){
							$showtable.='<td>'.$value.'</td>';
						}else if($key=='ck_links' || $key=='sj_links' || $key=='am_links'){
								$showtable.='<td><a  target="_blank" href="'.$value.'">'.$value.'</a></td>';
						}else if($key=='pic' && $value){
							$arr_pic = explode('||', $value);
//							$arr_pic = array_filter($arr_pic);
							$cnt = count($arr_pic);
							$showtable.='<td>';
							for ($i=0;$i<$cnt;$i++){
								$j=$i+1;
								if($arr_pic[$i]){
									$showtable.='<p onclick="showDiv(this);" class="buy_image_sys">'.'/tools/images/'.$arr_pic[$i].'</p>';
								}
								if($j!=$cnt && $arr_pic[$i]){
									$showtable.='<hr>';
								}
							}
							$showtable.='</td>';
						}else{
							$showtable.='<td>'.stripslashes($value).'</td>';
						}
					
				}
			$segs = $this->uri->segment(5);
			if($segs){
				$showtable.='<td style="width:3%"><a href="/amazon/edit/edit_table/?&page='.$segs.'&order_id='.$_SESSION['TIME'].'">编辑</a></td>';
			}else{
				$showtable.='<td style="width:3%"><a href="/amazon/edit/edit_table/?&order_id='.$_SESSION['TIME'].'">编辑</a></td>';
			}
			$showtable.='</tr>';
		}
		$showtable.='</table>';
		$show_table = $str_table.$showtable;
		return $show_table;
	}
}		