<?php
//======================================================================
//Paginator Class
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	07.21.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

class Paginator {
	private $total_records;
	private $records_per_page;
	private $params;
	private $first_param;
	private $error;
	
	private $current_page;
	private $start_page;
	private $end_page;
	private $total_pages;
	private $maxpagesshown;
	
	private $firstinactivespan;
	private $lastinactivespan;
	private $spanpreviousinactive;
	private $spannextinactive;
	private $strfirst 					= "<img src='images/page_previous.gif' alt='' title='Beginning' id='page_previous' />";
	private $strprevious 				= "Previous";
	private $strnext					= "Next";
	private $strlast					= "<img src='images/page_next.gif' alt='' title='End' id='page_next' />";
	 
	 
	public function __construct() {
	}
	
	//Getters and Setters
	public function SetCurrentPage($data)	 {$this->current_page = ($data == '') ? 0 : $data;}
	public function SetTotalRecords($data)   {$this->total_records = $data;}
	public function SetRecordsPerPage($data) {$this->records_per_page = $data;}
	public function SetTotalPages()     	 {$this->total_pages = ceil($this->total_records / $this->records_per_page);}
	public function SetMaxPagesShown($data)	 {$this->maxpagesshown = $data;}
	public function SetRecordParams($data)   {																							//check if offset variable in query string and remove, else just set
		$temp = explode("&", $data);
		foreach($temp as $value) {
			if(stristr($value, "offset")) {
				array_pop($temp);
			}
		}
		$this->params = implode('&', $temp);
	}
	
	public function GetRecordOffset()		 {return $this->current_page * $this->records_per_page;}
	public function GetRecordsPerPage()		 {return $this->records_per_page;}
	public function GetTotalPages()			 {return $this->total_pages;}
		
		
	public function Display() {
		if($this->total_pages > 1) {
			$this->CreateInactiveSpans();
			$this->DetermineStart();
			$this->DetermineEnd();
																																		//Returns HTML code for the navigator
			$result = "<div class='navigator'>\n";																						//wrap in div tag
				if($this->current_page == 0){																								//output movefirst button 
				  $result .= $this->firstinactivespan;																						//output moveprevious button
				  $result .= $this->spanpreviousinactive;
				}else{
				  $result .= $this->CreateLink(0, $this->strfirst);
				  $result.= $this->CreateLink($this->current_page - 1, $this->strprevious);
				}
				
				for($x = $this->start_page; $x < $this->end_page; $x++) {																	//loop through displayed pages from $currentstart
				  if($x == $this->current_page) {																							//make current page inactive
					$result .= "<span class='inactive'>";
					$result .= $x + 1;
					$result .= "</span>\n";
				  } else {
					$result .= $this->CreateLink($x, $x + 1);
				  }
				}
				  
				if($this->current_page == $this->total_pages - 1) {																			//next button  
				  $result .= $this->spannextinactive;      																					//move last button
				  $result .= $this->lastinactivespan;
				} else {
				  $result .= $this->CreateLink($this->current_page + 1, $this->strnext);
				  $result .= $this->CreateLink($this->total_pages - 1, $this->strlast);
				}		
			$result .=  "</div>\n";
			return $result;
		}
	}
	
	
	public function DisplayPageCount() {
		$result  = "<div class='page_count'>\n";
		$result .= "Page ".($this->current_page + 1)." of ".$this->total_pages."\n";
		$result .= "</div>\n";
		return $result;
	}
	
	
	private function CreateLink($offset, $strdisplay) {
		$result = "<a href='".$this->pagename."?".$this->params."&amp;offset=".$offset."' class='ajax'>".$strdisplay."</a>\n";
		return $result;
	}
	
	
	private function CreateInactiveSpans() {																						// not always needed but create anyway
		$this->spannextinactive 	= "<span class='inactive'>".$this->strnext."</span>\n";
		$this->lastinactivespan 	= "<span class='inactive'>".$this->strlast."</span>\n";
		$this->spanpreviousinactive = "<span class='inactive'>".$this->strprevious."</span>\n";
		$this->firstinactivespan 	= "<span class='inactive'>".$this->strfirst."</span>\n";
	}
	
	
	private function DetermineStart() {																								// find start page based on current page
		$temp = floor($this->current_page / $this->maxpagesshown);
		$this->startpage = $temp * $this->maxpagesshown;
	}
	
	
	private function DetermineEnd() {
		$this->end_page = $this->start_page + $this->maxpagesshown;
		if($this->end_page > $this->total_pages) {
			$this->end_page = $this->total_pages;
		}
	}
}
?>