<?php
//======================================================================
//Manage Users Class
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.07.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

class ManageUsers {
	private $CONFIG;
			
	public function __construct($CONFIG) {
		$this->CONFIG = $CONFIG;
		$this->Paginator = new Paginator();																								//USE PAGINATION
	}
	
	
	public function GetUsers($role) {
		$clause = isset($role) ? "WHERE level = '".$role."'" : "";
		
		//pull count
		$count = "SELECT count(*) FROM users ".$clause;
		$count_query = mysql_query($count) or die("Query failed (count sections): ".$count." - ".mysql_error());				//submit counting query
		$count_result = mysql_fetch_row($count_query);
		$numrows = $count_result[0];
		$this->Paginator->SetTotalRecords($numrows);																//tell paginator class how many results
		$this->Paginator->SetTotalPages();
		
		$sql = 'SELECT * FROM users '.$clause.' ORDER BY fullname LIMIT '.$this->Paginator->GetRecordOffset().', '.$this->Paginator->GetRecordsPerPage().'';
		$result = mysql_query($sql) or die("Query failed: ".$sql." ".mysql_error());
		$i = 0;
			
		while($user = mysql_fetch_array($result)) {
			$zebra = ($i % 2) ? "even" : "odd";		 																			//zebra striping logic
			$role = $user['level'] == 1 ? "User" : "Administrator";																//determine acct type
			$data .= "<tr class='".$zebra."'>
						<td><input type='checkbox' class='checkbox' name='id[]' value='".$user['id']."' /></td>
						<td>".$user['fullname']."</td>
						<td>".$user['username']."</td>
						<td><a href='?p=users&sub=view all&rs=".$user['email']."' title='Resend Account Information'>".$user['email']."</a></td>
						<td>".$role."</td>
						<td><a href='?p=users&amp;action=edit&amp;id=".$user['id']."' rel='p=users&amp;action=edit&amp;id=".$user['id']."' class='bttn_edit ajax'>edit</a></td>
					  </tr>
					 ";
			$i++;
		}
		$data = (mysql_num_rows($result)) ? $data : "<tr><td colspan='6'>".$this->CONFIG['MSG_returned_zero_results']."</td></tr>";
		return $data;	
		
		mysql_free_result($result, $count_result);
		unset($sql, $count, $count_query, $count_result, $numrows, $zebra, $result, $role, $clause, $data);
	}
	
	
	public function GetUserProfileByID($id) {
		$sql = 'SELECT * FROM users WHERE id = "'.$id.'" LIMIT 1';
		$result = mysql_query($sql) or die("Query failed: ".$sql." ".mysql_error());
		$user = mysql_fetch_array($result);
		
		return $user;
		
		mysql_free_result($result);
		unset($sql, $result, $user, $id);
	}
	
	
	public function GetUserProfileByUsername($username) {
		$sql = 'SELECT * FROM users WHERE username = "'.$username.'" LIMIT 1';
		$result = mysql_query($sql) or die("Query failed: ".$sql." ".mysql_error());
		$user = mysql_fetch_array($result);
		
		return $user;
		
		mysql_free_result($result);
		unset($sql, $result, $user, $username);
	}
	
	
	public function GetUserProfileByEmail($email) {
		$sql = 'SELECT * FROM users WHERE email = "'.$email.'" LIMIT 1';
		$result = mysql_query($sql) or die("Query failed: ".$sql." ".mysql_error());
		$user = mysql_fetch_array($result);
		
		return $user;
		
		mysql_free_result($result);
		unset($sql, $result, $user);
	}
	
	
	public function CreateUser($POST) {
		$sql = 'INSERT INTO users
				(id, fullname, email, username, password, level)
				VALUES
				("", "'.$POST['fullname'].'", "'.$POST['email'].'", "'.$POST['username'].'", "'.$POST['password1'].'", "'.$POST['level'].'")';
		$result = mysql_query($sql) or die("Query failed: ".$sql." ".mysql_error());
		
		return $result;
		
		mysql_free_result($result);
		unset($sql, $result, $POST);
	}
	
	
	public function EditUser($POST) {
		$level = ($POST['level'] == 2 || $POST['level'] == 1) ? ', level = "'.$POST['level'].'" ' : '';
		$sql = 'UPDATE users SET 
					   fullname = "'.$POST['fullname'].'", 
					   email = "'.$POST['email'].'", 
					   username = "'.$POST['username'].'", 
					   password = "'.$POST['password1'].'" '.$level.' 
				WHERE id = "'.$POST['id'].'" LIMIT 1';
		$result = mysql_query($sql) or die("Query failed: ".$sql." ".mysql_error());
		
		return $result;
		
		mysql_free_result($result);
		unset($sql, $result, $POST);
	}
	
	
	public function DeleteUsers($ID) {
		$sql = "DELETE FROM users WHERE id = '".$ID."' LIMIT 1";
		$result = mysql_query($sql) or die("Query failed: ".$sql." ".mysql_error());
		
		return $result;
		
		mysql_free_result($result);
		unset($sql, $result, $ID);
	}
}
?>