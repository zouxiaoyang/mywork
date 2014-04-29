<?php
	class Addzhanghu extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			
		//	判断用户是否登录  
	 if($_SESSION['is_login']!='1'){
		echo '<script>alert("请先登录！");window.location.href="/amazon/user/account/login";</script>';
		exit();
	}
	
		}
		
//添加账户	
		public function add_zhanghu(){
			
			$pos = $this->input->post();;

			$zhang_hu = trim(addslashes($pos['zhang_hu']));
			
			$u_id= trim(addslashes($pos['u_id']));
			
			if($zhang_hu && $u_id){
				
				$pos = array('zhang_hu'=>$zhang_hu,'u_id'=>$u_id);
				
				$this->load->model('amazon/zhanghu/add_zhanghu','cc');
				
				echo $this->cc->add_new_zhanghu($pos);
			}
			
		}	
	}