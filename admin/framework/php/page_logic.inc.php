<?php
//is requested content part of admin base?
$BASE = ($_GET['p'] == 'users' || $_GET['p'] == 'dashboard' || $_GET['sub'] == 'general') ? true : false;

//set page variables
$URI = $Admin->Settings->DB['rooturi'].'admin/';
$PAGE = (isset($_GET['p'])) ? $_GET['p'] : "dashboard";
$HEADER = ($PAGE && $_GET['sub']) ? $_GET['sub'] : $PAGE;
$HEADER = (isset($_GET['action'])) ? $_GET['action'] : $HEADER;
$HEADER = (isset($_GET['action']) && $_POST['action']) ? $_GET['sub'] : $HEADER;
$HEADER = (isset($_GET['p']) && $_GET['p'] == 'settings' && isset($_GET['sub'])) ? $HEADER." Settings" : $HEADER;

//rewrite header if in-active module
$HEADER = (!$BASE && !isset($_GET['sub']) && !in_array($_GET['p'], $Admin->ManageModules->GetActiveModules())) ? "Wait a minute..." : $HEADER;		

//rewrite header if in-active module settings
$HEADER = (!$BASE && isset($_GET['sub']) && !in_array($_GET['sub'], $Admin->ManageModules->GetActiveModules())) ? "Wait a minute..." : $HEADER;		

$HEADER = (!$BASE && isset($_GET['sub']) && $_GET['p'] != 'settings') ? $_GET['sub'] : $HEADER;

//determine if editing own profile, set header if so
if($_GET['p'] == 'users' && $_GET['action'] == 'edit') {
	if($_GET['id'] == $Authenticate->User->GetUserID()) {
		$HEADER = 'Edit: Your Profile';
	}
}
?>