<?php	
    //requirements
	require_once('admin/framework/php/config.inc.php');
	require_once('admin/framework/php/classes/settings.class.php');
	require_once('admin/framework/php/classes/display.class.php');
	require_once('framework/php/contact.inc.php');
	
	$Display = new Display($CONFIG, "manage");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="distribution" content="global" />
<meta name="revisit-after" content="20 days" />
<meta name="robots" content="all,follow,index" />
<meta name="author" content="Tim Novinger, James Mitchell" />
<meta name="owner" content="The Screaming Monkeys Web Guild" />
<meta name="verify-v1" content="qxlqr4BDbtzi2Y22mHfgeci6UJTmvbxMO8aZLWjm16o=" />
<meta name="copyright" content="&#169; 2008 Screaming Monkeys Web Guild www.screamingmonkeys.org" />
<meta name="keywords" content="fort wayne, indiana, web design, web development, guild, group, creative, design, social, organization, meetup, geekup, meet-up, geek-up, visual design, php, asp.net, ruby on rails, javascript, graphic design, geeks, get together, gathering, technology, college, students, fort, wayne, the fort, ft wayne, web professionals, dunkin, coldwater, coffee donuts, casual" />
<meta name="description" content="Screaming Monkeys Web Guild is group which holds re-occuring events in Fort Wayne, Indiana where like-minded web professionals (designers, developers, students, etc) can meet up to talk shop, share ideas, and make connections." />
<meta name="abstract" content="The Screaming Monkeys Web Guild" />
<meta name="title" content="The Screaming Monkeys Web Guild" />

<title>The Screaming Monkeys Web Guild | Fort Wayne, IN</title>

<link href="images/favicon.ico" rel="icon" />
<link href="framework/css/style.css" rel="stylesheet" type="text/css" />    
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="framework/css/ie7.css" /><![endif]--> 
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="framework/css/ie6.css" /><![endif]--> 
<?php 
	if(strstr($_SERVER['HTTP_USER_AGENT'], "Mobile") && strstr($_SERVER['HTTP_USER_AGENT'], "Safari")){
		echo '<link rel="stylesheet" type="text/css" href="'.$CONFIG['root_uri'].'framework/css/mobilesafari.css" />';
	};
?>
</head>



<!--
Hi curious person that is viewing source of my site.  Now that you are here, I know 
that you are an uber-nerd. Now I can talk about Star Wars and use my lame Han Solo
voice...see I'm doing it right now.  Ok, so you are a nerd and you like the codes...
the html codes to be exact.  Well, you are in a semi-decent area to learn.

Feel free to learn from, analyze, and/or use the techniques used in this site.  I'm
just a regular dude that learned css/xhtml/js the same exact way you are doing now.
However, please don't steal my codes line for line, it's bad Joo Joo and the Universe
will probably end up kicking your ass. And by Universe I of course am referring to
Chuck Norris.
-->



