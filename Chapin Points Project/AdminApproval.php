<!DOCTYPE html PUBLIC>
<!--
Code for fetching records with no approval status, dynamically generates a form to approve or reject
these records. Sends the approval statuses from the form via $_POST, and indexing information via $_SESSION,
to AdminApproval2.php

Requires mySQL access
-->
<?php
session_start(); // index max and min are stored here
session_unset(); // don't want any holdover data hanging around from previous pages.
include_once('../header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
// NOTE: because we're down a directory, we use '../header.php' instead of '/header.php' - If we went down another directory,
// it would become ../../header.php. Just something to note if you're creating a new folder somewhere
?>
<body>
<div class="wide">
<h1> Chapin Hall Points - Points Approval </h1>


Records awaiting approval: <br />

<?php
$connection = connect_to_mySQL(); // defined in header.php

// Create a query
$sql = 'SELECT * FROM Raw_Submissions WHERE Approval_Status IS NULL;'; // No variables, here
// Run the query
$result = mysql_query($sql) or die ("error in query \"$sql\"");
if (mysql_num_rows($result)>0) {
	//query is not empty, so create a table
	echo "<table>";
	
	// give the table some nice headers
	echo "<tr> <th> Timestamp </th> <th> Name </th> <th> NetID </th>
		<th> Category </th> <th> Event </th> <th> Date </th> <th> Info </th> <th> Points </th>
		<th> Restricted? </th> <th> Accept/Reject </th> </tr>";
	
	// start a form. Once again, php and html are being mixed together in a terrible abomination that is somehow valid code
	echo "<form action=\"AdminApproval2.php\" method=\"post\">";
	
	// a few variables we'll need - the maximum and minimum index, which will be used on the next page
	// they'll be reassigned in the course of our loop
	$minindex=PHP_INT_MAX;
	$maxindex=0;
	
	// whenever you see two nested loops, there's a good chance the program is doing something with a table
	// This is no exception - The while loop generates rows (an uncertain amount), the for loop generates columns (a known number)
	
	while($row = mysql_fetch_row($result)){
		echo "<tr>";
		$index = $row[0];
		
		// This is a fairly straightforward assignment of maximum and minimum indices
		// Note that both of these statements will run on the first pass, by the definitions
		// of our min and max indices above
		if ($index < $minindex){
			$minindex = $index;
		}
		if ($index > $maxindex) {
			$maxindex = $index;
		}
		
		// Generate/populate our columns with data. A few special cases to format the dates and bools
		// The index number $i here is the column number. Note that there are a few $i-1 conversions
		// because the first column is denoted "1" but indexed in $row as 0 (and so forth).
		for ($i = 2 ; $i <= 10 ; $i++){	// there are 11 columns in our SQL table, but the last one is NULL by definition (See the query that generated this table)
										// the first one we ignore because it is just a meaningless ID number assigned at random
			echo "<td>";
			if (($i==2) || ($i==7)) { // if it's a date
				echo date("n-j-Y", strtotime($row[($i-1)]));
			}
			else if ($i == 10) {
				if ($row[($i-1)]==TRUE) {
					echo "Restricted";
				}
			}
			else {
				echo $row[($i-1)];
			}
		}
		// add some radio buttons in the last column. Each set of two has a unique name (the submission ID number)
		// making it easy to iterpret this data and send it back into mySQL
		echo "<td>";
		// If you don't like the possibility of accidentally approving a ton of records,
		// you should remove [checked=\"checked\"] from the next line
		echo "<input type=\"radio\" name=\"$index\" value=\"Approved\" checked=\"checked\"> Accept &nbsp;&nbsp;&nbsp;"; 
		echo "<input type=\"radio\" name=\"$index\" value=\"Rejected\"> Reject &nbsp;&nbsp;&nbsp;";
		echo "</td>";
		echo "</tr>";
	} // end of the data fetching
	
	// end the madness. Specifically, this ends the table and the form, with the ubiquitous "submit" button
	echo "</table>";
	echo "<br />";
	echo "End of Records <br /> <br />";
	echo "NOTE: Restricted points are automatically capped at 20, even if more are approved. <br /> <br />";

	echo "<input type=\"submit\" name=\"submit\" value=\"Approve Records\">";
	echo "</form>";
	
	// PROGRAMMER's NOTE: All this echoing is terrible form. I should probably be breaking the php and
	// inserting ordinary html (still within the conditional of the php) - this is how most other pages
	// on this site were done. But this was easier for me to wrap my brain around for this part. I'm sorry, 
	// I hope it isn't too hard to follow.
	
	// save variables. Approval/Rejection is sent to the next page via POST, but our min and max indices
	// have to be sent seperately via SESSION
	$_SESSION['minindex']=$minindex;
	$_SESSION['maxindex']=$maxindex;
}
else {
	echo "No new records found";
}
echo "<br />";

// free up memory and close out the connection
mysql_free_result($result);
mysql_close($connection);

?>

</div>

<?php
include('../footer.php'); // footer info remains constant. See note on header of this page
?>

</body>
</html>