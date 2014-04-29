<?php
class Upload_file extends CI_Controller {
//初始化； 
 public function __construct()
 {
	  parent::__construct();
//	全局调用系统函数库;
	  $this->load->helper(array('form', 'url'));
	  $db = $this->load->database();  
//	判断用户是否登录  
	 if($_SESSION['is_login']!='1'){
		echo '<script>alert("请先登录！");window.location.href="/amazon/user/account/login";</script>';
		exit();
	}
//	判断导出的文件是否存在，  
 		$f_exsit = './tools/resource/download_export/contacts.csv';
		if(file_exists($f_exsit)){
			unlink($f_exsit);
		}					
 }
//调用模板； 
 public function index()
 { 		
	  $this->load->view('amazon/upload/upload_form', array('error' => ' ' ));
 }
//、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、 
//上传文件；	
function do_upload(){
//	var_dump($_FILES);
	  $config['upload_path'] = './tools/resource/uploads_xls/';
	  $config['allowed_types'] = 'xls';
	  $config['overwrite']=TRUE;
//	  $config['max_size'] = '20480000';
//	  echo $config['file_name'];
//	  $config['max_width']  = '1024';
//	  $config['max_height']  = '768';
//var_dump($_FILES);exit();
	$file_name= $_FILES['userfile']['name'];
		 $_SESSION['file_name'] = $file_name;
	  $this->load->library('upload', $config);
	  if (! $this->upload->do_upload())
		  {
			   $error = array('error' => $this->upload->display_errors());
			   
			   $this->load->view('amazon/upload/upload_form', $error);
		  } 
	  else
		  {
			   $data = array('upload_data' => $this->upload->data());
			   
			   $this->load->view('amazon/upload/upload_success', $data);
		  }
		  // 读取表格中的数据；
		  $this->getexcel();
	 }
////////////////////////////////////////////////////////////////////////////////////////////////////////////!	
//获取excel中上传的数据； 
public function getexcel(){ 
	
// 获取上传文件参数；
//	echo $this->file_name;
	 $file_name = $_SESSION['file_name'];
//	echo $file_name;

	date_default_timezone_set('Asia/ShangHai');
	/** PHPExcel_IOFactory */
//获取phpexcel类；	
	require_once './application/libraries/phpexcel/PHPExcel/IOFactory.php';
	// Check prerequisites
//获取上传文件的名称；	
	$file_path ='./tools/resource/uploads_xls/'.$file_name;
	if (!file_exists($file_path)) {
		exit("系统找不到你所上传的文件.\n");
	}
		$PHPExcel = new PHPExcel();
		$reader = new PHPExcel_Reader_Excel2007(); 
		if(!$reader->canRead($file_path)){
		    $reader = new PHPExcel_Reader_Excel5();
		}

//		$reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load($file_path); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		$highestColumm = $sheet->getHighestColumn(); // 取得总列数
		$highestColumm= PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27,'A'变为1
		
//获取表头的名称；
		    for ($column = 0; $column < $highestColumm; $column++) {//列数是以第0列开始
		        $columnName = PHPExcel_Cell::stringFromColumnIndex($column); //获取列的名称；
		        $excel_title[]=$sheet->getCell($columnName.'1')->getValue();
		    }
		        
	/** 循环读取每个单元格的数据 */
		for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
			$xiabiao  = $row-2; //构造数组下标；
		    for ($column = 0; $column < $highestColumm; $column++) {//列数是以第0列开始
		        $columnName = PHPExcel_Cell::stringFromColumnIndex($column); //获取列的名称；
//		        if($row==1){$excel_title[]=$sheet->getCell($columnName.$row)->getValue();}
//		        echo $columnName.$row.":".$sheet->getCellByColumnAndRow($column, $row)->getValue()."<br />";
				$lie = trim($excel_title[$column]);
				$excel_data[$xiabiao][$lie]=addslashes(trim($sheet->getCellByColumnAndRow($column, $row)->getValue()));
		    }
		}
//	对表格中的数据记性处理；		
		$this->inputdata($excel_data,$excel_title);
	}
