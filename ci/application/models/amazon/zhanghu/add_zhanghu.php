<?php
	class Add_zhanghu extends CI_Model{
		public function __construct(){
			parent::__construct();
			$db = $this->load->database();
		}
		
// 增加新的账户
	public function add_new_zhanghu($pos){
		
			$arr_zhanghu =$pos;
			
			$query = $this->db->query("select zhang_hu from zhanghu where `zhang_hu`='{$arr_zhanghu['zhang_hu']}'");

			$res = $query->result_array();
			
			if (!empty($res)){
				
				return "该账户已经存在，请重新填写";
				
			}else{
				
				$arr_info=array('zhang_hu'=>$arr_zhanghu['zhang_hu']);
				
				$this->db->insert('zhanghu',$arr_info);
				
				$z_id = $this->db->insert_id();
				
				if($z_id){
					
				$zhanghu_user = array('z_id'=>$z_id,'u_id'=>$arr_zhanghu['u_id']);
				
				$this->db->insert('zhanghu_user',$zhanghu_user);
				
				$g_id = $this->db->insert_id();
				
				}
//	返回处理结果;			
				if($g_id){
					return "添加信息成功";
				}
			}
			
		}		
	}