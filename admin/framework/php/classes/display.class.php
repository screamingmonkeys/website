<?php
//======================================================================
//Display Class
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	09.30.08
//
//Copyright 2008 - The Nichols Company
//======================================================================
require_once('mysql.class.php');
require_once('settings.class.php');

class Display {
	public $CONFIG;
	public $MODULE;
	public $Settings;
	public $DB;
			
			
	public function __construct($CONFIG, $MODULE) {
		$this->CONFIG = $CONFIG;
		$this->MODULE = $MODULE;
	 	$this->DB = new MySQL();
					$this->DB->SetHost($this->CONFIG['DB_host']);
					$this->DB->SetUsername($this->CONFIG['DB_username']);
					$this->DB->SetPassword($this->CONFIG['DB_password']);
					$this->DB->SetDatabase($this->CONFIG['DB_database']);
					$this->DB->Connect();
		$this->Settings = new Settings($this->MODULE);
	}
	
	
	public function Get($cols, $table, $where) {
		$sql = "SELECT ".$cols."
				FROM ".$table."
				".$where."
			   ";
		$result = mysql_query($sql) or die("Query failed (generate single): ".$sql." - ".mysql_error());
		return mysql_fetch_array($result);
		mysql_free_result($result);
		unset($sql, $result, $table, $where, $data);
	}
	
	
	public function GetMultiple($cols, $table, $where) {
		$sql = "SELECT ".$cols."
				FROM ".$table."
				".$where."
			   ";
		$result = mysql_query($sql) or die("Query failed (generate multiple): ".$sql." - ".mysql_error());
		return $result;
		mysql_free_result($result);
		unset($sql, $result, $table, $where, $data);
	}
	
	
	public function nl2p($data){
	  return str_replace('<p></p>', '', '<p>'
        . preg_replace('#([\r\n]\s*?[\r\n]){2,}#', '</p>$0<p>', $data)
        . '</p>');
	}
	
	public function Clean($data){
		return str_replace("\'", "'", str_replace('&#35;"', '="', str_replace("=", "&#35;", str_replace("&", "&amp;", $data))));
	}
}
?>