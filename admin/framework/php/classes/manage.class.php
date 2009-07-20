<?php
//======================================================================
//Manage Site Content Class
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.10.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

class Manage {
	private $Admin;
	public $Settings;
	public $Paginator;
			
	public function __construct($BIND) {	
		$this->Settings = new Settings('manage');
		$this->Admin = $BIND;
		$this->PageCount = 0;
		
		//USE PAGINATION
		$this->Paginator = new Paginator();
	}
	
	
	public function Count($col, $table, $cond) {
		$where = isset($cond) ? "WHERE ".$cond : "";
		$sql = "SELECT ".$col."
				FROM ".$table."
				".$where."
				";
		$result = mysql_query($sql) or die("Query failed (count): ".$sql." - ".mysql_error());
		return mysql_num_rows($result);
	}
	
	
	public function GetAuthor($id) {
		$sql = "SELECT id, fullname
				FROM users
				WHERE id = ".$id."
				";
		$result = mysql_query($sql) or die("Query failed (get author): ".$sql." - ".mysql_error());
		$author = mysql_fetch_array($result);
		return $author['fullname'];
	}
	
	
	public function GetPage($id) {
		$sql = "SELECT *
				FROM pages
				WHERE id = ".$id."
			   ";
		$result = mysql_query($sql) or die("Query failed (generate page): ".$sql." - ".mysql_error());
		
		return mysql_fetch_array($result);
		
		mysql_free_result($result);
		unset($sql, $result, $row, $data);
	}
	
	
	public function GetSection($id) {
		$sql = "SELECT *
				FROM sections
				WHERE id = ".$id."
			   ";
		$result = mysql_query($sql) or die("Query failed (generate section): ".$sql." - ".mysql_error());
		
		return mysql_fetch_array($result);
		
		mysql_free_result($result);
		unset($sql, $result, $row, $data);
	}
	
	
	public function GenerateSectionDropdown($sid) {
		$sql = "SELECT id, name
				FROM sections
				ORDER BY name
			   ";
		$result = mysql_query($sql) or die("Query failed (generate section dropdown): ".$sql." - ".mysql_error());
		
		while($row = mysql_fetch_array($result)) {
			$selected = ($row['id'] == $sid) ? 'selected="selected"' : '';
			$data .= "<option value='".$row['id']."' ".$selected.">".$row['name']."</option>";
		}
		return $data;
		
		mysql_free_result($result);
		unset($sql, $result, $row, $data);
	}
	
	
	public function ListSections() {
		if($this->Settings->DB['use_sections']) {
			//pull count
			$count = "SELECT count(*) FROM sections";
			$count_query = mysql_query($count) or die("Query failed (count sections): ".$count." - ".mysql_error());				//submit counting query
			$count_result = mysql_fetch_row($count_query);
			$numrows = $count_result[0];
			$this->Paginator->SetTotalRecords($numrows);															//tell paginator class how many results
			$this->Paginator->SetTotalPages();
			
			//pull data
			$sql = "SELECT *
					FROM sections
					ORDER BY name ASC
					LIMIT ".$this->Paginator->GetRecordOffset().", ".$this->Paginator->GetRecordsPerPage()."";
			$result = mysql_query($sql) or die("Query failed (list sections): ".$sql." - ".mysql_error());
			
			//loop and display
			while($section = mysql_fetch_array($result)) {
				$zebra = ($i % 2) ? "even" : "odd";		 																	//zebra striping logic
				$data .= "<tr class='".$zebra."'>
							<td><input type='checkbox' alt='' class='checkbox' name='id[]' value='".$section['id']."'></td>
							<td>".$section['name']."</td>
							<td>".$this->Count("pages.sid, sections.id", "pages, sections", "pages.sid = ".$section['id']." AND sections.id = ".$section['id']."")."</td>
							<td><a href='?p=manage&amp;sub=sections&amp;action=edit&amp;id=".$section['id']."' class='ajax'>edit</a></td>
						  </tr>";
				$i++;
			}
			$data = (mysql_num_rows($result)) ? $data : "<tr><td colspan='4'>".$this->Admin->CONFIG['MSG_returned_zero_results']."</td></tr>";
			return $data;
			
			mysql_free_result($result, $count_result);
			unset($sql, $count, $count_query, $count_result, $numrows, $zebra, $result, $section, $data);
		} else {
			return false;
		}
	}	
	
	
	public function ListPages() {		
		//DETERMINE QUERY
		if($this->Settings->DB['use_sections'] == 'true') {
			$count = "SELECT count(*) FROM pages, sections WHERE sections.id = pages.sid";
		} else {
			$count = "SELECT count(*) FROM pages";
		}
		$count_query = mysql_query($count) or die("Query failed (count pages): ".$count." - ".mysql_error());						//submit counting query
		$count_result = mysql_fetch_row($count_query);
		$numFound = $count_result[0];
		$this->Paginator->SetTotalRecords($numFound);																//tell paginator class how many results
		$this->Paginator->SetTotalPages();
		
		$totalPages = $this->Count('*', 'pages', null);
		
		//DETERMINE QUERY
		if($this->Settings->DB['use_sections'] == 'true' && $totalPages == $numFound) {
			$sql = "SELECT pages.id as pid, pages.date, pages.title, pages.content, pages.published_by, pages.status, sections.id as sid, sections.name
					FROM pages, sections
					WHERE sections.id = pages.sid 
					ORDER BY pages.title ASC
					LIMIT ".$this->Paginator->GetRecordOffset().", ".$this->Paginator->GetRecordsPerPage()."
					";
		} else {
			$sql = "SELECT pages.id as pid, pages.date, pages.title, pages.content, pages.published_by, pages.status
					FROM pages
					WHERE pages.sid = 0
					ORDER BY pages.id ASC
					LIMIT ".$this->Paginator->GetRecordOffset().", ".$this->Paginator->GetRecordsPerPage()."
					";
		}
		$result = mysql_query($sql) or die("Query failed (list pages): ".$sql." - ".mysql_error());										//submit main query
		
		while($page = mysql_fetch_array($result)) {
			$zebra = ($i % 2) ? "even" : "odd";		 																					//zebra striping logic
			$status = ($page['status'] == 1) ? "<strong>published</strong>" : "draft";
			$data .= "<tr class='".$zebra."'>
							<td><input type='checkbox' alt='' class='checkbox' name='id[]' value='".$page['pid']."'></td>
							<td>".$this->Admin->DB->ConvertSQLDate($page['date'], "short", "from")."</td>
							<td>".$page['title']."</td>
							<td>".$this->GetAuthor($page['published_by'])."</td>
					";
			$data .= ($this->Settings->DB['use_sections'] == 'true') ? "<td>".$page['name']."</td>" : "";
			$data .= "		<td>".$status."</td>
							<td><a href='?p=manage&amp;sub=pages&amp;action=edit&amp;sid=".$page['sid']."&amp;pid=".$page['pid']."' class='ajax'>edit</a></td>
						</tr>";
			$i++;
		}
		return mysql_num_rows($result) ? $data : "<tr><td colspan='7'>".$this->Admin->CONFIG['MSG_returned_zero_results']."</td></tr>";
		
		mysql_free_result($result, $count_result);
		unset($sql, $count, $count_query, $count_result, $numrows, $zebra, $result, $section, $data);
	}
	
	
	public function CreateSection($_POST) {
		$sql = "INSERT INTO sections
				(name)
				values
				('".$this->Admin->StripTags($_POST['name'], 'strict')."')
			   ";
		$result = mysql_query($sql) or die("Query failed (create section): ".$sql." - ".mysql_error());
		return $result;
		mysql_free_result($result);
		unset($sql, $result, $_POST);
	}
		
	
	public function CreatePage($_POST) {
		$sql = "INSERT INTO pages
				(sid, date, title, content, published_by, status)
				values
				('".$_POST['section']."', 
				'".$this->Admin->DB->ConvertSQLDate($_POST['date'], "", "to")."', 
				'".$this->Admin->StripTags($_POST['title'], 'strict')."', 
				'".str_replace("'", "\'", $this->Admin->StripTags($_POST['content'], 'loose'))."', 
				'".$_POST['published_by']."', 
				'".$_POST['status']."')
			   ";
		$result = mysql_query($sql) or die("Query failed (create page): ".$sql." - ".mysql_error());
		return $result;
		mysql_free_result($result);
		unset($sql, $result, $_POST);
	}

	
	public function EditSection($_POST) {
		$sql = "UPDATE sections 
				SET name = '".$_POST['name']."'
				WHERE id = '".$_POST['id']."'";
		$result = mysql_query($sql) or die("Query failed (edit section): ".$sql." - ".mysql_error());
		
		return $result;
		
		mysql_free_result($result);
		unset($sql, $result);
	}
	
	
	public function EditPage($_POST) {
		$sql = "UPDATE pages 
				SET sid = '".$_POST['section']."', 
				    date = '".$this->Admin->DB->ConvertSQLDate($_POST['date'], "", "to")."',
					title = '".$this->Admin->StripTags($_POST['title'], 'loose')."',
					content = '".str_replace("'", "\'", $this->Admin->StripTags($_POST['content'], 'loose'))."',
					published_by = '".$_POST['published_by']."',
					status = '".$_POST['status']."'
				WHERE id = '".$_POST['id']."'";
		$result = mysql_query($sql) or die("Query failed (edit job): ".$sql." - ".mysql_error());
		
		return $result;
		
		mysql_free_result($result);
		unset($sql, $result);
	}
	
	
	public function Delete($table, $id) {
		$sql = "DELETE FROM ".$table." WHERE id = '".$id."' LIMIT 1";
		$result = mysql_query($sql) or die("Query failed: ".$sql." ".mysql_error());
		
		return $result;
		
		mysql_free_result($result);
		unset($sql, $result, $table, $id);
	}
}
?>