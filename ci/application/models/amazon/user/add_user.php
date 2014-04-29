<?php
	class Add_user extends CI_Model{
		public function __construct(){
			parent::__construct();
			$db = $this->load->database();
		}
		
// 增加新的组员
	public function add_zuyuan($pos){
		
			$arr_user =array('name'=>$pos['name'],'password'=>$pos['password']);
			
			
			$query = $this->db->query("select name from user where `name`='{$arr_user['name']}'");
			
// 看看该用户是否存在；
			$res = $query->result_array();
			
			if (!empty($res)){
				
				return "用户名已经存在，请重新填写";
				
			}else{
				
				$this->db->insert('user',$arr_user);
				
				$u_id = $this->db->insert_id();
				
				if($u_id){
					
// 用户与其对应的角色对照表；	
				
				$group = array('r_id'=>2,'u_id'=>$u_id);
				
				$this->db->insert('group',$group);
				
				$g_id = $this->db->insert_id();
				
//	 组长与组员对照表;			
				$zuzhang_zuyuan =array('zuzhang_id'=>$pos['zuzhang_id'],'zuyuan_id'=>$u_id);
				
				$z_z_id = $this->db->insert('zuzhang_zuyuan',$zuzhang_zuyuan);
				
				}
//	返回处理结果;			
				if($g_id && $z_z_id){
					return "添加信息成功";
				}
			}
			
		}	

// 增加新的组长
	public function add_zuzhang($pos){
		
			$arr_user =$pos;
			
			$query = $this->db->query("select name from user where `name`='{$arr_user['name']}'");

			$res = $query->result_array();
			
			if (!empty($res)){
				
				return "用户名已经存在，请重新填写";
				
			}else{
				
				$this->db->insert('user',$arr_user);
				
				$u_id = $this->db->insert_id();
				
				if($u_id){
					
				$group = array('r_id'=>1,'u_id'=>$u_id);
				
				$this->db->insert('group',$group);
				
				$g_id = $this->db->insert_id();
				
				}
//	返回处理结果;			
				if($g_id){
					return "添加信息成功";
				}
			}
			
		}	
// 增加新的采购人员的信息
	public function add_caigou($pos){
			$arr_user =$pos;
			
			$query = $this->db->query("select name from user where `name`='{$arr_user['name']}'");

			$res = $query->result_array();
			
			if (!empty($res)){
				
				return "用户名已经存在，请重新填写";
				
			}else{
				
				$this->db->insert('user',$arr_user);
				
				$u_id = $this->db->insert_id();
				
				if($u_id){
					
				$group = array('r_id'=>4,'u_id'=>$u_id);
				
				$this->db->insert('group',$group);
				
				$g_id = $this->db->insert_id();
				
				}
//	返回处理结果;			
				if($g_id){
					return "添加信息成功";
				}
			}
			
		}	
// 增加新的物流人员的信息
	public function add_wuliu($pos){
			$arr_user =$pos;
			
			$query = $this->db->query("select name from user where `name`='{$arr_user['name']}'");

			$res = $query->result_array();
			
			if (!empty($res)){
				
				return "用户名已经存在，请重新填写";
				
			}else{
				
				$this->db->insert('user',$arr_user);
				
				$u_id = $this->db->insert_id();
				
				if($u_id){
					
				$group = array('r_id'=>5,'u_id'=>$u_id);
				
				$this->db->insert('group',$group);
				
				$g_id = $this->db->insert_id();
				
				}
//	返回处理结果;			
				if($g_id){
					return "添加信息成功";
				}
			}
			
		}
	}