<?php
	class Denglu extends CI_Model{
		public function __construct(){
			parent::__construct();
		}
//获取个人信息；	
		public function getinfo($name,$password){
//		$db = $this->load->database();//在此处声明变量，一定要是基本的变量，不能用$this->db;
		$db = $this->load->database();
		$this->db->select('
						user.name,
						user.password,
						role.role_name
						');
// 联合查询数据库信息 看是否正确；	3表联合查询.
	
		$sql="select user.u_id,user.name,user.password,group.r_id,role.role_name from user join `group` join `role` on `group`.`u_id`=`user`.`u_id` and `user`.`name`='{$name}' 
					and `user`.`password`='{$password}' and `group`.`r_id`=`role`.`r_id`";
		
		$query = $this->db->query($sql);
		
		$res = $query->result_array();
		
//	返回结果	
		return $res;
		}
	}	