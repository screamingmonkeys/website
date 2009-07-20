<?php
//======================================================================
//Admin Class
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.09.08
//
//Copyright 2008 - The Nichols Company
//======================================================================
require_once('mysql.class.php');
require_once('settings.class.php');
require_once('manage_users.class.php');
require_once('manage_modules.class.php');
require_once('paginator.class.php');

class Admin {
	public $CONFIG;
	public $Settings;
	public $DB;
	public $ManageUsers;
	public $ManageModules;
			
			
	public function __construct($CONFIG) {
		$this->CONFIG = $CONFIG;
	 	$this->DB = new MySQL();
					$this->DB->SetHost($this->CONFIG['DB_host']);
					$this->DB->SetUsername($this->CONFIG['DB_username']);
					$this->DB->SetPassword($this->CONFIG['DB_password']);
					$this->DB->SetDatabase($this->CONFIG['DB_database']);
					$this->DB->Connect();
		$this->Settings = new Settings('general');
		$this->ManageUsers = new ManageUsers($CONFIG);
		$this->ManageModules = new ManageModules($CONFIG);
	}
	
	
	public function GetCompanyName() {
		return $this->Settings->DB['company_name'];
	}
	
	
	private function SendMail($TO, $SUBJECT, $MESSAGE) {
		$from_name = $this->Settings->DB['admin_name'];
		$from_address = $this->Settings->DB['admin_email'];
		
		$HEADERS = 'MIME-Version: 1.0' . "\n";
		$HEADERS .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
		$HEADERS .= "From: ".$from_name." <".$from_address.">\n";
		$HEADERS .= "X-Sender: <".$from_address.">\n";
		$HEADERS .= "X-Mailer: PHP\n"; // mailer
		$HEADERS .= "X-Priority: 1\n"; // Urgent message!
		
		mail($TO, $SUBJECT, $MESSAGE, $HEADERS) or die('error: failed to connect to mailserver');
	}
	
	
	public function SendNewUserGreeting($USERNAME, $url) {
		$USER =	$this->ManageUsers->GetUserProfileByUsername($USERNAME);															//Check if user exists
		
		$TO = $USER['email']; 																				
		$SUBJECT = "Welcome to the ".ucwords($this->GetCompanyName())." Admin";																
		
		$MESSAGE = "<h2>Welcome!</h2><p>Dear ".$USER['fullname'].",<br />An account has been created for you in your company's web site administration system.<br />Your username and password are listed below. You may use them to log into the site <a href='".$url."' target='_blank'>here</a>.</p><hr /><p><strong>USERNAME:</strong> ".$USER['username']."<br /><strong>PASSWORD:</strong> ".$USER['password']."<hr /><p style='font-size:11px;font-variation:italic;'>This is an automated message from the Nichols Administration System.</p>";
		
		$this->SendMail($TO, $SUBJECT, $MESSAGE);																		
	}
	
	
	public function SendCredentials($email, $url) {
		$USER =	$this->ManageUsers->GetUserProfileByEmail($email);																	//Check if user exists
		
		if($USER['email'] == $email) {	
			$TO = $USER['email']; 																				
			$SUBJECT = "Here is your login information";																	
			
			$MESSAGE = "<h2>Your Login Information</h2><p>Dear ".$USER['fullname'].",<br />We're sorry to see that you've forgotten your login information.<br />Your username and password are listed below. You may use them to log into the site <a href='".$url."' target='_blank'>here</a>.</p><hr /><p><strong>USERNAME:</strong> ".$USER['username']."<br /><strong>PASSWORD:</strong> ".$USER['password']."<hr /><p style='font-size:11px;font-variation:italic;'>This is an automated message from the Nichols Administration System.</p>";
			
			$this->SendMail($TO, $SUBJECT, $MESSAGE);																		
			
			return $this->CONFIG['MSG_resent_credentials'];
		} else {
			return $this->CONFIG['ERR_user_does_not_exist'];
		}
	}
	
	
	public function StripTags($data, $level) {
		switch($level) {
			case 'loose' :
				$result = strip_tags($data, "<b><strong><i><em><h1><h2><h3><h4><h5><h6><abbr><code><quote><div><address><cite><dfn><cite><del><ins><bdo><q><acronym><img><p><span><hr /><hr><a><u><img><ol><ul><li><dd><dt><dl><br><br /><table><tr><td><tbody><thead><th><tt><tfoot><code><blockquote><q><sub><sup><small><iframe>");
				break;
			case 'strict' :
				$result = strip_tags($data);
				break;
			default :
				$result = strip_tags($data);
				break;
		}
		return $result;
	}
}
?>