<?php
	class Deleteperson extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			$db = $this->load->database();
		}
//	删除个人信息;
	public function deleteinfo(){
		
		$name = $this->input->post('name');
		
		$name = trim(addslashes($name));
				
			$sql = 'select `zhanghu`.`zhang_hu`,`user`.`u_id` from `zhanghu` join `user` on `user`.`name`='."'{$name}'".'
			join `zhanghu_user` on `user`.`u_id`=`zhanghu_user`.`u_id` and `zhanghu_user`.`z_id` =`zhanghu`.`z_id`';
			
			$query = $this->db->query($sql);
			
			$res = $query->result_array();
	if(!empty($res)){
// 提取的数据放到$arr_zhanghu里面去;
		foreach ($res as $arr){
			$arr_zhanghu[] = $arr['zhang_hu'];
		}		
		$uid = $res[0]['u_id'];
//			进行删除操作;
					if($uid){
						$delearr = array('u_id ='=>$uid);
						
						$tables = array('user','group','zhanghu_user');
						
						$this->db->where($delearr);
						
						$a =$this->db->delete($tables);
						
						$delearrzuyuan = array('zuyuan_id ='=>$uid);
						
						$b = $this->db->delete('zuzhang_zuyuan',$delearrzuyuan);
						
						$delearrzuzhang = array('zuzhang_id ='=>$uid);
						
						$c = $this->db->delete('zuzhang_zuyuan',$delearrzuzhang);

						if($a && $b && $c){
							echo "信息成功删除";
						}else{
							echo "该员工的基本信息已经删除，但是，该员工在系统中的信息可能不完整";
						}
					}
	}
			}
			
}		
