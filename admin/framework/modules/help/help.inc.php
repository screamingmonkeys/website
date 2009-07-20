<?php if(!$_GET['sub']){ ?>
<h3>Have a question about this administration system?</h3>
<p class="headline">Certain help topics are available based upon which modules have been installed. Use the sub-menu navigation above to find help for your particular problem. For general help topics, please click on the links below.</p>
<p class="headline">If you still can't find a solution to your problem, feel free to <a href="mailto:tnovinger@nichols-co.com">email us</a> for further assistance.</p>

<h2 style="padding-top:50px;">General Topics</h2>
<hr />
<dl id="accordion">
	<dt class="toggler">&bull; What is the <strong>Dashboard</strong>?</dt>
	<dd class="stretcher"><p>The <a href="<?=$Admin->Settings->DB['rooturi']?>admin">Dashboard</a> displays important statistical information about your administration system, such as which modules are installed.</p><br /></dd>
	
	<dt class="toggler">&bull; Adding a new user account</dt>
	<dd class="stretcher"><p>To add a new user account, first click the <strong>users</strong> tab. Then click the button in the lower left corner of the user table labeled <strong>Create</strong>. After filling in the new user's information and selecting the appropriate account type, click the <strong>Create</strong> in the lower right corner to submit the form.</p><p class="note">Please Note: this feature is only available to administrator accounts.</p><br /></dd>
	
	<dt class="toggler">&bull; Deleting a user account</dt>
	<dd class="stretcher"><p>To delete a user account, first click the <strong>users</strong> tab. Then select each user account(s) that you would like to delete and click the <strong>Delete</strong> button in the lower right. A warning will then prompt you, asking if you're absolutely sure. To continue to permanently delete the accounts, click <strong>Yes</strong>.</p><p class="note">Please Note: this feature is only available to administrator accounts.</p><br /></dd>
	
	<dt class="toggler">&bull; How to quickly edit your profile</dt>
	<dd class="stretcher"><p><u>Standard user account:</u> Click the <strong>My Profile</strong> tab located in the upper right area of the navigation bar.</p><p><u>Administrator Account:</u> Click the <strong>users</strong> tab and then select <strong>my profile</strong>.</p><br /></dd>
	
	<dt class="toggler">&bull; Resending account information</dt>
	<dd class="stretcher"><p>If a user has forgotten his or her log-in credentials, he or she always has the ability to retrieve the credentials using the built-in retrieval process on the log-in page. However, as an administrator, it's sometimes more convenient to do this <em>for</em> one of your users.</p><p>To resend a user's credentials, simply click on his or her e-mail address while in the <strong>users</strong> tab</p><p class="note">Please Note: this feature is only available to administrator accounts.</p><br /></dd>	
	
	<dt class="toggler">&bull; The differences between Standard User and Administrator accounts</dt>
	<dd class="stretcher"><p>A standard user account has limited access to the administration system and therefore can't do as much as an administrator account. Key functionality that has been removed from Standard User accounts is the ability to change system settings and to manage user accounts. Additional restrictions are determined by which modules are installed in the system.</p><p>If any further restrictions are required of your users, please <a href="mailto:tnovinger@nichols-co.com">contact</a> The Nichols Company.</p><br /></dd>
	
	<dt class="toggler">&bull; What does the <strong>Remember Me</strong> option do on the log-in page?</dt>
	<dd class="stretcher"><p>This option is a great time saver. It allows the administrative system to write a "cookie" to your computer that contains your log-in information. The next time you return to log in, the system will read this cookie and automatically fill in the log-in form, essentially "remembering" your user account.</p><br /></dd>
	
	<dt class="toggler">&bull; What is the <strong>Root Uniform Resource Indentifer (URI)</strong> setting?</dt>
	<dd class="stretcher"><p>This setting is <strong>very</strong> important and generally is not meant to be touched. It changes the path of every internal and external link within the administration system. This is very useful when moving the administration system to a new location on a Web server. An example of that is when moving administration system from a development server to a live server. This setting requires any text that is part of the systems URI <em>after</em> the domain before "admin".</p><p><u>For example:</u> in http://www.yourdomain.com<strong style="font-size:14px;">/folder1/folder2/</strong>admin the bolded text would be used.</p><p class="note">Please Note: this feature is only available to administrator accounts.</p><br /></dd>
</dl>
<? } else { 
		require_once('framework/modules/'.$_GET['sub'].'/help.inc.php');
   }
?>