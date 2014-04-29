<?php
	class Gloabl_auto{
	// 加载一些全局的设置属性;	
		public function getVars(){
	// 加载session;		
				session_start();
	//	设置字符编码;		
				header("Content-type: text/html; charset=utf-8");
			}
	}