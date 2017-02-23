<!DOCTYPE html PUBLIC>
<!--
Handler for AdminTotals.php. Based on the year recieved, generates a master list of records for the year
Gives All student names, netids, and points by quarter and total.

requires mySQL access
-->
<?php
//session_start(); // Not sure if I'll be using this for this part of the page or not. Left commented until needed
include_once('../header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
include_once('../GetPoints.php'); // Functions used to collect points information
?>
<body>
<div id="container">
<h1> Chapin Hall Points - Points Summary </h1>

<a href="http://chapin-points.byethost5.com/admin/AdminPage1.php"> Return to Admin Home Page</a><br />
<br />
<?php
	
	// get our year, with a little rudimentary stupid error catching
	$raw_year=sanitize_input($_POST['year']);
	$raw_year=round($raw_year);
	$currentyear=$raw_year;
	
	// output the year
	$nextyear=$currentyear+1;
	echo "Record for $currentyear-$nextyear <br />";
	
	// Fire up our trusty mySQL connection function
	$connection = connect_to_mySQL(); // defined in header.php
	
	// First, get a list of all netid
	$sql = "SELECT DISTINCT netid FROM Raw_Submissions;";
	
	// Run the query
	$result = mysql_query($sql) or die (mysql_error());
	
	if (mysql_num_rows($result)>0) {
		
		// clear out the old points_summary table. We're rewriting it from scratch
		$sql = "DELETE FROM Points_Summary;";
		if (!mysql_query($sql)) {
		   die('Error:' . mysql_error());
		}
		
		// set an index
		$i=0;
		
		// loop to get a list of netids
		while($row = mysql_fetch_row($result)){
			$netids[$i]=$row[0];
			$i++;
		}
		
		// Get the dates we'll be working with
		$dates=GetQuarterDates($currentyear);
		
		// Format them in a way I can inject back into SQL (Has the added bonus of making the dates readable by humans)
		for( $i = 0 ; $i < 4 ; $i++ ){
		$date[$i] = date("Y-m-d", strtotime($dates[$i]));
		}
		
		// Now generate a table of name|netid|points
		//echo "<table cellpadding=2>";
		//echo "<tr> <td> Name </td> <td> NetID </td> <td> Fall </td> <td> Winter </td> <td> Spring </td> <td> Total </td> </tr>";
		
		// even if you're familiar with programming, this may be a new one, but it's easy to understand:
		// this iterates along $netids; during each iteration, the current selected netid can be referenced
		// by $netid. This is unset() at the end to prevent any awkward issues of $netid existing outside the loop
		foreach ($netids as $netid) {
			// get a name
			$name = GetName($netid, $date[0], $date[3]);
			
			// check if the name is valid
			// this is dependent on the points period defined by GetName($netid, $date[0], $date[3]) above
			if ($name == 'INVALID_NETID') {
				continue;
			}
			
			// this will accumulate a total for the year
			$sum = 0;
			
			// get fall points
			$record = GetPointsByPeriod($netid, $date[0], $date[1]);
			$fallpoints=$record['total'];
			$sum += $fallpoints;
			
			// get winter points
			$record = GetPointsByPeriod($netid, $date[1], $date[2]);
			$winterpoints=$record['total'];
			$sum += $winterpoints;
			
			// get spring points
			$record = GetPointsByPeriod($netid, $date[2], $date[3]);
			$springpoints=$record['total'];
			$sum += $springpoints;
			
			// re-establish connection; it appears to close out because of the nature of the functions I wrote
			$connection = connect_to_mySQL();
			
			// write these to a table. This table was cleared before entering this loop
			$sql = "INSERT INTO Points_Summary (Name, NetID, Fall, Winter, Spring, Total)
					Values ('$name', '$netid', '$fallpoints', '$winterpoints', '$springpoints', '$sum');";
			if (!mysql_query($sql)) {
			   die('Error:' . mysql_error());
			}
		}
		// Now, retireve the values from this database.
		// doing this outside the loop, rather than building a table dynamically, allows us to sort the data first
		// which will make this list convenient for housing, etc.
		
		$connection = connect_to_mySQL(); // defined in header.php
		$sql = "SELECT *
				FROM Points_Summary
				ORDER BY NetID ASC;";
		$result = mysql_query($sql) or die ("error in query \"$sql\"");
		
		// If there's at least one record...
		if (mysql_num_rows($result)>0) {
			
			//generate table header
			echo "<table>";
			echo "<tr> <th> Name </th> <th> NetID </th> <th> Fall </th> <th> Winter </th> <th> Spring </th> <th> Total </th> </tr>";
			
			// populate the table. Note that the table is known to have 6 columns
			while($row = mysql_fetch_row($result)){
				echo "<tr>";
				for ( $i = 0 ; $i < 6 ; $i++ ) {
					echo "<td> $row[$i] </td>";
				}
				echo "</tr>";
			}
			echo "</table><br />";
		}
		unset($netid);
	}
	else {
		echo "No records found <br />";
	}
	
	mysql_free_result($result);
	// The $connection variable gets changed during this script, since it's opened several times
	// Calling mysql_close() with no arguments somehow also generates an error, so this has been
	// commented entirely. The connection should close automatically at the end of the script,
	// so this doesn't really change anything
	//mysql_close();  
	
	
?>

<p> Point totals shown are for all approved points for events within the given school year.
These values already reflect the 20 restricted point per quarter cap. </p>
<p> This table has also been written to mySQL. The table can be exported to Excel via the phpMyAdmin
tool available on the site management page. </p>



</div>
<?php
include('../footer.php'); // footer info remains constant. See note on header of this page
?>


</html>
</body>
</html>