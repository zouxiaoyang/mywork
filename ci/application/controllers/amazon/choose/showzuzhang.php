<?php
	class Showzuzhang extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$db = $this->load->database();
			
	//	判断用户是否登录  
		 if($_SESSION['is_login']!='1'){
			echo '<script>alert("请先登录！");window.location.href="/amazon/user/account/login";</script>';
			exit();
		}
	
		//	判断导出的文件是否存在，  
 		$f_exsit = './tools/resource/download_export/contacts_zuzhang.csv';
 		
		if(file_exists($f_exsit)){
			unlink($f_exsit);
		}
		
		}
		
//	get post
	public function getpost(){
					
		$_SESSION['ARR_TIME']='';
		$pos =$this->input->post();
		$_SESSION['pos'] = $pos;
		$this->showmessage();
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
				
				$this->showmessage();
			
}
//	根据账户的值进行筛选;		
public function getallorder(){

		$this->output->cache(600/60);
		
		$_SESSION['pos'] = '';
		$_SESSION['ARR_TIME']='';
		$this->showmessage();
}

		
public function showmessage(){		
//	按时间 筛选；
		if(isset($_SESSION['ARR_TIME']) && $_SESSION['ARR_TIME']){
			$arr_time_value = $_SESSION['ARR_TIME'];
			$this->getaddress($arr_time_value,2);
		}
//	按账户或者按状态筛选;	
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
	public function getaddress($value,$choose){
		
//************************************************************************\\		
//首先，获得组长自身的账户;
/**
		通过已登录用户的用户名，获取该用户的账户,联合查询！$_SESSION['USER_NAME']
 */		
		 $name = $_SESSION['USER_NAME'];
		 
		 $sql = 'select `zhanghu`.`zhang_hu`,`user`.`u_id` from `zhanghu` join `user` on `user`.`name`='."'{$name}'".'
			join `zhanghu_user` on `user`.`u_id`=`zhanghu_user`.`u_id` and `zhanghu_user`.`z_id` =`zhanghu`.`z_id`';
			
			$query = $this->db->query($sql);
			
			$res = $query->result_array();
			
// 提取的数据放到$arr_zhanghu里面去;
		foreach ($res as $arr){
			$arr_zhanghu[] = $arr['zhang_hu'];
		}	

// 获取该组组员的账户;
	
		 $sql = 'select `zhanghu`.`zhang_hu`,`user`.`u_id` from `zhanghu` join `user` on `user`.`name`='."'{$name}'".'
					join `zuzhang_zuyuan` on `user`.`u_id`=`zuzhang_zuyuan`.`zuzhang_id`
					 join `zhanghu_user` on `zuzhang_zuyuan`.`zuyuan_id` =`zhanghu_user`.`u_id` 
					 and `zhanghu_user`.`z_id`=`zhanghu`.`z_id`';
		
		 $query = $this->db->query($sql);
		 
		 $res = $query->result_array();
		 
		 foreach ($res as $arr){
		 	$arr_zhanghu[] = $arr['zhang_hu'];
		 }	 
//   $arr_zhanghu 里面存放的就是组长加上组员的账户数据;
//************************************************************************\\	
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
				$this->db->where_in('order.zhanghu',$arr_zhanghu);
			if($choose==1){	
				$this->db->join('buy','buy.o_time = order.time');
				$this->db->join('send','send.o_time = order.time and order.zhanghu='."'{$value}'");
				$this->db->join('product','product.o_time = order.time');
			}
			 if($choose==2){
		 			$this->db->join('buy','buy.o_time = order.time');
					$this->db->join('send','send.o_time = order.time and order.time like '."'%{$value}%'");
					$this->db->join('product','product.o_time = order.time');
			}
			
			if($choose==3){
				$this->db->join('buy','buy.o_time = order.time');
				
				if($value=='已出单'){
//					$this->db->join('buy','buy.o_time = order.time and buy.status='."'{$arr_zhanghu}'");
					$this->db->join('product','product.o_time = order.time and product.sale_history='."'{$value}'");
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
				$query = $this->db->get();
				$res = $query->result_array();	
//		添加分页		
			$this->load->library('pagination');
			$total_num = count($res);
			$config['base_url'] = '/amazon/choose/showzuzhang/showmessage/';
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
			// 获取该组的所有数据;
			$this->load->model('amazon/zhanghu/getzuzhang','cc');

			$result = $this->cc->getzuzhang_message($arr_zhanghu,$value,$cur_page,$config['per_page'],$choose);
			
			
//	在模板中输出分页;		
			$data['show_message'] = array($result,$this->pagination->create_links(),$arr_zhanghu);
			
			$this->load->view('amazon/show/showzuzhang',$data);
			
		}
	}
