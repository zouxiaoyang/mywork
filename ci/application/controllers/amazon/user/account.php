<?php
class Account extends CI_Controller {
	
	public function __construct(){
		
		parent::__construct();
		$_SESSION['is_login']='0';
		$this->load->model('amazon/user/denglu','cc');
		
		  $this->load->helper(array('form', 'url'));
		  
		  $this->load->library('form_validation');
	}
 
//获取提交过来的参数;
	public function getpost(){
		
		  
//		添加验证规则；  
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[12]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
		    
	//获取数据；
			$pos = $this->input->post();
			
			if(!empty($pos)){
				
						$name = trim(addslashes($pos['username']));
						$password = trim(addslashes($pos['password']));	
//						$attribute = trim($pos['attribute']);	
						
						$_SESSION['USER_NAME'] = $name;
						
						$_SESSION['USER_PASS'] = $password;
						
	//			对输入的结果进行验证!
	
					  if ($this->form_validation->run() == FALSE)
					  {		
					  		$_SESSION['is_login']=FALSE;
					  		$data['info']=FALSE;
					   		$this->load->view('amazon/user/login',$data);
					   		
					  }else{
//					  		$this->login();
							echo "<script>window.location.href='/amazon/user/account/login'</script>";
					  }
		}
	}	
//新函数开始，登陆函数，表单数据处理；
	 public function login()
	 {
	 	
				if(isset($_SESSION['USER_NAME'])&& $_SESSION['USER_NAME'] && isset($_SESSION['USER_PASS']) && $_SESSION['USER_PASS']){
					
				  	$res = $this->cc->getinfo($_SESSION['USER_NAME'],$_SESSION['USER_PASS']);//返回	验证结果集；是个数组对象；
					  	
					  	if(!empty($res)){
					  		$_SESSION['is_login']='1';
//					  		$data['arr']=array('attr'=>$attribute,'name'=>$name);

							$data['arr'] = $res;
							
							switch ($res[0]['r_id']){
								
								case 1:echo '<script>window.location.href="/amazon/choose/showzuzhang/getallorder"</script>';break;
								
								case 2:echo '<script>window.location.href="/amazon/choose/showzuyuan/getallorder"</script>';break;
								
								case 3:echo '<script>window.location.href="/amazon/upload/upload_file/getallorder"</script>';break;
								
								case 4:echo '<script>window.location.href="/amazon/upload/upload_file/getallorder"</script>';break;
								
								case 5:echo '<script>window.location.href="/amazon/upload/upload_file/getallorder"</script>';break;
								
								default:echo "您没有操作权限！";
								
							}
					  	}else{
					  		$_SESSION['is_login']=FALSE;
					  		$data['info']=FALSE;
					  		$this->load->view('amazon/user/login',$data);
					  	}

					}else{
							$this->load->view('amazon/user/login');
					}
	 }

	 public function getinfo(){
	 	
	 	$res = $this->cc->getinfo($_SESSION['USER_NAME'],$_SESSION['USER_PASS']);//返回	验证结果集；是个数组对象；	
		if(!empty($res)){
			$_SESSION['is_login']='1';
			$data['arr'] = $res;
								switch ($res[0]['r_id']){
								
								case 1:$this->load->view('amazon/user/formsuccess_zuzhang',$data);break;
								
								case 2:$this->load->view('amazon/user/formsuccess_zuyuan',$data);break;
								
								case 3:$this->load->view('amazon/user/formsuccess_admin',$data);break;
								
								case 4:$this->load->view('amazon/user/formsuccess_caigou',$data);break;
								
								case 5:$this->load->view('amazon/user/formsuccess_wuliu',$data);break;
								
								default:echo "您没有操作权限！";
								
							}
		 }
	 }
// 退出系统;	 

	public function logout(){
	
			$_SESSION['is_login']=FALSE;
			$_SESSION['USER_NAME']=FALSE;
			$_SESSION['USER_PASS']=FALSE;
			
			$this->load->view('amazon/user/logout');
		}
}
?>