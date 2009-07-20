<?php
// Note: This file is included from the library/Framework/Framework.Control.Panel.php class.

// Add the start button to the panel
if ($this->Context->Session->UserID > 0 && $this->Context->Session->User->Permission('PERMISSION_START_DISCUSSION')) {
   $CategoryID = ForceIncomingInt('CategoryID', 0);
	if ($CategoryID == 0) $CategoryID = '';
	echo '<ul class="Lists"><li><a href="'.GetUrl($this->Context->Configuration, 'post.php', 'category/', 'CategoryID', $CategoryID).'">'
      .$this->Context->GetDefinition('StartANewDiscussion')
      .'</a></li></ul>';
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
         $sReturn .= '<ul class="Lists">
            <li>
               <h2>'.$Key.'</h2>
               ';
               while (list($LinkKey, $Link) = each($Links)) {
                  $sReturn .= '
                     <a '.($Link['Link'] != '' ? 'href="'.$Link['Link'].'"' : '').' '.$Link['LinkAttributes'].'>'
                        .$Link['Item'];
                        if ($Link['Suffix'] != '') $sReturn .= ' <span>'.$this->Context->GetDefinition($Link['Suffix']).'</span>';
                     $sReturn .= '</a>';
                  $sReturn .= '';
               }
               $sReturn .= '
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
<div id="CornerT"></div><div id="Content">';
if ($this->Context->Session->UserID > 0) {
      echo str_replace('//1',
         $this->Context->Session->User->Name,
         $this->Context->GetDefinition('')).'';
   } else {
      echo '<div id="Welcome"><strong>'.$this->Context->GetDefinition('Welcome guest!</strong><br /><div id="Message">Want to take part in these discussions? Please').' <a href="'.AppendUrlParameters($this->Context->Configuration['SIGNIN_URL'], 'ReturnUrl='.GetRequestUri()).'">'.$this->Context->GetDefinition('SignIn').'</a> or&nbsp;';
	 echo '<a href="people.php?PostBackAction=ApplyForm">'.$this->Context->GetDefinition('ApplyForMembership').' now!</a></div>';
	 echo '</div>';
   }
?>