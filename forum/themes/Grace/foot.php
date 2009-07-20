<?php
// Note: This file is included from the library/Vanilla/Vanilla.Control.Foot.php class.
echo '<a id="pgbottom" name="pgbottom">&nbsp;</a></div><div id="Bottom"></div></div><div class="ClearBoth"></div></div>';
// END LEFT, CONTENT, WRAPPER & STRATR FOOTER
echo '<div id="Footer">
    <div id="Links">
	  <a href="index.php" title="Discussions">Discussions</a> &nbsp;|&nbsp;
      <a href="categories.php" title="Categories">Categories</a> &nbsp;|&nbsp;
      <a href="search.php" title="Search">Search</a> &nbsp;|&nbsp;
      <a href="#" title="Link">Link</a> &nbsp;|&nbsp;
	  <a href="#" title="Link">Link</a> &nbsp;|&nbsp;
	  <a href="#" title="Link">Link</a> &nbsp;|
      <a href="#" title="Link">Link</a><br />
	&copy; Copyright '.date('Y').' ScreamingMonkeys.org All rights reserved.</div>
	<div id="About">
	<h2>About Us</h2>The Screaming Monkeys Web Guild was created by two Fort Wayne, Indiana web professionals, James Mitchell and Tim Novinger. We hold regular events where like-minded web professionals can...talk shop, share ideas, make connections with other local talent, and learn, learn, learn. All in a fun, exciting and creative atmosphere.</div>
    </div></div>';
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