//****************************************************************************************************************\\
//提取excel表中的参数；	
private function inputdata($arr,$arr_title){
	
		$excel_data =$arr;

		
	foreach ($excel_data as $arr1){

		if($arr1['订单导出日期']){

//	获取订单导出日期
	$last_time	= 	$arr1['订单导出日期'];
// 获取发货地址！			
	$address = $arr1['发货地址'];
//获取订单金额；
	if(is_numeric($arr1['订单金额'])){
		$zijin = '$'.$arr1['订单金额'];
	}else{
		$zijin = $arr1['订单金额'];
	}
// .........................................................................................................................
// 对数据进行入库处理；\\


//	构造订单表格数组；	
		$order =array(
			'order_id'=>$arr1['订单号'],
			'zhanghu'=>str_replace(array(' ','（','）'),array('','(',')'),trim($arr1['订单生成账户'])),
			'jine'=>$zijin,
			'yunfei'=>$arr1['运费'],
			'time'=>$last_time,
			'ANSI'=>$arr1['SKU'],
			'price'=>$arr1['商品成本'],
			'message'=>$arr1['销售备注']
			);

//		构造采购表数组
			$buy = array(
				'o_time'=>$arr1['订单导出日期'],
				'catalog'=>$arr1['产品分类'],
				'product_name'=>$arr1['商品名称'],
				'buy_time'=>$arr1['采购时间'],
				'pic'=>$arr1['采购实物图'],
				'sj_links'=>$arr1['实际采购链接'],
				'ck_links'=>$arr1['参考采购链接'],
				'am_links'=>$arr1['亚马逊链接'],
				'status'=>$arr1['采购状态'],
				'buy_name'=>$arr1['采购负责人']
			);
//		构造物流数组
		$send  = array(
				'o_time'=>$arr1['订单导出日期'],
				's_time'=>$arr1['发货日期'],
				's_number'=>$arr1['物流单号'],
				's_problem'=>$arr1['物流问题备注'],
				's_way'=>$arr1['货运方式'],
				'country_beizhu'=>$arr1['备注国籍'],
				's_address'=>nl2br($address)
			);
		
//.......................................................................................................................\\
//	查看order表中该记录是否存在；			
			$condition = array('time ='=>$arr1['订单导出日期']);
			$query = $this->db->get_where('order',$condition);
			$jilu_shumu = count($query->result());
			
//如果order表中 不存在该条记录，则 将该记录插入到数据表中；
			if($jilu_shumu==0){
//	添加事务处理，保持数据的一致性;			
				$this->db->trans_begin();
//		添加记录到order表中；		
				$order_bos = $this->db->insert('order',$order); 
//		同时更新采购表格		
				$buy_bos = $this->db->insert('buy',$buy);		
// 		同时更新物流表格；
				$send_bos = $this->db->insert('send',$send);
//		同时更新product表；	
				if ($this->db->trans_status() === FALSE){
					    $this->db->trans_rollback();
					}else{
					    $this->db->trans_commit();
					}
			}else{
//		如果该记录存在，则对该记录进行更新	

/*		对order表进行更新,构造order表数组		*/

				$update_order =array(
					'zhanghu'=>str_replace(array(' ','（','）'),array('','(',')'),trim($arr1['订单生成账户'])),
					'jine'=>$zijin,
					'yunfei'=>$arr1['运费'],
					'time'=>$last_time
				);
//		构造采购表数组
			$update_buy = array(
				'catalog'=>$arr1['产品分类'],
				'product_name'=>$arr1['商品名称'],
				'buy_time'=>$arr1['采购时间'],
				'pic'=>$arr1['采购实物图'],
				'sj_links'=>$arr1['实际采购链接'],
				'ck_links'=>$arr1['参考采购链接'],
				'am_links'=>$arr1['亚马逊链接'],
				'status'=>$arr1['采购状态'],
				'buy_name'=>$arr1['采购负责人']
			);
//	 构造物流表数组
			$send_buy  = array(
				's_time'=>$arr1['发货日期'],
				's_number'=>$arr1['物流单号'],
				's_problem'=>$arr1['物流问题备注'],
				's_way'=>$arr1['货运方式'],
				's_address'=>nl2br($address)
			);	
//		条件		
				$order_cos = array('time ='=>$arr1['订单导出日期']);
				$buy_cos = array('o_time ='=>$arr1['订单导出日期']);
				$send_cos = array('o_time ='=>$arr1['订单导出日期']);
//	添加事务;保证数据的并发一致性;
				$this->db->trans_begin();
//		对order,buy,send表进行更新处理;		 
				$this->db->where($order_cos);
				$is_order_update = $this->db->update('order',$update_order);
				
				$this->db->where($buy_cos);
				$is_buy_update = $this->db->update('buy',$update_buy);
				
				$this->db->where($send_cos);
				$is_send_update = $this->db->update('send',$send_buy);
					
			if ($this->db->trans_status() === FALSE){
				    $this->db->trans_rollback();
				}else{
				    $this->db->trans_commit();
				}
			}		
//............................................................................................................................\\			
//	构造产品表数组
//根据ANSI,获取某个产品的销售总价格；

		$product_cos = array('o_time ='=>$arr1['订单导出日期']);
		$order_cos = array('time ='=>$arr1['订单导出日期']);
//根据产品的order_id，获取产品 总的金额；
		$this->db->select_sum('jine');
		$query = $this->db->get_where('order',$order_cos);
		$res = $query->result();
		$p_price = round($res[0]->jine,2);
		
// 根据order_id,获取该产品销售的总的数量；
		
		$this->db->select_sum('qty');
		$query = $this->db->get_where('order',$order_cos);
		$res = $query->result();
		$count = $res[0]->qty;
//..............................................................................\\
		
//对sale_history字段进行对比处理;
		
// condition:
		$this->db->select('product.sale_history,product.product_name,buy.status');
		$this->db->from('product');
		$this->db->join('buy',
				'product.o_time = buy.o_time and product.sku='."'{$arr1['SKU']}'".
				' and (product.sale_history =\'已出单\' or buy.status =\'已采购\')');	
//		$query = $this->db->get_where('product',$arr_sku);
			$query = $this->db->get();
			$res  = $query->result_array();
			$count_sku = count($res);
	
		if($count_sku!=0){
				$product = array(
				'o_time'=>$arr1['订单导出日期'],
				'product_name'=>$arr1['商品名称'],
				'price'=>$arr1['商品成本'],
				'p_price'=>$p_price,
				'message'=>$count,
				'sku'=>$arr1['SKU'],
				/*'ANSI'=>$arr1['ASIN编号'],*/
				'sale_history'=>'已出单'  //对该字段值进行更新，否则，为默认	
			);
		}
//..............................................................................\\		
		else{
			if($arr1['销售历史']){
				$product = array(
						'o_time'=>$arr1['订单导出日期'],
						'product_name'=>$arr1['商品名称'],
						'price'=>$arr1['商品成本'],
						'p_price'=>$p_price,
						'message'=>$count,
						'sku'=>$arr1['SKU'],
						/*'ANSI'=>$arr1['ASIN编号']*/
						'sale_history'=>$arr1['销售历史']
					);
			}else{
					$product = array(
						'o_time'=>$arr1['订单导出日期'],
						'product_name'=>$arr1['商品名称'],
						'price'=>$arr1['商品成本'],
						'p_price'=>$p_price,
						'message'=>$count,
						'sku'=>$arr1['SKU']
					);
			}
		}
		
//	根据ANSI,将数据进行入库到product表处理；	
				$query = $this->db->get_where('product',$product_cos);
				$res_product = $query->result();
				$count_product = count($res_product);
				if($count_product==0){
						$this->db->insert('product',$product);
					}else{
						$this->db->where($product_cos);
						$this->db->update('product',$product);
					}
			}	
		}
	$this->tongji();
}
public function tongji(){		
//...........................................................................................................................\\

//对total 表进行操作 ；
//1.从order表获取所有的账户信息；
			$this->db->distinct('zhanghu                                                                                                                                   ');
			$query = $this->db->get('order');
			$res = $query->result();
			foreach ($res as $row){
				$arr_zhanghu[]=str_replace(array(' ','（','）'),array('','(',')'),trim($row->zhanghu));
			}
			$arr_zhanghu = array_unique($arr_zhanghu);
//	判断total表中 ，是否有某个账户，
			foreach($arr_zhanghu as $zhanghu){
			if($zhanghu){
				$value=trim($zhanghu);
				$value=str_replace(' ', '', $zhanghu);
				$total_cos = array('zhanghu ='=>$zhanghu);
				$t_chengben = 0;
				
//		从order表中，获取该账户的销售出去的总金额；		
				$this->db->select('jine,time');
				$this->db->where('zhanghu ='."'{$zhanghu}'");
				$query = $this->db->get('order');
				$res = $query->result_array();
				$t_jie=0;
				foreach ($res as $value){
//			对时间进行处理;
				$total_time[]=substr($value['time'],0,5);
				$total_time=array_unique($total_time);
//		对总的金额进行处理;		
					$data_jine = str_replace(' ', '', $value['jine']);
					
					if(strstr($data_jine, '$')){
						
						$data_jine = str_replace('$', '', $data_jine);
						
						$t_jie += $data_jine*6.2240;
					}
					
					if(strstr($data_jine, 'EUR')){
						
						$data_jine = str_replace('EUR', '', $data_jine);
						
						$t_jie  += $data_jine*8.5966;
					}
					
					if(strstr($data_jine, '£')){
						
						$data_jine = str_replace('£', '', $data_jine);
						
						$t_jie  += $data_jine*10.4013;
					}
//			每个账户的总金额	;$t_jie	
					 $t_jie = round($t_jie,2);
				}
//			获取采购的成本;
			
		foreach ($total_time as $t_time){
			
//	获取某一时间段内，该账户的订单数量;
			$sql = 'select count(`product`.`o_time`) as qty from `product` join `order` on `order`.`time`=`product`.`o_time`
				and `product`.`o_time` like '."'%{$t_time}%'".'and `order`.`zhanghu`='."'{$zhanghu}'";

			$query = $this->db->query($sql);
			$res = $query->result_array();
			$qty = $res[0]['qty'];
//	获取某一时间段内，采购的总的成本;			
			$this->db->select_sum('product.price');
			$this->db->from('product');
			$this->db->like('product.o_time',$t_time);
			$this->db->join('order','order.time =product.o_time and zhanghu ='."'{$zhanghu}'");		
			$query = $this->db->get();
			$res = $query->result_array();
			$t_chengben = $res[0]['price'];
//		构造total数组;
					$total = array(
							'zhanghu'=>$zhanghu,
							't_jie'=>$t_jie,
							't_chengben'=>$t_chengben,
							'time'=>$t_time,
							'qty'=>$qty
							); 
						$total_cos = array('time ='=>$t_time,'zhanghu ='=>$zhanghu);
						$query = $this->db->get_where('total',$total_cos);
						$res = $query->result_array();
						if(count($res)==0){
							$this->db->insert('total',$total);
						}else{
							$this->db->where($total_cos);
							$this->db->update('total',$total);
						}	
					}  	
				}
			} 
	}
