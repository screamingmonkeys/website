<?php
//======================================================================
//Manage Modules Class
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.02.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

class ManageModules {	
	private $CONFIG;
	private $CountAll;
	private $CountActive;
	private $ActiveModules;	
			
	public function __construct($CONFIG) {
		$this->CONFIG = $CONFIG;
		$this->FindActiveModules();
	}
	
	
	public function GetCountAll() {return $this->CountAll;}
	public function GetCountActive() {return $this->CountActive;}
	public function GetActiveModules() {return $this->ActiveModules;}
	
	
	public function GetModuleRequirement($option) {
		$sections = ($Manage->Settings->DB['use_sections'] == 'false') ? "AND name <> sections" : "";
		$locations = ($Manage->Settings->DB['use_locations'] == 'false') ? "AND name <> locations" : "";
		$sql = "SELECT id,
					   name,
					   submenus,
					   status
				FROM modules
				WHERE name <> 'general' ".$sections.$locations;
		$result = mysql_query($sql) or die("Query failed (read settings): ".$sql." - ".mysql_error());
		
		while($module = mysql_fetch_array($result)) {
			if($module['status'] == '1') {
				if($option == 'CSS') {
					$data .= "<link rel='stylesheet' type='text/css' href='framework/modules/".strtolower(str_replace(" ", "_", $module['name']))."/style.css' /> \n";
				}
				if($option == 'MENU' && $module['name'] != 'help') {
					$data .= "<li id='m_".$module['name']."'><a href='".$URI."?p=".$module['name']."'>".$module['name']."</a></li> \n";				
				}
				if($option == 'SUB_MENU') {
					if($module['name'] == $_GET['p']) {
						$submenu = explode(',', $module['submenus']);
						$nOr = count($submenu);
						
						for($i=0; $i<$nOr; $i++) {
							$data .= "<li><a href='".$URI."?p=".$module['name']."&amp;sub=".$submenu[$i]."' class='ajax'>".$submenu[$i]."</a></li> \n";
						}
						
						
						if($module['name'] == 'help'){
							unset($submenu, $nOr, $data);
							$submenu = $this->ActiveModules;
							$nOr = count($submenu)-1;			//the -1 removes the array entry for a , that's left over from $this->FindActiveModules()
							for($i=0; $i<$nOr; $i++) {
								if($submenu[$i] != 'help'){
									$data .= "<li><a href='".$URI."?p=".$module['name']."&amp;sub=".$submenu[$i]."' class='ajax'>".$submenu[$i]."</a></li> \n";
								}
							}
						}
					}
				}
				if($option == 'SETTINGS' && $module['name'] != "help") {
					$data .= "<li><a href='".$URI."?p=".$_GET['p']."&amp;sub=".$module['name']."' class='ajax'>".$module['name']."</a></li> \n";
				}
			}
		}
		return $data;
		
		mysql_free_result($result);
		unset($sql, $data, $result, $module, $option);
	}
	
	
	public function FindActiveModules() {
		$sql = "SELECT name
				FROM modules
				WHERE status = '1'";
		$result = mysql_query($sql) or die("Query failed (read settings): ".$sql." - ".mysql_error());
		$this->CountActive = mysql_num_rows($result);
		
		while($module = mysql_fetch_array($result)) {
			$this->ActiveModules .= $module['name'].',';
		}
		$this->ActiveModules = explode(",", $this->ActiveModules);
		
		mysql_free_result($result);
		unset($sql, $result, $module);
	}
	
	
	public function ListModules() {
		$sql = "SELECT * FROM modules ORDER BY name";
		$result = mysql_query($sql) or die("Query failed (read settings): ".$sql." - ".mysql_error());
		$this->CountAll = mysql_num_rows($result);
		
		while($module = mysql_fetch_array($result)) {
			$zebra = ($i % 2) ? "even" : "odd";		 																					//zebra striping logic
			$STATUS = ($module['status'] == '1') ? "active" : "in-active";
			if($module['status'] == 1){
				$DATA .= "<tr class='".$zebra."'>
							<td><strong>".ucwords($module['name'])."</strong></td>
							<td>".$module['description']."</td>
							<td>".$module['version']."</td>
						  </tr>";
				$i++;
			}
		}
		$DATA = (mysql_num_rows($result)) ? $DATA : "<tr><td colspan='3'>".$this->CONFIG['MSG_returned_zero_results']."</td></tr>";
		return $DATA;
		
		mysql_free_result($result);
		unset($sql, $result, $module, $DATA, $STATUS);
	}
}
?>