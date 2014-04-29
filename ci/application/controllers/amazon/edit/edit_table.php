<?php
	class Edit_table extends CI_Controller{
		function __construct(){
			parent::__construct();
//	判断用户是否登录  
	 if($_SESSION['is_login']!='1'){
		echo '<script>alert("请先登录！");window.location.href="/amazon/user/account/login";</script>';
		exit();
	}
			$db = $this->load->database();
		}
		public function index(){
			
// 获取当前用户的权限		
			$name = $_SESSION['USER_NAME'];
			
			$sql = 'select `group`.`r_id`,`user`.`u_id` from `user` join `group` 
						on `user`.`name`='."'{$name}'".' and `user`.`u_id`=`group`.`u_id`';
			$query = $this->db->query($sql);
			$res = $query->result_array($query);
			
			$role_id = $res[0]['r_id'];
			$data['role_id']=$role_id;
			$this->load->view('amazon/edit/edit_table',$data);
		}
// 对相关字段进行编辑;
	public function eidt_message(){
			
		$this->load->model('amazon/edit/edit','cc');
	
			$pos = $this->input->post();
			$pos = array_filter($pos);
			$order_id = $pos['time'];
// 对buy表进行操作；
		foreach ($pos as $key=>$value) {
			if(strpos($key,'buy_')){
				$buy[$key] = $value;
			}
		}
		if(!empty($buy)){
				$this->cc->edit_buy_table($buy,$order_id);
			}
//		 对product 表进行处理;
	
			foreach ($pos as $key=>$value) {
			if(strpos($key,'_p_')){
				
				 	$product[$key] = $value;

			}
		}
		if(!empty($product)){
				$this->cc->edit_product_table($product,$order_id);
			}
			
			
	//		 对order 表进行处理;
	
			foreach ($pos as $key=>$value) {
				if(strpos($key,'_o_')){
					 	$order[$key] = $value;
				}
			}
			
			if(!empty($order)){
					$this->cc->edit_order_table($order,$order_id);
				}
				
				
		//		 对send 表进行处理;
	
			foreach ($pos as $key=>$value) {
				if(strpos($key,'_s_')){
					 	$send[$key] = $value;
				}
			}
			if(!empty($send)){
					$this->cc->edit_send_table($send,$order_id);
				}
		}
		
// 对采购时间和发货时间进行更新;		
	public function updatetime($m,$d,$time,$order_id,$table){
		//	更新采购的时间,对buy表进行操作;
				$arr_time = array('order_id ='=>$order_id);
				$buy_time =$time;
				if($table=='buy'){
					$time=array('buy_time'=>$buy_time);
				}
				if($table == 'send'){
					$time=array('s_time'=>$buy_time);
				}
				$this->db->where($arr_time);
				$this->db->update($table,$time);
			
		}
	}