//	get post，获取提交过来的值；
	public function getpost(){
		$_SESSION['ARR_TIME']='';
		$pos =$this->input->post();
		$_SESSION['pos'] = $pos;
		$this->saixuan();
	}
//	get time;
public function gettime(){
//	按时间筛选;

			$time = $this->input->post('time');
			
				$_SESSION['pos'] = '';
				$years = date("Y");
				$years_xiugai = str_replace('20','',$years);
				$time = str_replace($years,$years_xiugai,$time);
				$time_arr = explode('-', $time);
				
				$time = $time_arr[0].'-'.$time_arr[1].$time_arr[2];

				$_SESSION['ARR_TIME'] = $time;
				
				$this->saixuan();
			
}
//	根据账户的值进行筛选;		
public function getallorder(){
	
		$this->output->cache(600/60);
		
		$_SESSION['pos'] = '';
		$_SESSION['ARR_TIME']='';
		$this->saixuan();
}
public function saixuan(){	
//********************************************************************************************\\
 //	权限判断;该页面只有管理员才具有查看的权限！

			$name = $_SESSION['USER_NAME'];
			
			$sql = 'select `group`.`r_id`,`user`.`u_id` from `user` join `group` 
						on `user`.`name`='."'{$name}'".' and `user`.`u_id`=`group`.`u_id`';
			$query = $this->db->query($sql);
			$res = $query->result_array($query);
			
			$role_id = $res[0]['r_id'];
		
		if(!in_array($role_id , array(3,4,5))){
			
			echo '<script>alert("对不起，只有管理员才有查看权限")</script>';
			
			echo '<script>window.location.href="/amazon/user/account/logout"</script>';
			exit();
		}	
//********************************************************************************************\\	
// 按时间筛选	
if(isset($_SESSION['ARR_TIME']) && $_SESSION['ARR_TIME']){
	$arr_time_value = $_SESSION['ARR_TIME'];
	$this->getaddress($arr_time_value,2);
}
	if(isset($_SESSION['pos']) && $_SESSION['pos']){
							$pos =	$_SESSION['pos'];
							if(isset($pos['shaixuan_zhanghu']) && $pos['shaixuan_zhanghu']){$arr_zhanghu_value=$pos['shaixuan_zhanghu'];}
							
							if(isset($pos['shaixuan_status']) && $pos['shaixuan_status']){$arr_status_value=$pos['shaixuan_status'];}
				
				//			$arr_zhanghu_value='王曼莉组欧洲黄金(法国)';
							if(isset($arr_zhanghu_value) && $arr_zhanghu_value){
								$this->getaddress($arr_zhanghu_value,1);
							}
							 if(isset($arr_status_value) && $arr_status_value){
								$this->getaddress($arr_status_value,3);
							}
				}
	if(!$_SESSION['ARR_TIME']&& ! $_SESSION['pos']){$this->getaddress('',4);}
					
	}
