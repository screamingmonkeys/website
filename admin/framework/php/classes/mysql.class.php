<?php
//======================================================================
//MySQL Class
//Database Abstraction Layer
//
//Written By: 	Tim Novinger
//Email:	  	tnovinger@nichols-co.com
//Last Update:	10.07.08
//
//Copyright 2008 - The Nichols Company
//======================================================================

class MySQL {
	private $CONN;
	private $CONN_ERR = "The connection information for the database is not configured properly. Please check the database section in /framework/php/config.inc.php first.";
	private $HOST;
	private $USERNAME;
	private $PASSWORD;
	private $DATABASE;
			
			
	public function __construct() {		
		$this->CONN = "";
		$this->HOST = "";
		$this->USERNAME = "";
		$this->PASSWORD = "";
		$this->DATABASE = "";
	}	
		
		
	public function SetHost($HOST) {$this->HOST = $HOST;}
	public function SetUsername($USERNAME) {$this->USERNAME = $USERNAME;}
	public function SetPassword($PASSWORD) {$this->PASSWORD = $PASSWORD;}
	public function SetDatabase($DATABASE) {$this->DATABASE = $DATABASE;}
			
			
	public function Connect() {	
		if(isset($this->HOST, $this->USERNAME, $this->PASSWORD)) {
			$this->CONN = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD) 
								or die('<hr /><b>Could not connect to database: </b>'.$this->CONN_ERR.'<br />
									    <b>MySQL ERROR: </b>'.mysql_error().'<br /><br />
									    <b>Host Attempted: </b>'.$this->HOST.'<br />
									    <b>Database Attempted: </b>'.$this->DATABASE.'<br />
									    <b>Username Attempted: </b>'.$this->USERNAME.'<br />
									  ');
						  mysql_select_db($this->DATABASE, $this->CONN);
		} else {
			return $this->CONN_ERR;
		}
	}
	
	
	public function Disconnect() {
		mysql_close($this->CONN);
	}
	
	
	public function ConvertSQLDate($date, $style, $direction){
		
		if($direction == "to") {						//convert MM/DD/YYYY to SQL
			$separator = "-";
			$date = explode('/', $date);
			$month = $date[0];
			$day = $date[1];
			$year = $date[2];
			
			$date = $year.$separator.$month.$separator.$day;
		} else if($direction == "from") {
			$separator = "/";
			$date = explode('-', $date);				//convert SQL to MM/DD/YYYY
			$year = $date[0];
			$month = $date[1];
			$day = $date[2];
		
			switch($month){
				case 01:
					$l_month = 'January';
					break;
				case 02:
					$l_month = 'February';
					break;
				case 03:
					$l_month = 'March';
					break;
				case 04:
					$l_month = 'April';
					break;
				case 05:
					$l_month = 'May';
					break;
				case 06:
					$l_month = 'June';
					break;
				case 07:
					$l_month = 'July';
					break;
				case 08:
					$l_month = 'August';
					break;
				case 09:
					$l_month = 'September';
					break;
				case 10:
					$l_month = 'October';
					break;
				case 11:
					$l_month = 'November';
					break;
				case 12:
					$l_month = 'December';
					break;
			}
			switch($style){
				case 'short':
					$date = $month.$separator.$day.$separator.$year;
					break;
				case 'long':
					$date = $day.' '.$l_month.' '.$year;
					break;
			}
		}
		$date = ($date != "00-00-0000") ? $date : '';
		return $date;
	}
	
	public function DateDifference($d1, $d2){
		$d1 = (is_string($d1) ? strtotime($d1) : $d1);
		$d2 = (is_string($d2) ? strtotime($d2) : $d2);

		$diff_secs = abs($d1 - $d2);
		$base_year = min(date("Y", $d1), date("Y", $d2));

		$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		return array(
			"years" => date("Y", $diff) - $base_year,
			"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
			"months" => date("n", $diff) - 1,
			"days_total" => floor($diff_secs / (3600 * 24)),
			"days" => date("j", $diff) - 1,
			"hours_total" => floor($diff_secs / 3600),
			"hours" => date("G", $diff),
			"minutes_total" => floor($diff_secs / 60),
			"minutes" => (int) date("i", $diff),
			"seconds_total" => $diff_secs,
			"seconds" => (int) date("s", $diff)
		);
	}
	
	
	public function IsExpired($expdate){
		$today   = strtotime(date("Y-m-d"));
		$expdate = strtotime($expdate);
		$result  = ($expdate < $today) ? 1 : 0;		
		return $result;	
	}
	
	
	public function Filter($data) {
		$result = str_replace(" ", "_", $data);
		$result = str_replace("&", "&amp;", $result);
		
		return $result;
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
}
?>