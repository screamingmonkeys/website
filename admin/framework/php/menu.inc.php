<div id="menu">
                <ul id="m_left">
                	<li id="m_dashboard"><a href="<?=$URI?>">dashboard</a></li>
                    <?=$Admin->ManageModules->GetModuleRequirement('MENU')?>
                </ul>
                 <ul id="m_right">
           			 <li id="m_help"><a href="<?=$URI?>?p=help">help</a></li>
					<?php if($Authenticate->User->GetUserLevel() == 2){ 													//show all users if admin account  ?>
                    	<li id="m_users"><a href="<?=$URI?>?p=users&amp;sub=view all">users</a></li>
                    <?php } else {																							//otherwise show only your profile ?>
                  	  	<li id="m_users"><a href="<?=$URI?>?p=users&action=edit&id=<?=$Authenticate->User->GetUserID()?>">my profile</a></li>                    
                    <?php } ?> 
                    
                     <?php if($Authenticate->User->GetUserLevel() == 2){ 													//show settings if admin account  ?>
                        <li id="m_settings"><a href="<?=$URI?>?p=settings&amp;sub=general">settings</a></li>
                    <?php }																									//otherwise don't ?>                
                 </ul>
            </div>
            <div id="sub_menu">
            	<ul>
            	<?php	
					switch($_GET['p']){ 
							/*
							case 'manage' : 
								echo "<li><a href='".$URI."?p=manage&amp;sub=sections' rel='p=manage&amp;sub=sections' class='ajax'>sections</a></li> \n";
								echo "<li><a href='".$URI."?p=manage&amp;sub=pages' rel='p=manage&amp;sub=pages' class='ajax'>pages</a></li> \n";
								break;
							*/
							case 'users' :
								if($Authenticate->User->GetUserLevel() == 2){
									echo "<li><a href='".$URI."?p=users&amp;sub=view all' class='ajax'>view all</a></li> \n";
									echo "<li><a href='".$URI."?p=users&amp;action=create' class='ajax'>create</a></li> \n";
									echo "<li><a href='".$URI."?p=users&action=edit&id=".$Authenticate->User->GetUserID()."' class='ajax'>my profile</a></li> \n";
								}
								break;
							case 'settings' :
								if($Authenticate->User->GetUserLevel() == 2){		
									echo "<li><a href='".$URI."?p=settings&amp;sub=general' class='ajax'>general</a></li> \n";
									echo $Admin->ManageModules->GetModuleRequirement('SETTINGS');
								}
								break;
							default :
								echo $Admin->ManageModules->GetModuleRequirement('SUB_MENU');
								break;
					}
				?>
                </ul>
            </div>
