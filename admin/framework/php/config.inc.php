<?php
//======================================================================
//Nichols Administration System
//CONFIGURATION FILE
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.09.08
//
//Copyright 2008 - The Nichols Company
//======================================================================
	
	//database connection information
	$CONFIG['DB_host']									= "mysql.screamingmonkeys.org";
	$CONFIG['DB_database']								= "screamingmonkeys";
	$CONFIG['DB_username']								= "screamingmonkeys";
	$CONFIG['DB_password']								= "bubbles";
	
	//information messages
	$CONFIG['MSG_items_deleted']						= "Congratulations, you'll never get to see those ever again. Especially if that was a mistake.";
	$CONFIG['MSG_returned_zero_results']				= "There isn't anything to show you, why don't you create something?";
	$CONFIG['MSG_returned_zero_upcoming_expirations'] 	= "Congratulations, there are no jobs expiring soon.";
	$CONFIG['MSG_delete_confirmation']					= "Are you sure you want to DELETE the selected items?";
	$CONFIG['MSG_serious_confirmation']					= "Changing this value can potentially break this application, are you SURE???";
	$CONFIG['MSG_resent_credentials']					= "We've resent your Username and Password to the email address associated with your account. You will be redirected to the login page in 5 seconds.";
	$CONFIG['MSG_admin_resent_credentials']				= "Account information has been resent";
	$CONFIG['MSG_settings_saved']						= "Your settings have been saved.";
	$CONFIG['MSG_please_turn_feature_on']				= "To use this feature, please turn it on in the module's <a href='?p=settings&amp;sub=".$_GET['p']."'>settings</a>.";
		
	//error messages
	$CONFIG['ERR_bad_user_or_pass'] 					= "Uh oh, we don't know who you are.";
	$CONFIG['ERR_cannot_delete_self'] 					= "Sorry, but you can't erase your own existance!";
	$CONFIG['ERR_none_selected']						= "You need to select an item first in order to do that...";
	$CONFIG['ERR_unmatching_passwords']					= "Those passwords you entered do not match, please re-enter them.";
	$CONFIG['ERR_invalid_email']						= "Looks like that's not a valid email address there...please enter one.";
	$CONFIG['ERR_user_already_exists']					= "Sorry, that account already exists. Please choose a different USERNAME.";
	$CONFIG['ERR_user_does_not_exist']					= "Sorry, that user account does not exist.";
	$CONFIG['ERR_inactive']								= "You're attempting to load something that is not active, which coincidentally, is quite impossible.";
	$CONFIG['ERR_empty_login'] 							= "Woops! Please enter a username and password to continue.";
	$CONFIG['ERR_empty_passwords']						= "Oh no, we need a password to setup this account. Please enter matching passwords below.";
	$CONFIG['ERR_empty_email']							= "Missed a spot...don't forget to enter an email address.";
	$CONFIG['ERR_empty_form']							= "Don't forget to fill in any of those pesky boxes...";
	$CONFIG['ERR_empty_field']							= "This field is required: ";
	$CONFIG['ERR_empty_date']							= "Please enter a date.";
	$CONFIG['ERR_empty_title']							= "What are you calling this masterpiece?";
	$CONFIG['ERR_empty_content']						= "Just a reminder, we need lots and lots of content!";
	$CONFIG['ERR_empty_section_name']					= "Your new section needs a name, please give it one";
	$CONFIG['ERR_empty_location_name']					= "Your new location needs a name, please give it one";
	$CONFIG['ERR_inactive_page_title']					= "We're Sorry...";
	$CONFIG['ERR_inactive_page_content']				= "But the page you're looking for no longer exists.";
	$CONFIG['ERR_must_create_section_first']			= "You must create a section for your page to reside within <a href='?p=manage&sub=sections&action=create'>FIRST</a>.<br /><br /><strong>Important!</strong><br />After you create a section you will need to return to your pages and assign them to a  parent section.<br />As you're doing this, it will appear that your pages are \"disappearing\" or \"deleting\" after you save them.<br /><br /><em>Calm down, this is not what's happening.</em><br /><br />You will be able to see your <strong>moved</strong> pages once again <strong>after</strong> you complete the process of assigning them to a their new section.";
?>