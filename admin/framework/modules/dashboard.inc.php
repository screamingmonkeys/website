<?php
//======================================================================
//Nichols Administration System
//Dashboard Module
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.02.08
//
//Copyright 2008 - The Nichols Company
//======================================================================
?>
<!--
<ul class="grid">
    <li>
    	<a href="<?=$URI?>?p=manage&sub=pages&action=create" tabindex="1">
    		Write a New Page
        </a>
    </li>
    <li>
    	<a href="<?=$URI?>?p=users&action=edit&id=<?=$Authenticate->User->GetUserID()?>" tabindex="2">
    		Edit Your Profile
        </a>
    </li>
    <li>
    	<a href="<?=$URI?>#" tabindex="3">
    		
        </a>
    </li>
    <li>
    	<a href="<?=$URI?>#" tabindex="4">
    		
        </a>
    </li>
    <li>
    	<a href="<?=$URI?>#" tabindex="5">
    		
        </a>
    </li>
    <li>
    	<a href="<?=$URI?>#" tabindex="6">
    		
        </a>
    </li>
</ul>
<hr style="clear:both;" />
-->

<?php 
	//List Modules in Database
	$ListModules = $Admin->ManageModules->ListModules(); 
	
	if($ListModules != "") { 
?>
<table>
    <thead>
    	<tr>
        	<th colspan="2">Installed Modules</th>
        	<th>Version</th>
        </tr>
    </thead>
    <tbody>
        <?=$ListModules?>
    </tbody>
    <tfoot>
    	<tr><td colspan="4"><strong>Total Installed:</strong> <?=$Admin->ManageModules->GetCountActive()?> modules</td></tr>
    </tfoot>
</table>
<?php } ?>