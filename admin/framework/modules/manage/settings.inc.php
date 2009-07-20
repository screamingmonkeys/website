<?php
//======================================================================
//Nichols Administration System
//Manage Settings Module
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	07.01.08
//
//Copyright 2008 - The Nichols Company
//======================================================================
require_once('framework/php/classes/manage.class.php');

//Instantiate class
$Manage = new Manage($Admin);


if($_POST['edit_settings']) {
	//check points
	/*
	$check1 = $_POST['use_sections'] != '' ? true : false;
	$message .= ($check1 == false) ? $CONFIG['ERR_empty_field']."<b>USE SECTIONS</b><br />" : "";
	*/
	$check1 = true;
		
	//save settings to database
	if($check1) {
		foreach($_POST as $NAME => $VALUE){																		//loop through forum inputs and save each
			$Save = $Manage->Settings->EditSettings($NAME, $VALUE);
		}
		
		$message = "<p>".$CONFIG['MSG_settings_saved']."</p>";
	} else if(!$check1) {
		$message .= "<p>".$CONFIG['ERR_empty_form']."</p>";
	}
	echo "<div class='info_block'>".$message."</div>";													//display message(s)
	
	$Refresh = $Manage->Settings->ReadSettings('manage');
}
?>
<form name="edit_settings" action="?p=settings&sub=manage" method="post" id="edit_settings" class="no_style">
	<table>
    	<tbody>
            <tr>
                <td class="align_right"><label for="use_sections">Use Sections?</label></td>
                <td><select name="use_sections">
							<option value="true" <?=$Manage->Settings->DB['use_sections'] == 'true' ? 'selected="selected"' : ''?>>True</option>
							<option value="false" <?=$Manage->Settings->DB['use_sections'] == 'false' ? 'selected="selected"' : ''?>>False</option>
					</select></td>
                <td><span class="description">Select TRUE if you want pages to reside within sections.</span></td>
            </tr>
        </tbody>
   </table>  
   <input name="edit_settings" type="hidden" value="true" />
   <hr />
    <div class="block">
        <input type="submit" name="bttn_submit" value="Save" class="buttonright green submitbutton" tabindex="7" />
    </div>
</form> 