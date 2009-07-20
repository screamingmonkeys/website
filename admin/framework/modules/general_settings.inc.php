<?php
//======================================================================
//Nichols Administration System
//General Settings Module
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.07.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

if($_POST['edit_settings']) {
	//check points
	$check1 = $_POST['company_name'] != '' ? true : false;
	$message .= ($check1 == false) ? $CONFIG['ERR_empty_field']."<b>COMPANY NAME</b><br />" : "";
	$check2 = $_POST['website'] != '' ? true : false;
	$message .= ($check2 == false) ? $CONFIG['ERR_empty_field']."<b>WEBSITE</b><br />" : "";
	$check3 = $_POST['admin_name'] != '' ? true : false;
	$message .= ($check3 == false) ? $CONFIG['ERR_empty_field']."<b>ADMIN NAME</b><br />" : "";
	
	//validate email address by checking for @ symbol
	if($_POST['admin_email'] != '') {
		if(strpbrk($_POST['admin_email'], "@") != "") {
			$check4 = true;
		} else {
			$check4 = false;
			$message .= "<p>".$CONFIG['ERR_invalid_email']."</p>";
		}
	} else {
		$check4 = false;
		$message .= "<p>".$CONFIG['ERR_empty_email']."</p>";
	}
	
	$check5 = $_POST['rooturi'] != '' ? true : false;
	$message .= ($check5 == false) ? $CONFIG['ERR_empty_field']."<b>ROOT URI</b><br />" : "";
	
	//save settings to database
	if($check1 && $check2 && $check3 && $check4 && $check5) {
		foreach($_POST as $NAME => $VALUE){																		//loop through forum inputs and save each
			$Save = $Admin->Settings->EditSettings($NAME, $VALUE);
		}
		
		$message = "<p>".$CONFIG['MSG_settings_saved']."</p>";
	} else if(!$check1 && !$check2 && !$check3 && !$check4 && !$check5) {
		$message .= "<p>".$CONFIG['ERR_empty_form']."</p>";
	}
	echo "<div class='info_block'><p>".$message."</p></div>";													//display message(s)
	
	$Refresh = $Admin->Settings->ReadSettings('general');
}
?>
<form name="edit_settings" action="?p=settings&sub=general" method="post" id="form_check" class="no_style">
	<table>
    	<tbody>
            <tr>
                <td width="150" class="align_right"><label for="company_name">Company Name:</label></td>
                <td width="270"><p><input name="company_name" type="text" value="<?=$Admin->Settings->DB['company_name']?>" tabindex="1" maxlength="255" onchange="return alert('<?=$CONFIG['MSG_serious_confirmation']?>');" /></p></td>
                <td></td>
            </tr>
            <tr>
                <td class="align_right"><label for="website">Website:</label></td>
                <td><p><input name="website" type="text" value="<?=$Admin->Settings->DB['website']?>" tabindex="2" maxlength="255" class="validate['required'] text-input" /></p></td>
                <td></td>
            </tr>
            <tr>
                <td class="align_right"><label for="admin_name">Admin Name:</label></td>
                <td><p><input name="admin_name" type="text" value="<?=$Admin->Settings->DB['admin_name']?>" tabindex="3" maxlength="255" class="validate['required'] text-input" /></p></td>
                <td></td>
            </tr>
            <tr>
                <td class="align_right"><label for="admin_email">Admin Email:</label></td>
                <td><p><input name="admin_email" type="text" value="<?=$Admin->Settings->DB['admin_email']?>" tabindex="4" maxlength="255" class="validate['required'] text-input" /></p></td>
                <td><span class="description">This address is used for admin purposes, like new user notification.</span></td>
            </tr>
            <tr>
                <td class="align_right"><label for="rooturi">Root URI:</label></td>
                <td><p><input name="rooturi" type="text" value="<?=$Admin->Settings->DB['rooturi']?>" tabindex="6" maxlength="255" onchange="return alert('<?=$CONFIG['MSG_serious_confirmation']?>');" /></p></td>
                <td><span class="description">Example: <u>http://www.yourdomain.com/admin</u> - use "/" without quotes.</span></td>
            </tr>
        </tbody>
   </table>  
   <input name="edit_settings" type="hidden" value="true" />
   <hr />
    <div class="block">
        <input type="submit" name="bttn_submit" value="Save" class="buttonright green submitbutton" tabindex="7" />
    </div>
</form> 