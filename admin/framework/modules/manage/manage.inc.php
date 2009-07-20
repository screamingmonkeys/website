<?php
//======================================================================
//Nichols Administration System
//Manage Site Module
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.09.08
//
//Copyright 2008 - The Nichols Company
//======================================================================
require_once('framework/php/classes/manage.class.php');

//Instantiate
$Manage = new Manage($Admin);
$Manage->Paginator->SetRecordsPerPage(5);
$Manage->Paginator->SetMaxPagesShown(5);
$Manage->Paginator->SetRecordParams($_SERVER['QUERY_STRING']);
$Manage->Paginator->SetCurrentPage($_GET['offset']);

//ACTIONS
if($_POST['action'] == "delete") {
	if(isset($_POST['id'])) {
		foreach($_POST['id'] as $ID) {
			if(is_numeric($ID)) {
				if($_GET['sub'] == 'pages') {
					$delete = $Manage->Delete('pages', $ID);																			//delete a page
				} else {
					$delete = $Manage->Delete('sections', $ID);																			//delete a section
				}
				$message = "<p>".$CONFIG['MSG_items_deleted']."</p>";
			}
		}
	} else {
		$message = "<p>".$CONFIG['ERR_none_selected']."</p>";
	}
}


																
if($_POST['action'] == 'create' || $_POST['action'] == 'edit') {																		//CREATE OR EDIT
	if($_GET['sub'] == 'pages') {																										//PAGE
		$check1 = false;
		$check2 = false;
		$msg_create_error = "";
		
		if($_POST['date'] == '' && $_POST['title'] == '' && $_POST['content'] == '') {
			$check1 = false;
			$check2 = false;
			$msg_create_error .= "<p>".$CONFIG['ERR_empty_form']."</p>";
		} else {
			if($_POST['date'] != '') {
				$check1 = true;
			} else {
				$check1 = false;
				$msg_create_error .= "<p>".$CONFIG['ERR_empty_date']."</p>";
			}
			if($_POST['title'] != '') {
				$check2 = true;
			} else {
				$check2 = false;
				$msg_create_error .= "<p>".$CONFIG['ERR_empty_title']."</p>";
			}
		}
	
		//send data and create
		if($check1 && $check2) {
			if($_POST['action'] == 'create') {
				$create = $Manage->CreatePage($_POST);
			} else {
				$edit = $Manage->EditPage($_POST);
			}
			$display_pages = true;
		} else {
			$display_pages = false;
		}
	} else {																														//SECTION
		$msg_create_error = "";
		if($_POST['name'] != "") {
			if($_POST['action'] == 'create') {
				$create = $Manage->CreateSection($_POST);
			} else {
				$edit = $Manage->EditSection($_POST);
			}
			$display_sections = true;
		} else {
			$display_sections = false;
			$msg_create_error .= "<p>".$CONFIG['ERR_empty_section_name']."</p>";
		}
	}
}
?>






