<?php
	class Adduser extends CI_Controller{
		public function __construct(){
			parent::__construct();
			
		//	判断用户是否登录  
	 if($_SESSION['is_login']!='1'){
		echo '<script>alert("请先登录！");window.location.href="/amazon/user/account/login";</script>';
		exit();
	}
		}
		
// 增加组员信息;
		public function addzuyuan(){
			
			$pos = $this->input->post();
				
				$name = trim(addslashes($pos['name']));
				
				$password = trim(addslashes($pos['password']));	
				
				if($name && $password){
						
				$pos_user = array('name'=>$name,'password'=>$password);
				
				$this->load->model('amazon/user/add_user','cc');
				
				echo $this->cc->add_zuyuan($pos);
			}
		}		
		
// 增加组长的信息;
		public function addzuzhang(){
			
			$pos = $this->input->post();
				
				$name = trim(addslashes($pos['name']));
				
				$password = trim(addslashes($pos['password']));	
				
				if($name && $password){
						
				$pos_user = array('name'=>$name,'password'=>$password);
				
				$this->load->model('amazon/user/add_user','cc');
				
				echo $this->cc->add_zuzhang($pos_user);
			}
		}	
//	增加采购人员的信息;
		public function addcaigou(){
			
			$pos = $this->input->post();

				$name = trim(addslashes($pos['name']));
				
				$password = trim(addslashes($pos['password']));	
				
				if($name && $password){
				
				$pos_user = array('name'=>$name,'password'=>$password);
				
				$this->load->model('amazon/user/add_user','cc');
				
				echo $this->cc->add_caigou($pos_user);
			}
		}
//	添加物流人员信息;
		public function addwuliu(){
			
			$pos = $this->input->post();

				$name = trim(addslashes($pos['name']));
				
				$password = trim(addslashes($pos['password']));	
				
				if($name && $password){
				
				$pos_user = array('name'=>$name,'password'=>$password);
				
				$this->load->model('amazon/user/add_user','cc');
				
				echo $this->cc->add_wuliu($pos_user);
			}
		}					
				
	}