<?php 
//======================================================================
//Nichols Administration System
//Login Page
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.07.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

//GENTLEMEN, START YOUR ENGINES!!
session_start();

//requirements
require_once('../framework/php/config.inc.php');
require_once('../framework/php/classes/admin.class.php');
require_once('../framework/php/classes/authenticate.class.php');

//instantiate classes
$Admin = new Admin($CONFIG);
$Authenticate = new Authenticate($Admin->Settings->DB['rooturi']);		

//security logic
if($_COOKIE['username'] != '' && $_COOKIE['password'] != '') {
	$checked = 'checked="checked"';
} 
if($_POST['attempted']){
	if($_POST['username'] != "" && $_POST['password'] != "") {			
		if($Authenticate->IsAuthenticated()) {
			if($_POST['cookie']) { 
				$Authenticate->WriteCookie('username', $_POST['username']);
				$Authenticate->WriteCookie('password', $_POST['password']);
			} else {
				$Authenticate->DestroyCookie('username', $_POST['username']);
				$Authenticate->DestroyCookie('password', $_POST['password']);
			}
			$Authenticate->RedirectTo('admin');
		} else {	
			$error = "<div id='error_message'><p>".$CONFIG['ERR_bad_user_or_pass']."			
											  <a href='resend.php'>Forget your password?</a></p>
					  </div>";																									//ERROR: incorrect credentials
		}
	} else {
		$error = "<div id='error_message'><p>".$CONFIG['ERR_empty_login']."</p></div>";											//ERROR: blank fields
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>The Nichols Company Administration System</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="Nichols Admin - An custom administration system built for our clientele." />
<meta name="copyright" content="(c)<?=date("Y")?> The Nichols Company" /> 
<meta name="author" content="Tim Novinger, tnovinger@nichols-co.com" /> 
<meta name="web author"content="Tim Novinger, tnovinger@nichols-co.com" /> 
<meta name="reply-to" content="tnovinger@nichols-co.com" />
<link rel="icon" type="image/gif" href="../images/favicon.gif" />
<link rel="stylesheet" type="text/css" href="../framework/css/login.css" />
<!--[if IE 8]>
	<style type="text/css">
    	#submitbutton{position:relative;top:0;}
	</style>
<![endif]-->
<!--[if IE 7]>
	<style type="text/css">
    	form{height:155px;}
    	#submitbutton{position:relative;top:-25px;}
	</style>
<![endif]-->
<!--[if IE 6]>
	<style type="text/css">
    	#submitbutton{position:relative;top:-25px; margin-bottom:-25px;}
	</style>
<![endif]-->
</head>
<body>
<?=$error?>
<div id="wrapper">
	<img src="../images/logo.png" alt="THE NICHOLS COMPANY" />
	<div id="content">
		<hr />
		<h1>Hello,</h1>
        <p>We love simple things that make life easier on everyone. It's because of this that we've created this administration system just for <b class="h3">you</b>, our client. To manage your web site, please <b class="h3">login to continue...</b></p>
        <br />
		<form name="login" method="post" action="index.php" id="login">
			<p><label for="username">Username:</label> <input type="text" name="username" value="<?=$_COOKIE['username']?>" tabindex="1" /></p>
			<p><label for="password">Password:</label> <input type="password" name="password" value="<?=$_COOKIE['password']?>" tabindex="2" /></p>
			<input type="checkbox" name="cookie" <?=$checked?> tabindex="3" style="width:15px;border:none;" title="do not use if on a public computer" /> <label for="cookie" title="do not use if on a public computer">remember me</label>
            <input type="hidden" name="attempted" value="true" />
		    <input type="submit" name="submitbutton" id="submitbutton" value="LOGIN" tabindex="4" />
		</form>
		<br />
        <br />
		<p class="small"><strong>DISCLAIMER:</strong> This is a restricted area. Please login using your supplied credentials to continue. Copyright &#169; <?=date("Y")?> The Nichols Company. All rights reserved.</p>
		<hr />
		<p class="small">1412 Delaware Avenue | Fort Wayne, Indiana 46805 | (260) 422-6800 | <a href="mailto:<?=$Admin->Settings->DB['admin_email']?>">Email Site Admin</a></p>
	</div>
</div> 
</body>
</html>