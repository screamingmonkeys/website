<?php
// Note: This file is included from the library/Vanilla/Vanilla.Control.Menu.php class.

	$this->CallDelegate('PreHeadRender');	
   echo '<div id="Wrapper"><div id="Header">
			<a name="pgtop"></a>
			<div id="Title"><a href="index.php">'.$this->Context->Configuration['BANNER_TITLE'].'</a></div><div id="Date">'.date('l, M jS, Y').' '.'</div>';
			echo '<div id="Nav"><ul>';
				while (list($Key, $Tab) = each($this->Tabs)) {
					echo '<li'.$this->TabClass($this->CurrentTab, $Tab['Value']).'><a href="'.$Tab['Url'].'" '.$Tab['Attributes'].'>'.$Tab['Text'].'</a></li>';
		      }			
			echo '</ul><div class="ClearBoth"></div></div></div>';

	$this->CallDelegate('PreBodyRender');	
   echo '<div id="Main">';
?>