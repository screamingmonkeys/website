<?php
//GENTLEMEN, START YOUR ENGINES!!
session_start();

//requirements
require_once('framework/php/config.inc.php');
require_once('framework/php/classes/admin.class.php');
require_once('framework/php/classes/authenticate.class.php');

//instantiate classes
$Admin = new Admin($CONFIG);																								
$Authenticate = new Authenticate($Admin->Settings->DB['rooturi']);

//security logic
if(isset($_GET['l']) && $_GET['l'] == "1"){
	$Authenticate->Logout();
	$Authenticate->RedirectTo('admin');
}																									

if(!$Authenticate->IsAuthenticated()) {
	$Authenticate->RedirectTo('admin/login');
}
?>