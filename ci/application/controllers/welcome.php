<?php 
	class Welcome extends CI_Controller{
		public function index(){
			$this->load->helper('url');
			$info=<<<EOD
			<h3>亚马逊项目开发中...</h3>
EOD;
			echo $info;
			
			$this->load->view('welcome_message');
		}
	}
?>