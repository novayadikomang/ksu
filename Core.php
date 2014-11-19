<?php 
Class Core {
	public $path = PATH;
	public $base_url = DOMAIN;
	public $layout = "Layout";
	
	public function __construct(){
		
	}

	function load(){ echo 'test'; }

	function site(){
		return $this->base_url . $this->path . $this->layout .'/';
	}
	
	function site_url(){
		return $this->base_url . $this->path;
	}
	
	function Request($param=null){
	
		if($param != null){
			return $_REQUEST[$param];
		}
		return $_REQUEST;
	}
	
}