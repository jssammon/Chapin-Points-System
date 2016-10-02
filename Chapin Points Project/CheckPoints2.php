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
<div class="wide">
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
		echo "<b>Fall:</b><br /> $record[total] total points, of which $record[restricted] are restricted <br />";
		if ($record['pending'] != 0) {
			echo "($record[pending] points pending) <br />";
		}
		if ($record['rejected'] != 0) {
			echo "($record[rejected] points rejected) <br />";
		}
		$sum += $record['total'];
		
		$record = GetPointsByPeriod($netid, $date[1], $date[2]);
		echo "<b>Winter:</b><br /> $record[total] total points, of which $record[restricted] are restricted <br />";
		if ($record['pending'] != 0) {
			echo "($record[pending] points pending) <br />";
		}
		if ($record['rejected'] != 0) {
			echo "($record[rejected] points rejected) <br />";
		}
		$sum += $record['total'];
		
		$record = GetPointsByPeriod($netid, $date[2], $date[3]);
		echo "<b>Spring:</b><br /> $record[total] total points, of which $record[restricted] are restricted <br />";
		if ($record['pending'] != 0) {
			echo "($record[pending] points pending) <br />";
		}
		if ($record['rejected'] != 0) {
			echo "($record[rejected] points rejected) <br />";
		}
		$sum += $record['total'];
		
		echo "<b>Total points</b>: $sum <br /><br />";
		
		// now display all the points records in a table
		echo "<b>All Points records for $name:</b><br />";
		
		// Get the sql query all set. This will need some date restrictions and a netid restriction
		$connection = connect_to_mySQL(); // defined in header.php
		$sql="SELECT Category,Event,Date,Additional_Info,Points,Restricted,Approval_Status 
			  FROM Raw_Submissions 
			  WHERE NetID='$netid'
			  AND Date >= '$date[0]'
			  AND Date < '$date[3]'
			  ORDER BY Date DESC";
		// Run the query
		$result = mysql_query($sql) or die ("error in query \"$sql\"");
		
		if (mysql_num_rows($result)>0) {
			//query is not empty, so create a table
			echo "<table>";
			
			// give the table some nice headers
			echo "<tr> <th> Category </th> <th> Event </th> <th> Date </th>
			<th> Additional Info </th> <th> Points </th> <th> Restricted? </th> <th> Approval Status </th></tr>";
			while($row = mysql_fetch_row($result)){
				echo "<tr>";
				
				for ($i = 1 ; $i <= 7 ; $i++){
					echo "<td>";
					
					// Block of if/elseif/else to format the text
					if ($i==3) { // if it's a date
					echo date("n-j-Y", strtotime($row[($i-1)]));
					}
					
					else if ($i == 6) { // if it's a restricted point
						if ($row[($i-1)]==TRUE) {
							echo "Restricted";
						}
						else {
							echo "-";
						}
					}
					else if ($i == 7){
						if (!($row[($i-1)])) {	//ie, if the entry is null
							echo "Pending";
						}
						else{
							echo $row[($i-1)];
						}
					}
					else {
						echo $row[($i-1)];
					}
					
					// close out the table entry and cycle back to the start of the for loop
					echo "</td>";
				}
				
				echo "</tr>";
			}
			echo "</table>";
			echo "<br />";
			
			//
		}
		else{
			echo "Something went wrong :( <br />";
		}
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