<?php
//======================================================================
//User Class
//Create a user object to store user information
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	07.07.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

class User {			
	private $id;	
	private $fullname;	
	private $email;																			
	private $username;
	private $password;
	private $level;
	private $DB;
	
	
	public function __construct() {	
	}


	public function IsValid() {
		if($this->id != 0) {
			return true;
		} else {
		    return false;
		}
	}
	
	
	public function LoadByLogin($username, $password) {
		$sql = 'SELECT * 
			    FROM users
				WHERE username = "'.$username.'"
				AND password = "'.$password.'"
				';
		$result = mysql_query($sql) or die("Query failed: ".$sql);
		
		if($user = mysql_fetch_array($result)) {
			$this->CreateUser($user);
		}
		
		mysql_free_result($result);
		unset($sql, $result, $user);
		
		return $this->IsValid();
	}
	
	
	public function LoadByID($id) {
		$sql = 'SELECT * 
		        FROM users
				WHERE id = "'.$id.'"
				';
		$result = mysql_query($sql) or die("Query failed: ".$sql);
		
		if($user = mysql_fetch_array($result)) {
			$this->CreateUser($user);
		}
		
		mysql_free_result($result);
		unset($sql, $result, $user);
		
		return $this->IsValid();
	}
	
	
	public function CreateUser($user) {
		$this->id = $user['id'];
		$this->fullname = $user['fullname'];
		$this->email = $user['email'];
		$this->username = $user['username'];
		$this->password = $user['password'];
		$this->level = $user['level'];
	}
	
	
	public function UpdateUser($fullname, $level) {
		$this->fullname = $fullname;
		$this->level = $level;
	}
	
	
	/* GET METHODS */
	public function GetUserID() {return $this->id;}
	public function GetFullname() {return $this->fullname;}
	public function GetEmail() {return $this->email;}
	public function GetUsername() {return $this->username;}
	public function GetUserLevel() {return $this->level;}
}
?>