// 获取导出的数据;
	public function getaddress($arr_zhanghu,$choose){
		$this->load->model('amazon/user/getdata','cc');
//			分页
//			1.获取总的页数；

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
											buy.buy_name,
										');
			$this->db->from('order');
//	and order.zhanghu='."'{$zhanghu}'"
// 根据不同的条件 筛选出不同条件下，订单的总数量；	
		if($choose==1){	
				$this->db->join('buy','buy.o_time = order.time');
				$this->db->join('send','send.o_time = order.time and order.zhanghu='."'{$arr_zhanghu}'");
				$this->db->join('product','product.o_time = order.time');
			}
		 if($choose==2){
		 			$this->db->join('buy','buy.o_time = order.time');
					$this->db->join('send','send.o_time = order.time and order.time like '."'%{$arr_zhanghu}%'");
					$this->db->join('product','product.o_time = order.time');
			}
		if($choose==3){
				$this->db->join('buy','buy.o_time = order.time');
				
				if($arr_zhanghu=='已出单'){
//					$this->db->join('buy','buy.o_time = order.time and buy.status='."'{$arr_zhanghu}'");
					$this->db->join('product','product.o_time = order.time and product.sale_history='."'{$arr_zhanghu}'");
				}else{
//					$this->db->join('buy','buy.o_time = order.time and buy.status is null');
					$this->db->join('product','product.o_time = order.time and product.sale_history is null');
				}
				$this->db->join('send','send.o_time = order.time');
				
			}
		if($choose==4){
				$this->db->join('send','send.o_time = order.time');
				$this->db->join('buy','buy.o_time = order.time');
				$this->db->join('product','product.o_time = order.time');
			}
			$this->db->order_by('order.time',"asc"); 
			$query = $this->db->get();
			$res  = $query->result_array();
//	计算查询到的总的数据的条数;		
			$total_num = count($res);
//调用分页;
			$this->load->library('pagination');
			$config['base_url'] = '/amazon/upload/upload_file/saixuan/';
			$config['prev_link'] = '上一页';
			$config['next_link'] = '下一页';
			$config['first_link'] = '第一页';
			$config['last_link'] = '最后一页';
//			$config['uri_segment'] = 5;
			$config['total_rows'] = $total_num;
			$config['per_page'] = 60; 
			if($this->uri->segment(5)){
					 $cur_page = intval($this->uri->segment(5));
					 $config['cur_page']=$cur_page;
			}else{
					$cur_page = 0;
					$config['cur_page']=$cur_page;
				}
					
			$this->pagination->initialize($config);
//	输出分页;		 
//			echo $this->pagination->create_links();
//	调用moddel;
			$value=trim($arr_zhanghu);
			$value=str_replace(array(' ','（','）'),array('','(',')'),$value);
			$callback_arr =  $this->cc->getexcel($value, $cur_page,$config['per_page'],$choose);

	//		获取系统中已经存在的账户;

			$this->db->select('zhang_hu');
			$query = $this->db->get('zhanghu');
			$res = $query->result_array();
			
			foreach ($res as $arr_zhanghu){
				
				foreach ($arr_zhanghu as $value){
					if($value){
						$zhanghu[]=$value;
					}
				}
			}
			
			  $data['show_message'] = array($callback_arr,$this->pagination->create_links(),$zhanghu);
			  $this->load->view('amazon/show/showmessage',$data);
			
	}
// 清空数据表
	public function cleardata(){
		
//********************************************************************************************\\
 //	权限判断;该页面只有管理员才具有查看的权限！

			$name = $_SESSION['USER_NAME'];
			
			$sql = 'select `group`.`r_id`,`user`.`u_id` from `user` join `group` 
						on `user`.`name`='."'{$name}'".' and `user`.`u_id`=`group`.`u_id`';
			$query = $this->db->query($sql);
			$res = $query->result_array($query);
			
			$role_id = $res[0]['r_id'];
			
	if($role_id = $res[0]['r_id']!=3){
			
			echo '<script>alert("对不起，只有管理员才有此操作权限")</script>';
			
			echo '<script>window.location.href="/amazon/user/account/logout"</script>';
			exit();
		}
			
//********************************************************************************************\\	
					$this->db->query('truncate table `order`');
					$this->db->query('truncate table `buy`');
					$this->db->query('truncate table `send`');	
					$this->db->query('truncate table `product`');	
					$this->db->query('truncate table `total`');	
	}
}

?>