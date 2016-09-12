<!DOCTYPE html PUBLIC>
<?php
include_once('../header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
// NOTE: because we're down a directory, we use '../header.php' instead of '/header.php' - If we went down another directory,
// it would become ../../header.php. Just something to note if you're creating a new folder somewhere
?>
<body>
<div id="container">
<h1> Chapin Hall Points - Set Quarter Dates </h1>

<?php
$year = $_POST["year"];
$startfall=$_POST["StartFall"];
$endfall=$_POST["EndFall"];
$endwinter=$_POST["EndWinter"];
$endspring=$_POST["EndSpring"];

// The usual SQL connection code:
$connection = connect_to_mySQL(); // defined in header.php

// Erase any record that exists for $year
$sql = "DELETE FROM Quarter_Dates WHERE Year=$year";
// Run the query
if (!mysql_query($sql)) {
   die('Error:' . mysql_error());
}

// assemble a query to insert the (updated) record
$sql = "INSERT INTO Quarter_Dates (Year, Start, End_Fall, End_Winter, End_Spring) VALUES ('$year', '$startfall', '$endfall', '$endwinter', '$endspring');";
// Run the query
if (!mysql_query($sql)) {
   die('Error:' . mysql_error());
}
else{
	echo "The quarter dates have been submitted successfully <br /><br />";
}

// Close out the connection; we only needed the one SQL query
mysql_close($connection);


?>
<a href="http://chapin-points.net16.net/admin/AdminPage1.php"> Return to Admin Home Page </a>

</div>
<?php
include('../footer.php'); // footer info remains constant. See note on header of this page
?>


</html>
</body>
</html>