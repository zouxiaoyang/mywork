<?php
	class Getsearch extends CI_Controller{
//	构造函数;		
		function __construct(){
			parent::__construct();
			$db = $this->load->database();
			
		}
//	获取搜索提交过来的值;
	public function getsearch_post(){
		
		$_SESSION['ARR_SEARCH']='';
		$pos =$this->input->post();
		$_SESSION['posearch'] = $pos;
		
		$this->showmessage();
	}	

	public function showmessage(){		
//	按账户或者按状态筛选;	
		if(isset($_SESSION['posearch']) && $_SESSION['posearch']){
							$pos =	$_SESSION['posearch'];
							if(isset($pos['attribute']) && $pos['attribute']){$attribute=addslashes(trim($pos['attribute']));}
							if(isset($attribute) && $attribute){
								$this->getaddress($attribute,5);
							}
				}else{$this->getaddress('',4);}
		
		}
		
public function getaddress($attribute,$choose){
		
//************************************************************************\\		
//	权限判断;该页面只有管理员才具有查看的权限！

			$name = $_SESSION['USER_NAME'];
			
			$sql = 'select `group`.`r_id`,`user`.`u_id` from `user` join `group` 
						on `user`.`name`='."'{$name}'".' and `user`.`u_id`=`group`.`u_id`';
			$query = $this->db->query($sql);
			$res = $query->result_array($query);
			
			$role_id = $res[0]['r_id'];
		
		if(!in_array($role_id , array(1,2,3,4,5))){
			
			echo '<script>alert("对不起，只有会员员才有查看权限")</script>';
			
			echo '<script>window.location.href="/amazon/user/account/logout"</script>';
			exit();
		}
		
/**
		通过已登录用户的用户名，获取该用户的账户,联合查询！$_SESSION['USER_NAME']
 */		
		if(in_array($role_id , array(1,2))){
			
			 $name = $_SESSION['USER_NAME'];
			 $sql = 'select `zhanghu`.`zhang_hu`,`user`.`u_id` from `zhanghu` join `user` on `user`.`name`='."'{$name}'".'
				join `zhanghu_user` on `user`.`u_id`=`zhanghu_user`.`u_id` and `zhanghu_user`.`z_id` =`zhanghu`.`z_id`';
				
				$query = $this->db->query($sql);
				
				$res = $query->result_array();
				
				// 提取的数据放到$arr_zhanghu里面去;
				foreach ($res as $arr){
					$arr_zhanghu[] = $arr['zhang_hu'];
				}	
			}
			
//		如果是组长，	则获取其相应的组员的账户；
	
		if($role_id==1){
					 $sql = 'select `zhanghu`.`zhang_hu`,`user`.`u_id` from `zhanghu` join `user` on `user`.`name`='."'{$name}'".'
					join `zuzhang_zuyuan` on `user`.`u_id`=`zuzhang_zuyuan`.`zuzhang_id`
					 join `zhanghu_user` on `zuzhang_zuyuan`.`zuyuan_id` =`zhanghu_user`.`u_id` 
					 and `zhanghu_user`.`z_id`=`zhanghu`.`z_id`';
					
					 $query = $this->db->query($sql);
					 
					 $res = $query->result_array();
					 
					 foreach ($res as $arr){
					 	$arr_zhanghu[] = $arr['zhang_hu'];
					 }	
		}
			
//   $arr_zhanghu 里面存放的就是组员的账户数据;
//************************************************************************\\	
						$this->db->select('
											order.time,
											order.zhanghu,
											buy.catalog,
											order.order_id,
											product.product_name,
											order.ANSI,
											order.jine,
											send.s_time,
											send.s_number,
											send.s_way,
											order.message,
											send.s_address,
											product.sale_history,
											send.country_beizhu,
											buy.am_links,
											buy.ck_links,
											buy.sj_links,
											product.price,
											order.yunfei,
											send.s_problem,
											buy.buy_time,
											buy.pic,
											buy.status,
											buy.buy_name
										');
				$this->db->from('order');
				if(isset($arr_zhanghu) && !empty($arr_zhanghu)){
					$this->db->where_in('order.zhanghu',$arr_zhanghu);
				}
				if($choose==5){
					$this->db->join('send','send.o_time = order.time');
					$this->db->join('buy','buy.o_time = order.time');
					$this->db->join('product','product.o_time = buy.o_time and (`product`.`product_name` like '."'%{$attribute}%'"
						.' or `product`.`sku`='."'{$attribute}'".
						' or `send`.`s_number`='."'{$attribute}'".
						' or `order`.`order_id`='."'{$attribute}'".
						' or `buy`.`buy_name`='."'{$attribute}'".
						' or `buy`.`am_links`='."'{$attribute}')"
						);
				}
				if($choose==4){
					$this->db->join('send','send.o_time = order.time');
					$this->db->join('buy','buy.o_time = order.time');
					$this->db->join('product','product.o_time = order.time');
				}
				$query = $this->db->get();
				$res = $query->result_array();	
//		添加分页		
			$this->load->library('pagination');
			$total_num = count($res);
			$config['base_url'] = '/amazon/search/getsearch/showmessage/';
			$config['prev_link'] = '上一页';
			$config['next_link'] = '下一页';
			$config['first_link'] = '第一页';
			$config['last_link'] = '最后一页';
//			$config['uri_segment'] = 5;
			$config['total_rows'] = $total_num;
			$config['per_page'] = 60; 
			if($this->uri->segment(5)){
					 $cur_page = intval($this->uri->segment(5));
					 $config['cur_page']=$cur_page;
			}else{
					$cur_page = 0;
					$config['cur_page']=$cur_page;
				}
					
			$this->pagination->initialize($config);
//	输出分页;		 
//			echo $this->pagination->create_links();
//	调用moddel;
			// 获取该组的所有数据;
			$this->load->model('amazon/search/getsearchresult','cc');
			
			if(isset($arr_zhanghu) && !empty($arr_zhanghu)){
				$result = $this->cc->getresults($arr_zhanghu,$attribute,$cur_page,$config['per_page'],$choose);
			}else{
				$result = $this->cc->getresultsadmin($attribute,$cur_page,$config['per_page'],$choose);
			}
			
//	在模板中输出分页;

		if($role_id==2){
			$data['show_message'] = array($result,$this->pagination->create_links(),$arr_zhanghu);
			
			$this->load->view('amazon/show/showzuyuan',$data);
		}else if($role_id==1){
			$data['show_message'] = array($result,$this->pagination->create_links(),$arr_zhanghu);
			
			$this->load->view('amazon/show/showzuzhang',$data);
			
		}else{
//	获取系统中所有的账户；		
			$this->db->select('zhang_hu');
			$query = $this->db->get('zhanghu');
			$res = $query->result_array();
			
			foreach ($res as $arr_zhanghu){
				
				foreach ($arr_zhanghu as $value){
					if($value){
						$zhanghu[]=$value;
					}
				}
			}
			  $data['show_message'] = array($result,$this->pagination->create_links(),$zhanghu);
			  $this->load->view('amazon/show/showmessage',$data);
			}
			
		}
	}