<?php
//======================================================================
//Nichols Administration System
//Users Module
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.07.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

//Instantiate Pagination
$Admin->ManageUsers->Paginator->SetRecordsPerPage(5);
$Admin->ManageUsers->Paginator->SetMaxPagesShown(5);
$Admin->ManageUsers->Paginator->SetRecordParams($_SERVER['QUERY_STRING']);
$Admin->ManageUsers->Paginator->SetCurrentPage($_GET['offset']);

//DETERMINE SORTING LINKS
$lnk_all_users = ($_GET['role'] != "") ? '<a href="'.$URI.'?p=users&amp;sub=view all" rel="p=users&amp;sub=view all" tabindex="1" class="ajax">All Users</a>' : 'All Users';
$lnk_administrator = ($_GET['role'] != "2") ? '<a href="'.$URI.'?p=users&amp;sub=view all&amp;role=2" rel="p=users&amp;sub=view all&amp;role=2" tabindex="2" class="ajax">Administrator</a>' : 'Administrator';
$lnk_user = ($_GET['role'] != "1") ? '<a href="'.$URI.'?p=users&amp;sub=view all&amp;role=1" rel="p=users&amp;sub=view all&amp;role=1" tabindex="3" class="ajax">User</a>' : 'User';

//RESEND ACCOUNT INFORMATION
if($_GET['rs']) {
	$resend = $Admin->SendCredentials($_GET['rs'], 'http://'.$_SERVER['HTTP_HOST'].$Admin->Settings->DB['rooturi'].'admin/login');
	$message = "<p>".$CONFIG['MSG_admin_resent_credentials']." to ".strtoupper($_GET['rs'])."</p>";
}

//DELETE USER(S)
if($_POST['action'] == "delete") {
	if(isset($_POST['id'])) {
		foreach($_POST['id'] as $ID) {
			if(is_numeric($ID)) {
				if($ID != $Authenticate->User->GetUserID()) {
					$delete = $Admin->ManageUsers->DeleteUsers($ID);
					$message = "<p>".$CONFIG['MSG_items_deleted']."</p>";
				} else {
					$message = "<p>".$CONFIG['ERR_cannot_delete_self']."</p>";
				}
			}
		}
	} else {
		$message = "<p>".$CONFIG['ERR_none_selected']."</p>";
	}
}
															
