<!DOCTYPE html PUBLIC>
<!--
Lead-in page to the master list generator. Allows an admin to select the year for the master list.
-->
<?php
//session_start(); // Not sure if I'll be using this for this part of the page or not. Left commented until needed
include_once('../header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
?>
<body>
<div id="container">
<h1> Chapin Hall Points - Points Summary </h1>

<a href="http://chapin-points.net16.net/admin/AdminPage1.php"> Return to Admin Home Page </a><br />
<?php
	
	// Get the current year
	$currentmonth= date('n'); // n is format symbol for numerical month, no leading zeros 
	$currentyear = date('Y'); // Y is format symbol for numerical year, 4 digits
	// if it's July or later, we can assume it's fall quarter, and the year is correct.
	// If it's earlier than that, it's winter or spring, and the current year is not
	// the same as the school year as held by the database (That is defined as the year of fall quarter)
	// (See 'AdminSetDates.php for clarification if this doesn't make sense)
	if ($currentmonth <=7) {
		$currentyear--; // the year of fall quarter was the numerical year before 'now'
	}
	
?>
<p>Enter year. This should be the year of fall quarter, so if you want the records for the 2015-2016 school year,
you should enter "2015"</p>

<form action="AdminTotals2.php" method="post">
<input type ="number" name="year" size="4" required value="<?php echo $currentyear;?>">
<br /> <br />
<input type="submit" name='submit' value="Continue">
</form>


</div>
<?php
include('../footer.php'); // footer info remains constant. See note on header of this page
?>


</html>
</body>
</html>