<?php
	class Sucess extends CI_Controller{
		
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$this->load->view('amazon/user/formsuccess');
		}
	}