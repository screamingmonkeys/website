<?php 
//======================================================================
//Nichols Administration System
//Forgotten Login Page
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	07.01.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

//requirements
require_once('../framework/php/config.inc.php');
require_once('../framework/php/classes/admin.class.php');

//instantiate classes
$Admin = new Admin($CONFIG);

if($_POST['attempted'] == true && $_POST['email'] != '') {
	$result = $Admin->SendCredentials($_POST['email'], $_POST['url']);
	
	if($result == $CONFIG['ERR_user_does_not_exist']) {
		$error = '<div id="error_message"><p>'.$CONFIG['ERR_user_does_not_exist'].'</p></div>';
	} else {
		$result = $CONFIG['MSG_resent_credentials'];
		$redirect = '<meta http-equiv="Refresh" content="5;url=index.php">';
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>The Nichols Company Administration System</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="Nichols Admin - An custom administration system built for our clientele." />
<meta name="copyright" content="(c)<?=date("Y")?> The Nichols Company" /> 
<meta name="author" content="Tim Novinger, tnovinger@nichols-co.com" /> 
<meta name="web author"content="Tim Novinger, tnovinger@nichols-co.com" /> 
<meta name="reply-to" content="tnovinger@nichols-co.com" />
<link rel="icon" type="image/gif" href="../images/favicon.gif" />
<link rel="stylesheet" type="text/css" href="../framework/css/login.css" />
<!-- CHECK IF BROWSER IS IE6 OR EARLIER -->
<!--[if IE 7]>
	<style type="text/css">
    	form{height:140px;}
	</style>
<![endif]-->
<!--[if IE 6]>
	<style type="text/css">
    	#submitbutton{margin-bottom:-50px; top:0px;}
	</style>
<![endif]-->
<?=$redirect?>
</head>
<body>
<?=$error?>
<div id="wrapper">
	<img src="../images/logo.png" alt="THE NICHOLS COMPANY" />
	<div id="content">
		<hr />
		<h1>Having Trouble Accessing Your Account?</h1>
        <?php if($_POST['attempted'] == true && $result != $CONFIG['ERR_user_does_not_exist']) { 
					echo '<br /><p class="h3">'.$result.'</p>';
			   } else { 
		?>
        <p>Enter the email address associated with your account below and we'll send you an email with your Username and Password.</p>
        <br />
		<form name="login" method="post" action="resend.php" id="login">
			<p><label for="email">Email Address:</label> <input type="text" name="email" tabindex="1" /></p>
            <input type="hidden" name="url" value="http://<?=$_SERVER['HTTP_HOST'].$Admin->Settings->DB['rooturi']?>admin/login" />
            <input type="hidden" name="attempted" value="true" />
		    <input type="submit" name="submitbutton" id="submitbutton" value="SEND" tabindex="2" />
		</form>
        <?php	 } ?>
		<br />
        <br />
        <p class="small"><strong>DISCLAIMER:</strong> This is a restricted area. Please login using your supplied credentials to continue. Copyright &#169; <?=date("Y")?> The Nichols Company. All rights reserved.</p>
		<hr />
		<p class="small">1412 Delaware Avenue | Fort Wayne, Indiana 46805 | (260) 422-6800 | <a href="mailto:<?=$Admin->Settings->DB['admin_email']?>">Email Site Admin</a></p>
	</div>
</div> 
</body>
</html>