<body>
<p id="IE6_warning">We've detected that you're using Internet Explorer 6, a ridiculously outdated browser. It was released on August 27, 2001 and is currently <?=(date("Y") - 2001)?> years old. We no longer support IE6 and suggest that you <a href="http://www.getfirefox.com/" target="_blank">upgrade to Firefox.</a></p>
<div id="container">
  <div id="branding">
    <h1><a href="http://www.screamingmonkeys.org">Screaming Monkeys Web Guild</a></h1>
    <h2><a href="http://www.screamingmonkeys.org">The Boss</a></h2>
  </div>
  <div id="content-container">
		<div id="content-top"></div>  
		<div id="content">
			<ul id="socialplaces">
				<li><a href="http://twitter.com/statuses/user_timeline/16232049.rss" target="_blank" class="fade">RSS</a></li>
				<li><a href="http://www.twitter.com/screaminmonkeys" target="_blank" class="fade">TWITTER</a></li>
				<li><a href="http://www.new.facebook.com/home.php#/group.php?gid=26687578301&amp;ref=ts" target="_blank" class="fade">FACEBOOK</a></li>
				<li><a href="http://www.linkedin.com/groups?about=&amp;gid=904497&amp;trk=anet_ug_grppro" target="_blank" class="fade">LINKEDIN</a></li>
				<li><a href="http://www.flickr.com/groups/screamingmonkeys/" target="_blank" class="fade">FLICKR</a></li>
				<li><a href="http://www.youtube.com/user/screamingmonkeyswg" target="_blank" class="fade">YOUTUBE</a></li>
			</ul>
			
			<div class="slider-wrap">
				<div id="slider" class="csw">
					<div class="panelContainer">
						<?php
							//- mark HOME CONTENT
							$Request = isset($_GET['p']) ? $_GET['p'] : 'Home';
							$Page = $Display->Get("*", "pages", "WHERE title='".$Request."'");
	
							if($Page['status'] == 1){
						?>
						<div class="panel" title="home">
							<div class="wrapper">
								<?=$Display->Clean($Page['content'])?>
							</div>
						</div>
						<?php } ?>
						
						
						<?php 
							//- mark ABOUT CONTENT
							$Request = isset($_GET['p']) ? $_GET['p'] : 'About';
							$Page = $Display->Get("*", "pages", "WHERE title='".$Request."'");
	
							if($Page['status'] == 1){
						?>
						<div class="panel" title="about">
							<div class="wrapper">
								<?=$Display->Clean($Page['content'])?>
							</div>
						</div>
						<?php } ?>
						
						
						
						<?php 
							//- mark EVENTS CONTENT
							$Request = isset($_GET['p']) ? $_GET['p'] : 'Events';
							$Page = $Display->Get("*", "pages", "WHERE title='".$Request."'");
	
							if($Page['status'] == 1){
						?>
						<div class="panel" title="events">
							<div class="wrapper">
								<?=$Display->Clean($Page['content'])?>
							</div>
						</div>
						<?php } ?>
						
						<!-- !EMAIL LIST SIGNUP -->
						<div class="panel" title="signup">
							<div class="wrapper">
								<h1>~ get on our list ~</h1>
								<p>Fill out this form with your information and we'll send you cool stuff! Well not really, but you <strong>will</strong> be added to our email mailing list which I'm told is quite amazing.</p>
								<p>&nbsp;</p>
							 	<form action="http://screamingmonkeys.list-manage.com/subscribe/post" target="_blank" method="post">
            						<input type="hidden" name="u" value="786b0a330f13692db0e3df83e" />
            						<input type="hidden" name="id" value="ff4fc1d842" />
           								<table>
       										<tr align="left">
           										<td style="text-align:right;"><label>Email Address</label></td>
               									<td align="left"><input type="text" name="MERGE0" size="30" value="" /><strong>*</strong></td>
           									</tr>
        
       										<tr align="left">
           										<td style="text-align:right;"><label>First Name</label></td>
   	            								<td align="left"><input type="text" name="MERGE1" size="30" value="" /><strong>*</strong></td>
           									</tr>
        
           									<tr align="left">
           										<td style="text-align:right;"><label>Last Name</label></td>
       	        								<td align="left"><input type="text" name="MERGE2" size="30" value="" /></td>
           									</tr>
        
           									<tr align="left">
           										<td style="text-align:right;"><label>Twitter Screenname</label></td>	
           										<td align="left"><input type="text" name="MERGE3" size="30" value="" /></td>
           									</tr>
        									
        									<tr><td>&nbsp;</td></tr>
        									
       	    								<tr align="left">
           	    								<td style="text-align:right;"><label>Preferred Format</label></td>
           	    								<td align="center"><input type="radio" name="EMAILTYPE" value="html" checked="checked" class="radio" /><label>HTML</label>&nbsp; &nbsp;
                   										<input type="radio" name="EMAILTYPE" value="text" class="radio" /><label>Text</label>
               									</td>
           									</tr>
        
											<tr align="left">
												<td colspan="2" style="padding-top:20px;">
            										<input type="submit" class="submitbutton" value="signup" style="left:0px; width:60px;" />
            									</td>
            								</tr>
            							</table>
            					</form>
							</div>
						</div>
						
						<div class="panel" title="contact">
							<div class="wrapper">
								<?php if($_POST['submitted'] == "true" && $sent == true){ ?>
								<h1>~ we got it, thanks! ~</h1>
								<p>We appreciate your feedback, and we'll be in touch with you shortly.<br />
								Hope to see you at the next meetup!</p>
								<p>~ The Boss</p>
								<?php } else { ?>
								<?=$data?>
								<h1>~ have something to say? ~</h1>
								<form name="frmContact" method="post" action="index.php#4" id="frmContact">
									<table>
										<tr align="left">
											<td style="text-align:right;"><label for="name">Your name:</label></td>
											<td align="left"><input name="name" id="name" type="text" value="<?=$_POST['name']?>" /></td>
										</tr>
	
										<tr align="left">
											<td style="text-align:right;"><label for="company">Your company:</label></td>
											<td align="left"><input name="company" id="company" type="text" value="<?=$_POST['company']?>" /></td>
										</tr>
										
										<tr align="left">
											 <td style="text-align:right;"><label for="email">Your e-mail:</label></td>
											 <td align="left"><input name="email" id="email" type="text" value="<?=$_POST['email']?>" /></td>
										</tr>
	
										<tr align="left">
											 <td style="text-align:right;"><label for="url">Your web site:</label></td>
											 <td align="left"><input name="url" id="url" type="text" value="<?=$_POST['url']?>" /></td>
										</tr>
										<tr align="left">
											<td colspan="2" style="padding-top:10px;">
												<label for="message">Your message:</label><br />
												<textarea name="message" id="message" rows="5" cols="20"><?=$_POST['message']?></textarea>
												<input type="submit" name="submitbutton" class="submitbutton" value="send" />
											</td>
										</tr>
									</table>

									<input name="submitted" type="hidden" value="true" />
									<input name="validated" type="text" style="visibility:hidden;display:none;" value="" />	
								</form>
								<?php } ?>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div id="content-bottom"></div>
		<div id="copyright">
			<p>&#169; 2008-<?=date("Y")?> <a href="mailto:theboss@screamingmonkeys.org">The Screaming Monkeys Web Guild</a>. It's bad Joo Joo to steal our stuff, please don't.</p>
		</div>
  	</div>
</div>
<script src="framework/js/enhancements.js" type="text/javascript"></script>
<script type="text/javascript">
	jQuery(window).bind("load", function(){ jQuery("div#slider").codaSlider() });
	if (typeof(_gat) == "object") { 
		var pageTracker = _gat._getTracker("UA-5311875-1");
    	pageTracker._setDomainName("www.screamingmonkeys.org"); 
   	 	pageTracker._initData();
    	pageTracker._trackPageview();
	}
</script>	
</body>
</html>