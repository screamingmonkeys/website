<?php
// Note: This file is included from the library/Vanilla/Vanilla.Control.Menu.php class.

	$this->CallDelegate('PreHeadRender');
	echo '<div id="Header">
			<a name="pgtop"></a>
			<div id="Nav">
			<ul>';
				while (list($Key, $Tab) = each($this->Tabs)) {
					echo '<li'.$this->TabClass($this->CurrentTab, $Tab['Value']).'><a href="'.$Tab['Url'].'" '.$Tab['Attributes'].'>'.$Tab['Text'].'</a></li>';
				}
			echo '</ul>
	</div>
	<div id="Session">';
	if ($this->Context->Session->UserID > 0) {
		echo str_replace('//1',	$this->Context->Session->User->Name, $this->Context->GetDefinition('SignedInAsX'))
			. ' (<a href="'
			. FormatStringForDisplay(AppendUrlParameters(
				$this->Context->Configuration['SIGNOUT_URL'],
				'FormPostBackKey=' . $this->Context->Session->GetCsrfValidationKey() ))
			. '">'.$this->Context->GetDefinition('SignOut').'</a>)';
	} else {
		echo $this->Context->GetDefinition('NotSignedIn') . ' (<a href="'
			. FormatStringForDisplay(AppendUrlParameters(
				$this->Context->Configuration['SIGNIN_URL'],
				'ReturnUrl='. urlencode(GetRequestUri(0))))
			. '">'.$this->Context->GetDefinition('SignIn').'</a>)';
	}
	echo '<a class="Skip" href="#Discussions">Skip</a></div></div>';
	$this->CallDelegate('PreBodyRender');
	echo '<div id="Container">';
?>