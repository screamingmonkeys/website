<?php
//======================================================================
//Authenticate Class
//checks submitted login credentials against a database
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.01.08
//
//Copyright 2008 - The Nichols Company
//======================================================================
require_once('user.class.php');

class Authenticate {
	private $root;																								 
	private $username;
	private $password;
	private $authenticated;
	public $User;
	
	
	public function __construct($root) {
		$this->root = $root;			
		$this->User = new User();
		$this->authenticated = false; 
	}
	

	public function IsAuthenticated() {
		if($this->authenticated == false) {
			$this->Login();
		}
		return $this->authenticated;
	}
	
	
	public function Login() {
		if(isset($_SESSION['userid'])){
			$this->authenticated = $this->User->LoadByID($_SESSION['userid']);
			
		} else if(isset($_POST['username'], $_POST['password'])) {
			$this->authenticated = $this->User->LoadByLogin($_POST['username'], $_POST['password']);
		
			if($this->authenticated) {
				$_SESSION['userid'] = $this->User->GetUserID();
			} 
		} else {
			$this->authenticated = false;
		}
	}
	
	
	public function WriteCookie($key, $value) {
		$expire = time() + 60 * 60 * 24 * 2;				//2day's time
		setcookie($key, $value, $expire);
	}
	
	
	public function DestroyCookie($key) {
		setcookie($key);
	}
	
	
	public function RedirectTo($page) {
		$url = $this->root.$page;
		header("Location: $url");
		exit();
	}
	
	
	public function Logout() {
		$this->authenticated = false;
		unset($_SESSION['userid']);
		session_destroy();
    	session_regenerate_id();
	}
}
?>