//make sure passwords are entered and that they match each other																	//CREATE OR EDIT A USER
if($_POST['create_user'] == true || $_POST['edit_user'] == true) {
	$check1 = false;
	$check2 = false;
	$msg_create_error = "";
	
	if($_POST['fullname'] != '' || $_POST['fullname'] != $_POST['fullname'] &&
	   $_POST['username'] != '' || $_POST['username'] != $_POST['username'] &&
	   $_POST['password1'] != '' || $_POST['password1'] != $_POST['password1'] &&
	   $_POST['password2'] != '' || $_POST['password2'] != $_POST['password2'] &&
	   $_POST['email'] != '' || $_POST['email'] != $_POST['email']
	   ) {
		if($_POST['password1'] != '' || $_POST['password2'] != '') {
			if($_POST['password1'] == $_POST['password2']) {
				 $check1 = true;
			} else {
				$check1 = false;
				$msg_create_error .= "<p>".$CONFIG['ERR_unmatching_passwords']."</p>";
			}
		} else {
			$check1 = false;
			$msg_create_error .= "<p>".$CONFIG['ERR_empty_passwords']."</p>";
		}
		
		//validate email address by checking for @ symbol
		if(isset($_POST['email'])) {
			if(strpbrk($_POST['email'], "@") != "") {
				$check2 = true;
			} else {
				$check2 = false;
				$msg_create_error .= "<p>".$CONFIG['ERR_invalid_email']."</p>";
			}
		} else {
			$check2 = false;
			$msg_create_error .= "<p>".$CONFIG['ERR_empty_email']."</p>";
		}
	} else {
		$check1 = false;
		$check2 = false;
		$msg_create_error .= "<p>".$CONFIG['ERR_empty_form']."</p>";
	}

	//send data and create user
	if($check1 == true && $check2 == true) {
		$user_exists = $Admin->ManageUsers->GetUserProfileByUsername($_POST['username']);									//check if user already exists
		
		if($_POST['create_user'] == true){
			if($user_exists['username'] != $_POST['username']) {
				$CreateUser = $Admin->ManageUsers->CreateUser($_POST);
				$SendNotification = $Admin->SendNewUserGreeting($_POST['username'],' http://'.$_SERVER['HTTP_HOST'].$Admin->Settings->DB['rooturi'].'admin/login');
				unset($_GET['action']);																		//forces list view after successful add/edit
			} else {
				$msg_create_error .= "<p>".$CONFIG['ERR_user_already_exists']."</p>";
			}
		}
		
		if($_POST['edit_user']){
			$EditUser = $Admin->ManageUsers->EditUser($_POST);
			if($Authenticate->User->GetUserLevel() == 2) {unset($_GET['action']);}			   		 //forces list view after successful add/edit if allowed
		}
	}
}
	
	
//========================================================================================================================================================
if($_GET['action'] == 'create') {																									//SHOW CREATE FORM
	if($msg_create_error != ''){echo "<div class='info_block'>".$msg_create_error."</div>";}
?>
<form name="create_user" action="<?=$URI?>?<?=$_SERVER['QUERY_STRING']?>" method="post" id="form_check" class="no_style">
    <input type="hidden" name="create_user" value="true" />
	<table>
    <tr>
    	<td width="150" class="align_right"><label for="fullname">Full Name:</label></td>
        <td width="270"><p><input type="text" name="fullname" value="<?=$_POST['fullname']?>" tabindex="1" maxlength="255" class="validate['required'] text-input" /></p></td>
        <td></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="username">Username:</label></td>
        <td><p><input type="text" name="username" value="<?=$_POST['username']?>" tabindex="2" maxlength="255" class="validate['required'] text-input" /></p></td>
        <td></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="password">Password:</label></td>
        <td><p><input type="text" name="password1" value="<?=$_POST['password1']?>" tabindex="3" maxlength="255" class="validate['required'] text-input" /></p></td>
        <td></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="password">Confirm Password:</label></td>
        <td><p><input type="text" name="password2" value="<?=$_POST['password2']?>" tabindex="4" maxlength="255" class="validate['required'] text-input" /></p></td>
        <td></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="email">Email Address:</label></td>
        <td><p><input type="text" name="email" value="<?=$_POST['email']?>" tabindex="5" maxlength="255" class="validate['email'] text-input" /></p></td>
        <td><span class="description">This address is used for admin purposes, like new user notification.</span></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="level">Account Type:</label></td>
        <td><p><select name="level" tabindex="6">
                <option value="1" selected="selected">User</option>
                <option value="2" >Administrator</option>
              </select></p>
		</td>
        <td></td>
    </tr>
    </table>
    <hr />
    <div class="block">
        <a href="<?=$URI?>?p=users&sub=view all" rel="p=users&sub=view all" class="buttonleft red ajax" tabindex="7">Cancel</a>
        <input type="submit" name="bttn_submit" value="Create" class="buttonright green" tabindex="8" />
    </div>
</form>




<?php
//===========================================================================================================================================================
} else if($_GET['action'] == 'edit' && $_GET['id']) {																					//EDIT A USER           	   
	if($msg_create_error != ''){echo "<div class='info_block'>".$msg_create_error."</div>";}									//display error message
	$Profile = $Admin->ManageUsers->GetUserProfileByID($_GET['id']);
	
	$URI = ($Authenticate->User->GetUserLevel() == 2) ? $URI.'?p=users&amp;sub=view all' : $URI.'?p=users&action=edit&amp;id='.$Authenticate->User->GetUserID();
?>
<form name="edit_user" action="<?=$URI?>" method="post" id="form_check" class="no_style">    
    <input type="hidden" name="id" value="<?=$Profile['id']?>" />
    <input type="hidden" name="edit_user" value="true" />
	<table>
    <tr>
    	<td width="150" class="align_right"><label for="fullname">Full Name:</label></td>
        <td width="270"><p><input type="text" name="fullname" value="<?=$Profile['fullname']?>" tabindex="1" maxlength="255" class="validate['required'] text-input" /></p></td>
        <td></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="username">Username:</label></td>
        <td><p><input type="text" name="username" value="<?=$Profile['username']?>" tabindex="2" maxlength="255" class="validate['required'] text-input" /></p></td>
        <td></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="password">Password:</label></td>
        <td><p><input type="password" name="password1" value="<?=$Profile['password']?>" tabindex="3" maxlength="255" class="validate['required'] text-input" /></p></td>
        <td></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="password">Confirm Password:</label></td>
        <td><p><input type="password" name="password2" value="<?=$Profile['password']?>" tabindex="4" maxlength="255" class="validate['required'] text-input" /></p></td>
        <td></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="email">Email Address:</label></td>
        <td><p><input type="text" name="email" value="<?=$Profile['email']?>" tabindex="5" maxlength="255" class="validate['email'] text-input" /></p></td>
        <td><span class="description">This address is used for admin purposes, like new user notification.</span></td>
    </tr>
    <tr>
    	<td class="align_right"><label for="level">Account Type:</label></td>
        <td>
        <?php if($Authenticate->User->GetUserLevel() == 2){ ?>
        	<p><select name="level" tabindex="6">
                <option value="1" <?=($Profile['level'] == 1) ? "selected='selected'" : ""?>>User</option>
                <option value="2" <?=($Profile['level'] == 2) ? "selected='selected'" : ""?>>Administrator</option>
              </select></p>
        <?php } else { ?>
        	<p><strong>Standard User</strong></p>
        <?php } ?>
		</td>
        <td></td>
    </tr>
    </table>
    <hr />
    <div class="block">
        <a href="<?=$URI?>?p=users&sub=view all" rel="p=users&sub=view all" class="buttonleft red ajax" tabindex="7">Cancel</a>
        <input type="submit" name="bttn_submit" value="Save" class="buttonright green" tabindex="8" />
    </div>
</form>



<?php 
//==========================================================================================================================================================
} else { 
$RESULTS = $Admin->ManageUsers->GetUsers($_GET['role']);																				//LIST ALL USERS
?>
    <div class="block">
        <?=$lnk_all_users?>
        <b class="spacer">|</b>
        <?=$lnk_administrator?>
        <b class="spacer">|</b>
        <?=$lnk_user?>  
    </div>
        <form name="delete_users" action="<?=$URI?>?p=users&sub=view all" method="post">
        <input type="hidden" name="action" value="delete" />
        <div id="content">
            <table>
                <thead>
                	<tr>
                    	<th><img src="images/uncheck.jpg" id="ucuc" alt="" /></th>
                    	<th>Fullname</th>
                    	<th>Username</th>
                    	<th>Email</th>
                    	<th>Role</th>
                    	<th></th>
                    </tr>
                </thead>
                <tbody>
                    <?=$RESULTS?>
                </tbody>
            </table>
            <?php 
				echo $Admin->ManageUsers->Paginator->Display();
				if($message != ''){echo "<div class='info_block'>".$message."</div>";} 
			?>
        </div>
    <div class="block">
        <a href="<?=$URI?>?p=users&amp;action=create" rel="p=users&amp;action=create" class="buttonleft red ajax" tabindex="4">Create</a>
        <input type="submit" value="Delete" class="buttonright green dialog" onclick="return Confirm('<?=$CONFIG['MSG_delete_confirmation']?>');" tabindex="5" />
    </div>
    </form>
<?php } ?>