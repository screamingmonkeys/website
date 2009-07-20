<?php
// Note: This file is included from the library/Framework/Framework.Control.Panel.php class.

echo '<div id="Panel">';
//SIGNIN-MOD BY SAM EL
echo '<div id="SignIn">';
if ($this->Context->Session->UserID > 0) {
      echo str_replace('//1',
         $this->Context->Session->User->Name,
         $this->Context->GetDefinition('SignedInAsX')).' [<a href="'.$this->Context->Configuration['SIGNOUT_URL'].'">'.$this->Context->GetDefinition('SignOut').'</a>]';
   } else {
      echo $this->Context->GetDefinition('NotSignedIn').' [<a href="'.AppendUrlParameters($this->Context->Configuration['SIGNIN_URL'], 'ReturnUrl='.GetRequestUri()).'">'.$this->Context->GetDefinition('SignIn').'</a>]<br />';
	 echo '[<a href="people.php?PostBackAction=ApplyForm">'.$this->Context->GetDefinition('ApplyForMembership').'</a>]';
   }
   echo '</div>';
// Add the start button to the panel
if ($this->Context->Session->UserID > 0 && $this->Context->Session->User->Permission('PERMISSION_START_DISCUSSION')) {
   $CategoryID = ForceIncomingInt('CategoryID', 0);
	if ($CategoryID == 0) $CategoryID = '';
	echo '<ul><li><ul><li><a href="'.GetUrl($this->Context->Configuration, 'post.php', 'category/', 'CategoryID', $CategoryID).'">'
      .$this->Context->GetDefinition('StartANewDiscussion')
      .'</a></li></ul></li></ul>';
}

$this->CallDelegate('PostStartButtonRender');

while (list($Key, $PanelElement) = each($this->PanelElements)) {
   $Type = $PanelElement['Type'];
   $Key = $PanelElement['Key'];
   if ($Type == 'List') {
      $sReturn = '';
      $Links = $this->Lists[$Key];
      if (count($Links) > 0) {
         ksort($Links);
         $sReturn .= '<ul>
            <li>
               <h2>'.$Key.'</h2>
               <ul>';
               while (list($LinkKey, $Link) = each($Links)) {
                  $sReturn .= '<li>
                     <a '.($Link['Link'] != '' ? 'href="'.$Link['Link'].'"' : '').' '.$Link['LinkAttributes'].'>'
                        .$Link['Item'];
                        if ($Link['Suffix'] != '') $sReturn .= ' <span>'.$this->Context->GetDefinition($Link['Suffix']).'</span>';
                     $sReturn .= '</a>';
                  $sReturn .= '</li>';
               }
               $sReturn .= '</ul>
            </li>
         </ul>';
      }
      echo $sReturn;
   } elseif ($Type == 'String') {
      echo $this->Strings[$Key];
   }
}

$this->CallDelegate('PostElementsRender');

echo '</div>
<div id="Content"><div id="Top"></div><div id="LeftContent">';
?>