<?php if($_GET['sub'] == 'pages' && ($_GET['action'] == 'create' || $_GET['action'] == 'edit') && !$display_pages) {				//CREATE OR EDIT PAGE 
		   if($msg_create_error != '') {echo "<div class='info_block'>".$msg_create_error."</div>";} 		
				   
		   if($_GET['action'] == 'create') {
			   $mode = 'create';
			   $DATE = isset($_POST['date']) ? $_POST['date'] : date("m/d/Y");
			   $confirm = 'Create';
		   } else {
			   $page = $Manage->GetPage($_GET['pid']);
			   $mode = 'edit';
			   $pid = '&amp;pid='.$_GET['pid'];
			   $DATE = !isset($_POST['date']) ? $Admin->DB->ConvertSQLDate($page['date'], "short", "from") : $_POST['date'];
			   $confirm = 'Save';
		   }
		   
		   if(($Manage->Count('id', 'sections', null) == 0) && ($Manage->Settings->DB['use_sections'] == 'true')) {
				echo "<p style='margin-bottom:200px;'>".$CONFIG['ERR_must_create_section_first']."</p>";
		   } else {
?>
<form name="create" action="<?=$URI?>?p=manage&amp;sub=pages&amp;action=<?=$mode.$pid?>" method="post" class="no_style left">
	<table>
    	<tr>
        	<td class="align_right"><label for="date">Date</label></td>
            <td><p style="text-align:left;padding-left:23px;"><input type="text" name="date" id="date" tabindex="1" maxlength="10" value="<?=$DATE?>" /></p></td>
            <td width="60%"><span class="description">Please use the MM/DD/YYYY format</span></td>
        </tr>
    	<tr>
        	<td class="align_right"><label for="title">Title</label></td>
            <td><p style="text-align:left;padding-left:23px;"><input type="text" name="title" tabindex="2" maxlength="255" value="<?=($page['title'] != '') ? $page['title'] : $_POST['title']?>" /></p></td>
            <td></td>
        </tr>
    	<tr>
        	<td class="align_right"><label for="author">Author</label></td>
            <td><p style="text-align:left;padding-left:23px;"><strong><?=$Authenticate->User->GetFullname()?></strong></p></td>
            <td></td>
        </tr>
        <?php if($Manage->Settings->DB['use_sections'] == 'true') { ?>
    	<tr>
        	<td class="align_right"><label for="section">Section</label></td>
            <td>
            	<p style="text-align:left;padding-left:23px;"><select name="section" tabindex="3">
            		<?=$Manage->GenerateSectionDropdown($_GET['sid'])?>
                </select></p>
            </td>
            <td></td>
        </tr>
        <?php } ?>
    	<tr>
        	<td class="align_right"><label for="status">Status</label></td>
            <td>
            	<p style="text-align:left;padding-left:23px;">
            	<select name="status" tabindex="4">
                	<option value="0" <?=($page['status'] == '0') ? 'selected="selected"' : ''?>>Draft</option>
                    <option value="1" <?=($page['status'] == '1') ? 'selected="selected"' : ''?>>Published</option>
                </select></p>
            </td>
            <td><span class="description">Pages are created as drafts by default</span></td>
        </tr>
        <tr><td colspan="3"><hr /></td></tr>
        <tr><td colspan="3"><label for="content"><h2>Content</h2></label></td></tr>
        <tr>
            <td colspan="3"><p><textarea name="content" tabindex="5" id="mooEditor"><?=($page['content'] != '') ? $page['content'] : $_POST['content']?></textarea></p></td>
        </tr>
        <!--
        <tr><td colspan="3"><label for="content"><h2>Add Images</h2></label></td></tr>
        <tr>
        	<td class="align_right"><label for="image">Image</label></td>
            <td><p style="text-align:left;padding-left:23px;"><input type="file" name="image" tabindex="2" maxlength="255" value="<?=($page['image'] != '') ? $page['image'] : $_POST['image']?>" /></p></td>
            <td></td>
        </tr>
        -->
        <tr><td colspan="3"></td></tr>

    </table>
    <div class="block">
    	<input type="hidden" name="id" value="<?=$_GET['pid']?>" />
    	<input type="hidden" name="action" value="<?=$mode?>" /> 
        <input type="hidden" name="published_by" value="<?=$Authenticate->User->GetUserID()?>" />
        <a href="<?=$URI?>?p=manage&sub=pages" rel="p=manage&sub=pages" class="buttonleft red ajax" tabindex="6">Cancel</a>
        <input type="submit" name="bttn_submit" value="<?=$confirm?>" class="buttonright green" tabindex="7" />
    </div>
</form>
<?php } ?>








<?php } else if($_GET['p'] == 'manage' && $_GET['sub'] == 'pages') {																	//LIST PAGES ?>
<form name="delete" action="<?=$URI.'?'.$_SERVER['QUERY_STRING']?>" method="post">
    <input type="hidden" name="action" value="delete" />
    <table>
        <thead>
        	<tr>
        		<th><img src="images/uncheck.jpg" id="ucuc" alt="" /></th>
            	<th>Date</th>
            	<th>Title</th>
            	<th>Author</th>
    <?php if($Manage->Settings->DB['use_sections'] == 'true') { echo "<th>Section</th>"; } ?>
            	<th>Status</th>
            	<th></th>
            </tr>
        </thead>
        <tbody>
            <?=$Manage->ListPages()?>
        </tbody>
      </table>
		<?php
			echo $Manage->Paginator->Display();
			
			//Display Messages
	  		if($message != ''){echo "<div class='info_block'>".$message."</div>";} 
	  ?>
      <div class="block">
          <a href="<?=$URI?>?p=manage&amp;sub=pages&amp;action=create" rel="p=manage&amp;sub=pages&amp;action=create" class="buttonleft green ajax" tabindex="4">Create</a>
          <input type="submit" value="Delete" class="buttonright red dialog" onclick="return Confirm('<?=$CONFIG['MSG_delete_confirmation']?>');" tabindex="5" />
      </div>
</form>
<?php } ?>









