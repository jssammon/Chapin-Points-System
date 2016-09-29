<!DOCTYPE html PUBLIC>
<!--
Third page of the main form (Handler for FormP2.php)
Submits all data collected on the first two pages to mySQL as a raw record

requires mySQL access
-->
<?php
session_start(); // We'll keep some variables across pages
include_once('header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
?>
<body>
<div id="container">
<h1> Chapin Hall Points Submission Form </h1>

<?php
// collect all the variables submitted. This requires some work.
$name    = $_SESSION['name'];		// from P1
$netid   = $_SESSION['netid'];		// from P1
$category= $_SESSION['category'];	// from P1
$event	 = sanitize_input($_POST['event']);
$date = sanitize_input($_POST['date']);
if (!empty($_POST['info'])){
	$info = sanitize_input($_POST['info']);
}
else {
	$info = "";
}
if (!empty($_POST['points'])){
	$points = sanitize_input($_POST['points']);
}
else {
	$points = 0; //meaningless default value
}
// Assign points. This switch mirrors the one on page two nicely. You may ask why I chose to assign
// events a cryptic code there only to translate the code back to English here, to which I have
// no solid explanation, but a well-trained programming intuition that this is far harder to screw 
// up when updating the points system. I could, however, be completely wrong.
// 
// note how the English goes to the database; the code stays behind in the PHP

// points assumed unrestricted unless otherwise proven guilty. This is 'MURICA!
$restricted = FALSE;
switch($event) {
	// Academic Events
	case 'ac1':
		$points = 3;
		$event = 'Attending a fireside';
		break;
	case 'ac2':
		$points = 2;
		$event = 'Snacks for a fireside';
		break;
	case 'ac3':
		$points = 5;
		$event = 'Arranging a a fireside';
		break;
	case 'ac4':
		$points = 10;
		$event = 'Hosting a fireside';
		break;
		
	//Communications Events
	case 'co1':
		$points = 4;
		$event = 'Writing the Flux';
		break;
		
	// Fellows Events
	case 'fe1':
		$points = 2;
		$event = 'Fellows lunch';
		break;
	case 'fe2':
		$points = 2;
		$event = 'Dinner at the Master\'s Table';
		break;
	case 'fe3':
		$points = 2;
		$event = 'Thirs-Tea Thursday';
		break;
	
	// Cultural Events
	case 'cu1':
		$points = 3;
		$event = 'Chapin/RCB cultural event';
		break;
	case 'cu2':
		$points = 2;
		$event = 'Non-Chapin/RCB cultural event';
		$restricted = TRUE;
		break;
	case 'cu3':
		$points = 10;
		$event = 'Planning off-campus event';
		break;
	case 'cu4':
		$points = 4;
		$event = 'Performing at the Coffeehouse';
		break;
		
	// History/Archive
	case 'hi1':
		$points = 2;
		$event = 'Taking photos of Chapin event';
		break;
	case 'hi2':
		$points = 10;
		$event = 'Producing Chapin video';
		break;
		
	// IM Sports
	case 'sp1':
		$points = 4;
		$event = 'Participating in a game';
		break;
	case 'sp2':
		$points = 2;
		$event = 'Spectating a game';
		break;
		
	//Northwestern
	case 'no1':
		$points = 1;
		$event = 'Northwestern sports game';
		$restricted = TRUE;
		break;
	case 'no2':
		$points = 1;
		$event = 'Homecoming parade';
		break;
	case 'no3':
		$points = 1;
		$event = 'Representing Chapin at activities fair';
		break;
		
	// Philanthropy
	case 'ph1':
		$points = round(2*$points);
		$event = 'Chapin philanthropy';
		break;
	case 'ph2':
		$points = round(2*$points);
		$event = 'Non-Chapin philanthropy';
		$restricted = TRUE;
		break;
	case 'ph3':
		$points = 5;
		$event = 'DM participation or fundraising';
		break;
	case 'ph4':
		$points = 10;
		$event = 'Dancing on Chapin DM team';
		break;
	case 'ph5':
		$points = 2;
		$event = 'DM event';
		break;
	
	// social events
	case 'so1':
		$points = 3;
		$event = 'Hosting munchies';
		break;
	case 'so2':
		$points = 5;
		$event = 'Hosting non-munchies event';
		break;
	case 'so3':
		$points = 1;
		$event = 'Baking for happiness of others';
		break;
	
	// Other
	case 'ot1':
		$points = round($points);
		$event = 'Student project';
		break;
	case 'ot2':
		$points = 5;
		$event = 'Rabid Rabbit Award';
		break;
	case 'ot3':
		//$points = $points;// already assigned... obviously
		$event = 'Petition';
		break;
	default:
		$points = round($points);
		$event = 'ERROR: EVENT NOT FOUND';
		break;
}
// Prevent Mischief. As a coder, you should spend at least 40% of your time thinking about how to ruin your own day.
// In this case, since there's no validation that a submitter is the owner of the submitted netid, it is possible
// to submit negative points for your nemesis. This **should** be caught manually during validation, but no point
// in letting anyone try to slip it through. Also note that the min attribute on the points fields **should** prevent
// this in the first place, but that doesn't work in a few browsers.
if ($points<0){
	$points = 0;
}


// End data reading

// Write to mySQL

$connection = connect_to_mySQL(); // defined in header.php

// Assemble a query. This text is SQL, with some php variables names - anything in "double quotes" is interpreted,
// so things like $name are evaluated before being sent to the database.
$sql = "INSERT INTO Raw_Submissions (Name, NetID, Category, Event, Date, Additional_Info, Points, Restricted) VALUES ('$name', '$netid', '$category', '$event', '$date', '$info', '$points', '$restricted');";
if (!mysql_query($sql)) {
   die('Error:' . mysql_error());
}
else{
	echo "Your point record has been submitted successfully. <br />";
}

// Close out the connection; we only needed the one SQL query
mysql_close($connection);

// echo back what you discovered - A nice final overview of what was submitted
if ($restricted==TRUE){
	$restricted_text = '(restricted)';
}
else{
	$restricted_text = '(unrestricted)';
}
if ($date == ""){
	$date_text = "";
}
else {
	$date_text = "on {$date} ";
}
echo 
"Submission: <br />
{$name}  ({$netid}) <br />
{$event} ({$category}) {$date_text}for {$points} points {$restricted_text} <br /> <br />";

// Finished with PHP
?>

<!-- A nice little button to take you back to the start-->
<form action="http://chapin-points.net16.net/FormP1.php">
    <input type="submit" value="Submit another record">
</form>

</div> <!-- Our main container div-->

<?php
include('footer.php'); // footer info remains constant
?>


</html>
</body>
</html>