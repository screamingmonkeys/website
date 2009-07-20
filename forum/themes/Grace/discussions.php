<?php
// Note: This file is included from the library/Vanilla/Vanilla.Control.DiscussionGrid.php class.

echo '
	<h1>
		'.$this->Context->PageTitle.'
	</h1>
	<div class="TopOfPage"><a href="#pgbottom"><img src="themes/Grace/styles/default/bottom-of-page.gif" alt="Bottom of page arrow" title="Bottom of page" width="22" height="22" /></a></div>
	'.$this->PageJump.'
	<div class="PageInfo">
		<p>'.($PageDetails == '' ? $this->Context->GetDefinition('NoDiscussionsFound') : $PageDetails).'</p>
		'.$PageList.'
</div>
<div id="ContentBody">
	<ol id="Discussions">';

$Discussion = $this->Context->ObjectFactory->NewContextObject($this->Context, 'Discussion');
$FirstRow = 1;
$CurrentUserJumpToLastCommentPref = $this->Context->Session->User->Preference('JumpToLastReadComment');
$DiscussionList = '';
$ThemeFilePath = ThemeFilePath($this->Context->Configuration, 'discussion.php');
$Alternate = 0;
while ($Row = $this->Context->Database->GetRow($this->DiscussionData)) {
   $Discussion->Clear();
   $Discussion->GetPropertiesFromDataSet($Row, $this->Context->Configuration);
   $Discussion->FormatPropertiesForDisplay();
	// Prefix the discussion name with the whispered-to username if this is a whisper
   if ($Discussion->WhisperUserID > 0) {
		$Discussion->Name = @$Discussion->WhisperUsername.': '.$Discussion->Name;
	}

	// Discussion search results are identical to regular discussion listings, so include the discussion search results template here.
	include($ThemeFilePath);
	
   $FirstRow = 0;
	$Alternate = FlipBool($Alternate);
}
echo $DiscussionList.'
	</ol>
</div><div class="ClearBoth"></div>';
if ($this->DiscussionDataCount > 0) {
   echo '<div class="PageInfo">
			<p>'.$pl->GetPageDetails($this->Context).'</p>
			'.$PageList.'
		</div><div class="BottomClear">&nbsp;</div>
		<div class="TopOfPage"><a id="TopOfPage" href="'.GetRequestUri().'#pgtop"><img src="themes/Grace/styles/default/top-of-page.gif" alt="Top of page arrow" title="Top of page" width="22" height="22" /></a></div>
	';
}
?>