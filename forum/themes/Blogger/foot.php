<?php
// Note: This file is included from the library/Vanilla/Vanilla.Control.Foot.php class.
// Edit your footer links and Please give me credit and keep my link at the bottom!

	echo '</div>
	<a id="pgbottom" name="pgbottom">&nbsp;</a>
	<div id="Bottom"></div></div>';
	echo '<div id="Footer"><p>&copy; Yoursite.com All rights reserved.
	<a href="index.php">Discussions</a>|
	<a href="categories.php">Categories</a>|
	<a href="search.php">Search</a>Theme by <a href="http://www.ventswap.com/">Vent Swap</a></p>
</div>';

$AllowDebugInfo = 0;
if ($this->Context->Session->User) {
	if ($this->Context->Session->User->Permission('PERMISSION_ALLOW_DEBUG_INFO')) $AllowDebugInfo = 1;
}
if ($this->Context->Mode == MODE_DEBUG && $AllowDebugInfo) {
	echo '<div class="DebugBar" id="DebugBar">
	<b>Debug Options</b> | Resize: <a href="javascript:window.resizeTo(800,600);">800x600</a>, <a href="javascript:window.resizeTo(1024, 768);">1024x768</a> | <a href="'
	."javascript:HideElement('DebugBar');"
	.'">Hide This</a>';
	echo $this->Context->SqlCollector->GetMessages();
	echo '</div>';
}
?>