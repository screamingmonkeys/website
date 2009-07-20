<?php 
//======================================================================
//Nichols Administration System
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.07.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

//requirements
require_once('framework/php/security.inc.php');
require_once('framework/php/page_logic.inc.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$Admin->GetCompanyName()?> - Website Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="Nichols Admin - An custom administration system built for our clientele." />
<meta name="copyright" content="(c)<?=date("Y")?> The Nichols Company" /> 
<meta name="author" content="Tim Novinger, tnovinger@nichols-co.com" /> 
<meta name="web author" content="Tim Novinger, tnovinger@nichols-co.com" /> 
<meta name="reply-to" content="tnovinger@nichols-co.com" />
<link rel="shortcut icon" type="image/gif" href="images/<?=strtolower(str_replace(" ", "_", $Admin->GetCompanyName()))?>.gif" />
<link rel="stylesheet" type="text/css" href="framework/css/style.css" />
<link rel="stylesheet" type="text/css" href="framework/css/slimbox.css" />
<link rel="stylesheet" type="text/css" href="framework/css/formcheck.css" />
<link rel="stylesheet" type="text/css" href="framework/css/theme_<?=strtolower(str_replace(" ", "_", $Admin->GetCompanyName()))?>.css" />
<!-- CHECK IF BROWSER IS IE6 OR EARLIER -->
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="framework/css/ie8.css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="framework/css/ie7.css" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="framework/css/ie6.css" /><![endif]-->
</head>
<body id="<?=$PAGE?>">
    <div id="top">
        <p id="header">website: <span><?=ucwords($Admin->GetCompanyName())?></span></p>
        <p id="logout"><?=ucwords($Authenticate->User->GetFullname());?> <span>{<a href="<?=$URI?>?l=1">sign out</a>}</span></p>
        <?php require_once('framework/php/menu.inc.php'); ?>
    </div>		
    <div id="bottom">
        <div id="main_content">
        	<h1><?=ucwords($HEADER)?></h1>
        	<hr />
        	<?php	
				//LOAD CONTENT
				if(isset($_GET['p'])) {
					if($BASE) {
						if($_GET['p'] == 'settings') {																	//load base settings page
							require_once('framework/modules/'.$_GET['sub'].'_settings.inc.php');
						} else {																						//load base modules
							require_once('framework/modules/'.$_GET['p'].'.inc.php');
						} 
					} else {
						if($_GET['p'] == 'settings' && isset($_GET['sub'])) {											//load extra settings page
							if(in_array($_GET['sub'], $Admin->ManageModules->GetActiveModules())) {
								require_once('framework/modules/'.$_GET['sub'].'/settings.inc.php');
							} else {
								echo "<p style='padding-bottom:350px;'>".$CONFIG['ERR_inactive']."</p>";
							}
						} else {
							if(in_array($_GET['p'], $Admin->ManageModules->GetActiveModules())) {						
								require_once('framework/modules/'.$_GET['p'].'/'.$_GET['p'].'.inc.php');				//load extra modules
							} else {
								echo "<p style='padding-bottom:350px;'>".$CONFIG['ERR_inactive']."</p>";
							}
						}
					}
				} else {																								//otherwise load default dashboard
					require_once('framework/modules/dashboard.inc.php');
				}
			?>
        </div>
        <div id="side_info">
        	<p><a href="<?=$Admin->Settings->DB['website']?>" target="_blank">view the site</a></p>
        </div>
        <p id="footer">&#169; <?=date('Y')?> The Nichols Company. All rights reserved.</p>
    </div> 
    
    
    <!-- ========================================================================
	     Load Javascript and Initialize
	     ======================================================================== -->
	<script type="text/javascript" src="framework/js/mootools-1.2-full.js"></script>
	<script type="text/javascript" src="framework/js/enhancements.js"></script>  
	<script type="text/javascript" src="framework/js/formcheck.js"></script>
    <script type="text/javascript">
    //========================================================================
	//Fire listener scripts
	//========================================================================
	window.addEvent('domready', function(){
		var AJAX = new ajaxListener({											//Ajax Listener script, ajaxifies links and forms
			link_class: '.ajax', 
			form_class: '.ajax_send',
			target: '<?=$PAGE?>',												//body ID
			opacity: 0.8,
			displayLoadingMsg: true,
			loadingMsg: 'please wait',
			loadingMsgBgColor: '#453621',
			loadingMsgPosition: 'bottom'
		});  																	//Generic AJAX functionality (add rel="uri" and class="ajax" to links)
		checkAll.initialize('ucuc', 'images');									//Check all boxes in a table grid using Javascript
		Slimbox.scanPage = function() {											//Slimbox
			var links = $$("a").filter(function(el) {
				return el.rel && el.rel.test(/^lightbox/i);
			});
			$$(links).slimbox({}, null, function(el) {
				return (this == el) || ((this.rel.length > 8) && (this.rel == el.rel));
			});
		};
		Slimbox.scanPage();														//Slimbox
		var Message = new DisplayMessage({										//mooDisplayMessage
						element:        '.info_block',
						highlight: 		true,
						vanish:			true,
						delay:			4000,
						duration: 		500,
						fadeto: 		0.3,
						highlightWidth: 3
		});
		var Editor = new mooEditor();											//Content WYSIWYG editor
		var highlight = new highlightListener({			  					    //element Highlight listener
						classname: 'highlight', 
						color: 	   '#FF9'
		});
		var myAccordion = new Accordion($$('.toggler'), $$('.stretcher'), {alwaysHide:true, show:-1});  //Instaniate Accordion for Help Pages
		
		$each($$('#menu a'), function(el) {										//fade main menu link states fade into one another
			var original = el.getStyle('color');
			var morph = new Fx.Morph(el,{ 'duration':'300', link:'cancel' });
			el.addEvents({
				'mouseenter' : function() { morph.start({ 'color':'#fff' }) },
				'mouseleave' : function() { morph.start({ 'color': original }) }
			});
		});
		
        var myCheck = new FormCheck('form_check');								//form validation
	});	   
    </script>  
</body>
</html>