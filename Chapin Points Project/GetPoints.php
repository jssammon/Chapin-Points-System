<!--
Provides several functions used to get points, dates, etc from mySQL
Intended to be included with header.php or where needed

requires mySQL access
-->
<?php
// These are functions, meant to be include()-ed.
// Functions include GetName($netid) (Returns name)
//					 GetPoints($netid)
include_once("header.php"); // We'll need all our login info

function GetQuarterDates($year) {
	
	$connection = connect_to_mySQL(); // defined in header.php
	
	$sql = "SELECT Start,End_Fall,End_Winter,End_Spring
			FROM Quarter_Dates
			WHERE Year = $year;";
	$result = mysql_query($sql) or die ("error in query \"$sql\"");
	if (mysql_num_rows($result)>0) {
		$date = mysql_fetch_row($result); // Usually this would run in a while loop, but we only care about the first (presumably only) record
	}
	
	// free up memory and close the connection
	mysql_free_result($result);
	mysql_close($connection);
	
	return $date;
}



function GetPointsByPeriod($netid, $startdate, $enddate) {
	$connection = connect_to_mySQL(); // defined in header.php
	
	// create a query. The first one here sums all the approved unrestricted points for a given netid in a date range
	// NOTE: The "AS Points" term names the field in which the result is put into, and should match the field of "row"
	// that you're pulling data from. I learned this the hard way.
	$sql = "SELECT SUM(Points) AS Points
			FROM Raw_Submissions 
			WHERE NetID='$netid'
			AND Approval_Status='Approved'
			AND Restricted=0
			AND Date >= '$startdate'
			AND Date < '$enddate';"; 
	$result = mysql_query($sql) or die ("error in query \"$sql\"");
	if ($result) {
		$row = mysql_fetch_assoc($result); // This syntax took me forever to find
		$unrestricted = $row['Points'];	   // 
	}
	else {
		$unrestricted = 0;
	}
	if (empty($unrestricted)) {		
		$unrestricted=0;		
	}
	
	// And the second one sums restricted points, to a max of 20
	$sql = "SELECT SUM(Points) AS Points
			FROM Raw_Submissions 
			WHERE NetID='$netid'
			AND Approval_Status='Approved'
			AND Restricted=1
			AND Date >= '$startdate'
			AND Date < '$enddate';"; 
	$result = mysql_query($sql) or die ("error in query \"$sql\"");
	if ($result) {
		$row = mysql_fetch_assoc($result);
		$restricted = $row['Points'];
	}
	else {
		$restricted = 0;
	}
	if (empty($restricted)) {		
		$restricted=0;	
	}
	
	// 1 additional condition: There cannot be more than 20 restricted points per period
	// (This function is only intended to be called on a quarter-long period)
	if($restricted > 20) {
		$restricted = 20;
	}
	
	
	// Find all the pending points
	$sql = "SELECT SUM(Points) AS Points
			FROM Raw_Submissions 
			WHERE NetID='$netid'
			AND Approval_Status IS NULL
			AND Date >= '$startdate'
			AND Date < '$enddate';"; 
	$result = mysql_query($sql) or die ("error in query \"$sql\"");
	if ($result) {
		$row = mysql_fetch_assoc($result); 
		$pending= $row['Points'];
	}
	else {
		$pending = 0;
	}
	if (empty($pending)) {		
		$pending=0;	
	}
	
	// And all rejected points
	$sql = "SELECT SUM(Points) AS Points
			FROM Raw_Submissions 
			WHERE NetID='$netid'
			AND Approval_Status='Rejected'
			AND Date >= '$startdate'
			AND Date < '$enddate';"; 
	$result = mysql_query($sql) or die ("error in query \"$sql\"");
	if ($result) {
		$row = mysql_fetch_assoc($result); 
		$rejected= $row['Points'];	       
	}
	else {
		$rejected = 0;
	}
	if (empty($rejected)) {		
		$rejected=0;	
	}
	
	// free up memory and close the connection
	mysql_free_result($result);
	mysql_close($connection);
	
	// create a neat little return array...
	$points['restricted']=$restricted;
	$points['unrestricted']=$unrestricted;
	$points['total']=($restricted+$unrestricted);
	$points['pending']=$pending;
	$points['rejected']=$rejected;
	
	// ...and send it on it's merry way
	return $points;
	
}
function GetName($netid, $startdate = NULL, $enddate = NULL) {
	$connection = connect_to_mySQL(); // defined in header.php
	
	// if all that was supplied was $netid, do this
	if(($startdate == NULL) || ($enddate == NULL)) {
		// Create a query. This one I had to look up, but it works:
		$sql = "SELECT Name, COUNT(*) AS magnitude
				FROM Raw_Submissions
				WHERE NetID='$netid'
				GROUP BY Name
				ORDER BY magnitude DESC
				LIMIT 1;";
		$result = mysql_query($sql) or die (mysql_error());
		if ($result) {
			$row = mysql_fetch_assoc($result); // This syntax took me forever to find
			$name = $row['Name'];			   // 
		}
		// This else{} appears to never in practice get executed; mySQL always returns, just an empty value
		else {
			$name='INVALID_NETID';	// This will be used for simplistic error checking
		}
		
		// As per the above comment, this is the more important error finding statement
		if (empty($name)) {		
			$name='INVALID_NETID';	// This will be used for simplistic error checking
		}
		
		// Free up memory, close out the connection
		mysql_free_result($result);
		mysql_close($connection);
		
		return $name; 
	}
	
	// if we got at least one date, do this
	else {
		if ($enddate == NULL) {
			return 'Error in Call to GetName() - Invalid input';
		}
		
		// Create a query. This time, there's a date limitation
		$sql = "SELECT Name, COUNT(*) AS magnitude
				FROM Raw_Submissions
				WHERE NetID='$netid'
				AND Date >= '$startdate'
				AND Date < '$enddate'
				GROUP BY Name
				ORDER BY magnitude DESC
				LIMIT 1;";
		$result = mysql_query($sql) or die (mysql_error());
		if ($result) {
			$row = mysql_fetch_assoc($result); // This syntax took me forever to find
			$name = $row['Name'];			   // 
		}
		// This else{} appears to never in practice get executed; mySQL always returns, just an empty value
		else {
			$name='INVALID_NETID';	// This will be used for simplistic error checking
		}
		
		// As per the above comment, this is the more important error finding statement
		if (empty($name)) {		
			$name='INVALID_NETID';	// This will be used for simplistic error checking
		}
		
		// Free up memory, close out the connection
		mysql_free_result($result);
		mysql_close($connection);
		
		return $name; 
	}
}

?>