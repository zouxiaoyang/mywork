<?php
	class Pic extends CI_Controller{
		function __construct()
					 {
					  parent::__construct();
					  $this->load->helper(array('form', 'url'));
					  $db = $this->load->database();
//	判断用户是否登录  
	 if($_SESSION['is_login']!='1'){
		echo '<script>alert("请先登录！");window.location.href="/amazon/user/account/login";</script>';
		exit();
	}
					 }
			 
		 function upload_pic()
			 {
			  $config['upload_path'] = './tools/images/';
			  $config['allowed_types'] = 'gif|jpg|png|jpeg';
			  $config['max_size'] = '1000';
			  $config['max_width']  = '1024';
			  $config['max_height']  = '768';
			  $config['overwrite'] = TRUE;
			  $url =  $this->input->post('url');
			  $backurl = $this->input->post('backurl');
			  $orderid = $this->input->post('orderid');
			  $this->load->library('upload', $config);
			  $filename = $_FILES['userfile']['name'];	
			  if (!$this->upload->do_upload())
				  {
				   /*	$error = array('error' => $this->upload->display_errors());*/
				   	$url = array('url'=>$url,'backurl'=>$backurl);
					$this->load->view('amazon/image/upload_error',$url);
				  } 
			  else
				  {
//				 查看该图片是否存在！
				$arr_order_id = array('o_time ='=>$orderid);
				$arr_order_pic2 = array('pic'=>$filename.'||');
				$this->db->select('pic');
				$this->db->like('pic',$filename);
				$query = $this->db->get_where('buy',$arr_order_id);
				$res = $query->result_array();
				if($res){
							echo "<script>alert(\"该图片名称数据库中已经更新，ok!\")</script>";
					}else{
						
							$arr_order_id = array('o_time ='=>$orderid);
							$arr_order_pic = array('pic'=>$filename.'||');
							$this->db->select('pic');
							$query = $this->db->get_where('buy',$arr_order_id);
							$res1 = $query->result_array();
							if($res1){
								$pic = $res1[0]['pic'].'||'.$filename;
								$arr_order_pic = array('pic'=>$pic);
								$this->db->where($arr_order_id);
								$this->db->update('buy',$arr_order_pic);
							}else{
								$this->db->where($arr_order_id);
								$this->db->update('buy',$arr_order_pic2);
							}
					}	
				   $data= array('upload_data' => $this->upload->data(),'url'=>$url,'backurl'=>$backurl);
				   $this->load->view('amazon/image/upload_success', $data);
				  }
			 } 
	}