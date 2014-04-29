<?php
	class Edit extends CI_Model{
		function __construct(){
			parent::__construct();
			$db=$this->load->database();
		}
//	对数据库的数据进行更新处理;
	public function edit_buy_table($buy,$order_id){
				$arr = array('o_time ='=>$order_id);
				
//		构造数组;

				foreach ($buy as $key=>$value){
					
						$key = str_replace('f_buy_', '', $key);
					 	$new_buy[$key]=$value;
					}
					$this->db->where($arr);
					
					 $bos = $this->db->update('buy',$new_buy);
			}		
			
//	对product

	public function edit_product_table($buy,$order_id){
			
				$arr = array('o_time ='=>$order_id);
				
//		构造数组;

				foreach ($buy as $key=>$value){
					
						$key = str_replace('f_p_', '', $key);
					 	$new_buy[$key]=$value;
					}
					$this->db->where($arr);
					
					 $bos = $this->db->update('product',$new_buy);
			
			}	
			
//	//	对order

	public function edit_order_table($buy,$order_id){
			
				$arr = array('time ='=>$order_id);
				
//		构造数组;

				foreach ($buy as $key=>$value){
					
						$key = str_replace('f_o_', '', $key);
					 	$new_buy[$key]=$value;
					}
					$this->db->where($arr);
					
					 $bos = $this->db->update('order',$new_buy);
					 
			}		

	//	//	对order

	public function edit_send_table($buy,$order_id){
			
				$arr = array('o_time ='=>$order_id);
				
//		构造数组;

				foreach ($buy as $key=>$value){
					
						$key = str_replace('f_s_', '', $key);
					 	$new_buy[$key]=$value;
					}
					$this->db->where($arr);
					
					 $bos = $this->db->update('send',$new_buy);
			
			}
			
			
	}