<?php if($_GET['sub'] == 'sections' && ($_GET['action'] == 'create' || $_GET['action'] == 'edit') && !$display_sections) {			//CREATE OR EDIT SECTION 
		   if($msg_create_error != '') {echo "<div class='info_block'>".$msg_create_error."</div>";} 		
				   
		   if($_GET['action'] == 'create') {
			   $mode = 'create';
			   $confirm = 'Create';
		   } else {
			   $section = $Manage->GetSection($_GET['id']);
			   $mode = 'edit';
			   $sid = '&amp;sid='.$_GET['sid'];
			   $confirm = 'Save';
		   }
?>
<form name="create" action="<?=$URI?>?p=manage&amp;sub=sections&amp;action=<?=$mode.$sid?>" method="post" class="no_style">
	<table>
    	<tr>
        	<td><label for="title">Name</label></td>
            <td><p><input type="text" name="name" tabindex="1" maxlength="255" value="<?=($section['name'] != '') ? $section['name'] : $_POST['name']?>" /></p></td>
            <td></td>
        </tr>
    </table>
    <br /><br />
    <br /><br />
    <div class="block">
    	<input type="hidden" name="id" value="<?=$_GET['id']?>" />
    	<input type="hidden" name="action" value="<?=$mode?>" /> 
        <a href="<?=$URI?>?p=manage&sub=sections" rel="p=manage&sub=sections" class="buttonleft red ajax" tabindex="2">Cancel</a>
        <input type="submit" name="bttn_submit" value="<?=$confirm?>" class="buttonright green" tabindex="3" />
    </div>
</form>









<?php 																																	//LIST SECTIONS
} else if($_GET['p'] == 'manage' && $_GET['sub'] == 'sections') {
?>
<form name="delete" action="<?=$URI.'?'.$_SERVER['QUERY_STRING']?>" method="post">
<input type="hidden" name="action" value="delete" />
<?php if($Manage->Settings->DB['use_sections'] == 'true') { ?>
    <table>
        <thead>
        	<tr>
        		<th><img src="images/uncheck.jpg" id="ucuc" alt="" /></th>
            	<th>Name</th>
            	<th>Number of Pages</th>
            	<th></th>
           	</tr>
        </thead>
        <tbody>
			<?=$Manage->ListSections()?>
        </tbody>
      </table>
	<?php
        } else {
            echo "<p class='align_left' style='margin-bottom:350px;'>".$CONFIG['MSG_please_turn_feature_on']."</p>";	
        }
    ?>
	<?php 
		echo $Manage->Paginator->Display();
		if($message != ''){echo "<div class='info_block'>".$message."</div>";}
   		if($Manage->Settings->DB['use_sections'] == 'true') {
	?>
    <div class="block">
        <a href="<?=$URI?>?p=manage&amp;sub=sections&amp;action=create" rel="p=manage&amp;sub=sections&amp;action=create" class="buttonleft green ajax" tabindex="4">Create</a>
        <input type="submit" value="Delete" class="buttonright red dialog" onclick="return Confirm('<?=$CONFIG['MSG_delete_confirmation']?>');" tabindex="5" />
    </div>
    <?php } ?>
</form>





<?php
} else if($_GET['p'] == 'manage' && !isset($_GET['sub'])){
?>
<table>
	<thead>
		<tr>
			<th colspan="2">Statistics at a Glance</th>
		</tr>
	</thead>
	<tbody>
		<?php if($Manage->Settings->DB['use_sections'] == 'true') { ?>
		<tr>
			<td>Total Number of Site Sections:</td>
			<td><?=$Admin->DB->Count("sections.id", "sections", null)?></td>
		</tr>
		<?php } ?>
		<tr class="odd">
			<td>Total Number of Published Pages:</td>
			<td><?=$Admin->DB->Count("pages.id", "pages", "pages.status = 1")?></td>
		</tr>
		<tr>
			<td>Total Number of Draft Pages:</td>
			<td><?=$Admin->DB->Count("pages.id", "pages", "pages.status = 0")?></td>
		</tr>
	</tbody>
</table>
<?php } ?>