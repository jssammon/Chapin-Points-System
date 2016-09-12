<!DOCTYPE html PUBLIC>
<!--
Handling code for AdminApproval.php . Updates the approval status of records in mySQL

Requires mySQL access
-->
<?php
session_start(); // For our min and max indices
include_once('../header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
// NOTE: because we're down a directory, we use '../header.php' instead of '/header.php' - If we went down another directory,
// it would become ../../header.php. Just something to note if you're creating a new folder somewhere
?>
<body>
<div id="container">
<h1> Chapin Hall Points - Points Approval </h1>

<?php
	// first up, retireve our session variables.
	$minindex=$_SESSION['minindex'];
	$maxindex=$_SESSION['maxindex']; 
	
	// fire up SQL - This code should look familiar by now. I should really make this a function... meh. Too much trouble.
	// Edit - I made it a function. I guess I'm not that lazy after all
	$connection = connect_to_mySQL(); // defined in header.php
	
	// now create a loop, running from the lowest index to the highest
	// Some indices (in rare cases) may not have an approval/rejection status, but most will
	// for each that does, send an SQL query to modify the approval/rejection status accordingly
	$j=0;
	for ( $i = $minindex ; $i <= $maxindex ; $i++){
		if (!empty($_POST["$i"])){ // if there is a new approval/rejection stored in post to send to mySQL
			$status=$_POST["$i"];
			// generate an SQL query to update the approval status of the given ID
			$sql = "
			UPDATE Raw_Submissions
			SET Approval_Status = '$status'
			WHERE Submission_ID = '$i';";
			// run the query
			if (!mysql_query($sql)) {
				die('Error:' . mysql_error());
			}
			$j++; // keep track of how many records we're updating, because.
		}
	}
	echo $j." records submitted successfully <br />";
?>

<a href="http://chapin-points.net16.net/admin/AdminPage1.php"> Return to Admin Home Page </a>


</div>
<?php
include('../footer.php'); // footer info remains constant. See note on header of this page
session_unset(); // don't want any carryover data spilling out anywhere. This is probably unnecessary, but a good idea
?>


</html>
</body>
</html>