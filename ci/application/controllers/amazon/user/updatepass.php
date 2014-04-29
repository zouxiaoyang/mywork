<?php
	class Updatepass extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			$db = $this->load->database();
		}
		
		public function updatepassword(){
			
			$pass = $this->input->post();
			$password = trim(addslashes($pass['password']));
			if($password){
				$pass1= array('password'=>$password);
				
				$uid=array('u_id ='=>$pass['u_id']);
				
				$this->db->where($uid);
				
				$bol = $this->db->update('user',$pass1);
				
				if($bol){
					echo "更改密码成功！";
				}
		}
	}
		
	}