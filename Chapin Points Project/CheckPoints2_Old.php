<!DOCTYPE html PUBLIC>
<!--
Handler for CheckPoints.php. Takes the netid entered, and spits back a summary of points.
Gives notification of any pending or restricted points if found, otherwise is silent on the matter

requires mySQL access
-->
<?php
session_start(); // We'll keep some variables across pages
include_once('header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
include_once('GetPoints.php'); // Functions used to collect points information
?>
<body>
<div id="container">
<h1> Chapin Hall Points - View Points </h1>

<?php
	$netid=strtolower(sanitize_input($_POST['netid']));
	$name=GetName($netid); // This returns 'INVALID_NETID' if it fails to find a single record
	if ($name != 'INVALID_NETID') {
		
		$currentmonth= date('n'); // n is format symbol for numerical month, no leading zeros 
		$currentyear = date('Y'); // Y is format symbol for numerical year, 4 digits
		// if it's July or later, we can assume it's fall quarter, and the year is correct.
		// If it's earlier than that, it's winter or spring, and the current year is not
		// the same as the school year as held by the database (That is defined as the year of fall quarter)
		// (See 'AdminSetDates.php for clarification if this doesn't make sense)
		if ($currentmonth <=7) {
			$currentyear--; // the year of fall quarter was the numerical year before 'now'
		}
		
		// Get the dates we'll be working with
		$dates=GetQuarterDates($currentyear);
		
		// Format them in a way I can inject back into SQL (Has the added bonus of making the dates readable by humans)
		for( $i = 0 ; $i < 4 ; $i++ ){
		$date[$i] = date("Y-m-d", strtotime($dates[$i]));
		}
		
		// give some output:
		$nextyear=$currentyear+1;
		$sum = 0;
		echo "<b>Record for $name ($netid), $currentyear-$nextyear school year </b><br /><br />";
		
		$record = GetPointsByPeriod($netid, $date[0], $date[1]);
		echo "<b>Fall</b><br />: $record[total] total points, of which $record[restricted] are restricted <br />";
		if ($record['pending'] != 0) {
			echo "($record[pending] points pending) <br />";
		}
		if ($record['rejected'] != 0) {
			echo "($record[rejected] points rejected) <br />";
		}
		$sum += $record['total'];
		
		$record = GetPointsByPeriod($netid, $date[1], $date[2]);
		echo "<b>Winter</b><br />: $record[total] total points, of which $record[restricted] are restricted <br />";
		if ($record['pending'] != 0) {
			echo "($record[pending] points pending) <br />";
		}
		if ($record['rejected'] != 0) {
			echo "($record[rejected] points rejected) <br />";
		}
		$sum += $record['total'];
		
		$record = GetPointsByPeriod($netid, $date[2], $date[3]);
		echo "<b>Spring</b><br />: $record[total] total points, of which $record[restricted] are restricted <br />";
		if ($record['pending'] != 0) {
			echo "($record[pending] points pending) <br />";
		}
		if ($record['rejected'] != 0) {
			echo "($record[rejected] points rejected) <br />";
		}
		$sum += $record['total'];
		
		echo "<b>Total points</b>: $sum <br />";
	}
	else {
		echo "No record found for $netid <br />";
	}
	
?>
<br />
<a href="http://chapin-points.net16.net/default.php"> Return to points homepage</a><br />

</div>
<?php
include('footer.php'); // footer info remains constant
?>


</body>
</html>