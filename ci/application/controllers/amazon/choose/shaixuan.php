<?php
 class Shaixuan extends CI_Controller{
 	public function __construct(){
 		parent::__construct();
//	判断用户是否登录  
	 if($_SESSION['is_login']!='1'){
		echo '<script>alert("请先登录！");window.location.href="/amazon/user/account/login";</script>';
	 }
 	}
 	
 	public function shaixuan_date(){
 		
// 构建日历显示表

 		if($this->uri->segment(5) && $this->uri->segment(6)){
				$years = $this->uri->segment(5);
				$month = $this->uri->segment(6);
		 	}else{
		 		$years=date("Y");
		 		$month = date("m");
		 	}
				
				for($i=1;$i<=31;$i++){
					if($i<10){
						$data[$i]='/amazon/upload/upload_file/gettime/'.$years.'/'.$month.'/0'.$i.'/';
					}else{
							$data[$i]='/amazon/upload/upload_file/gettime/'.$years.'/'.$month.'/'.$i.'/';
					}
				}
			$prefs = array (
               'show_next_prev'  => true,
               'next_prev_url'   => '/amazon/choose/shaixuan/shaixuan_date'
            	 );
			$this->load->library('calendar', $prefs);
			
			$data['choose_time']=$this->calendar->generate($this->uri->segment(5), $this->uri->segment(6),$data);
			
			$this->load->view('amazon/choose/shaixuan_date',$data);		
 	}
 	
// 按照给定的账户筛选订单； 	
  	public function shaixuan_zhanghu(){	
  		
			$db = $this->load->database();
			$this->db->select('zhanghu');
			$query = $this->db->get('total');
			$res = $query->result_array();
			
			foreach ($res as $arr_zhanghu){
				
				foreach ($arr_zhanghu as $value){
					if($value){
						$zhanghu[]=$value;
					}
				}
			}
			$data['zhanghu']=$zhanghu;
			$this->load->view('amazon/choose/shaixuan_zhanghu',$data);
 	}
 	
//	按照给定的订单状态筛选; 

   	public function shaixuan_status(){	

			$this->load->view('amazon/choose/shaixuan_status');
 	}
 	
 }