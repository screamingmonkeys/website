<?php
//======================================================================
//Settings Class
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	09.05.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

class Settings {
	public $MODULE;
	public $DB;
			
	public function __construct($module) {		
		$this->MODULE = $module;
		$this->ReadSettings();
	}
	
	
	public function ReadSettings($module) {
		$sql = "SELECT  
					 settings.id, 
					 settings.name, 
					 settings.value, 
					 settings.module
				FROM settings, modules
				WHERE settings.module = '".$this->MODULE."'";
		$result = mysql_query($sql) or die("Query failed (read settings): ".$sql." - ".mysql_error());
		
		while($row = mysql_fetch_assoc($result)) {
			$this->DB[str_replace(" ", "_", $row['name'])] = $row['value'];
		}
		return $result;
		
		mysql_free_result($result);
		unset($sql, $result, $row);
	}	
	
	
	public function EditSettings($NAME, $VALUE) {
		$sql = "UPDATE settings 
				SET value = '".$VALUE."'
				WHERE name = '".$NAME."'  
				AND module = '".$this->MODULE."'";
		$result = mysql_query($sql) or die("Query failed (save settings): ".$sql." - ".mysql_error());
		
		return $sql;
		
		mysql_free_result($result);
		unset($sql, $result);
	}
}
?>