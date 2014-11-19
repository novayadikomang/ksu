<?php 
class Home extends BaseController{

	function index(){
		// $users = array(
			// array("username" => "monk3y", "location" => "Portugal"),
			// array("username" => "Sailor", "location" => "Moon"),
			// array("username" => "Treix!", "location" => "Caribbean Islands"),
			// array("username" => "KOmang!", "location" => "Caribbean Islands")
		// );
		$data['title'] = "Homepage";
		//$data['usr'] = $users;
		$this->view('home/newindex',$data);
	}

	function login(){
		$data['title'] = "Homepage";
		$data['layout'] = 'login';
		$this->view('home/newindex',$data);

	}

}