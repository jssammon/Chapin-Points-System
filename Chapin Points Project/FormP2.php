<!DOCTYPE html PUBLIC>
<!--
Second page of the main form (Handler for FormP1.php)
collects event, points (if applicable), date, description
Also collects the name, netid, and category from $_SESSION
-->
<?php
session_start(); // We'll keep some variables across pages
include_once('header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
					   // This also defines the function sanitize_input, if you're looking for that.
?>
<body>
<div id="container">
<h1> Chapin Hall Points Submission Form </h1>
<br />
<a href="http://chapinpointssubmission.webuda.com/FormP1.php"> Go Back</a><br /><br />
<?php
	// get the 3 variables requested
	$name    = sanitize_input($_POST['name']);
	$netid   = strtolower(sanitize_input($_POST['netid']));
	$category= sanitize_input($_POST['category']);
	
	// Save them to the session, which persists between pages. $_POST isn't that reliable... I think.
	$_SESSION['name']=$name;
	$_SESSION['netid']=$netid;
	$_SESSION['category']=$category;
	
	// Write out the data recieved, roughly where it was on the previous page. Mostly for effect, also helps accuracy.
	echo "Name: $name <br /><br /> NetID: $netid <br /><br /> Category: $category <br /><br />";
	
	// Now for the fun part: A big-ass switch statement, controlling what form boxes appear
	// note the weaving in and out of PHP. This doesn't feel like it should be legal, let alone syntactically accurate
	
	// The cryptic "ac1 ... cu4 ... ph2 notation is standardized shorthand to reduce errors: the first two letters of the points
	// category plus a unique event ID number, which is the same as its position (within the category) on the official list here:http://chapinhall.weebly.com/points-policy.html
	// the system can be easily adapted to any points policy list
	?>
	<form action="FormP3.php" method="post">
	<?php
	
	switch($category) {
			case 'Academic':
				?>
				Event: <select name="event">
					<option value="ac1">Attending a Fireside</option>
					<option value="ac2">Snacks for a Fireside</option>
					<option value="ac3">Arranging a Fireside</option>
					<option value="ac4">Hosting a Fireside</option>
				</select> <span class="error">*</span> <br /> <br />
				Description:<br />
				<input type="text" name="info"  size="40"> <br /> <br />
				<?php
				break;
			case 'Communications':
				?>
				Event: <select name="event">
					<option value="co1">Writing the Flux</option>
				</select> <span class="error">*</span> <br /> <br />
				Description:<br />
				<input type="text" name="info"  size="40"> <br /> <br />
				<?php
				break;
			case 'Fellows':
				?>
				Event: <select name="event">
					<option value="fe1">Fellows Lunch</option>
					<option value="fe2">Master's Table</option>
					<option value="fe3">Thirs-Tea Thursday</option>
				</select> <span class="error">*</span> <br /> <br />
				Description <i>(If you said Master's Table, include which fellow was hosting)</i>:<br />
				<input type="text" name="info"  size="40"> <br /> <br />
				<?php
				break;
			case 'Cultural':
				?>
				Event: <select name="event">
					<option value="cu1">Chapin/RCB cultural event</option>
					<option value="cu2">Non-Chapin/RCB cultural event</option>
					<option value="cu3">Planning off-campus event</option>
					<option value="cu4">Performing at the Coffeehouse</option>
				</select> <span class="error">*</span> <br /> <br />
				Description:<br />
				<input type="text" name="info"  size="40"> <br /> <br />
				<?php
				break;
			case 'History':
				?>
				Event: <select name="event">
					<option value="hi1">Taking photos of Chapin event</option>
					<option value="hi2">Producing Chapin video</option>
				</select> <span class="error">*</span> <br /> <br />
				Description:<br />
				<input type="text" name="info"  size="40"> <br /> <br />
				<?php
				break;
			case 'Sports':
				?>
				Event: <select name="event">
					<option value="sp1">Participating in a game</option>
					<option value="sp2">Spectating a game</option>
				</select> <span class="error">*</span> <br /> <br />
				Sport:<br />
				<input type="text" name="info"  size="40"> <br /> <br />
				<?php
				break;
			case 'Northwestern':
				?>
				Event: <select name="event">
					<option value="no1">Northwestern sports game</option>
					<option value="no2">Homecoming Parade</option>
					<option value="no3">Representing Chaping at activities fair</option>
				</select> <span class="error">*</span> <br /> <br />
				Description <i>(If you picked Northwestern sports game, include what sport and against who?)</i>:<br />
				<input type="text" name="info"  size="40"> <br /> <br />
				<?php
				break;
			case 'Philanthropy':
				?>
				Event: <select name="event">
					<option value="ph1">Chapin Philanthropy</option>
					<option value="ph2">Non-Chapin philanthropy</option>
					<option value="ph3">DM participation or fundraising</option>
					<option value="ph4">Dancing on Chapin's DM team</option>
					<option value="ph5">DM event (trivia, scavenger hunt, etc)</option>
				</select> <span class="error">*</span> <br /> <br />
				Description:<br />
				<input type="text" name="info"  size="40"> <br /> <br />
				Hours of Philanthropy <i>(if applicable)</i>
				<input type="number" name="points" size="2"> <br /> <br />
				<?php
				break;
			case 'Social':
				?>
				Event: <select name="event">
					<option value="so1">Hosting Munchies</option>
					<option value="so2">Hosting non-Munchies event</option>
					<option value="so3">Baking for the happiness of others</option>
				</select> <span class="error">*</span> <br /> <br />
				Description <i>(include what event if applicable)</i>:<br />
				<input type="text" name="info"  size="40"> <br /> <br />
				<?php
				break;
			case 'Other':
				?>
				Event: <select name="event">
					<option value="ot1">Student Project</option>
					<option value="ot2">Rabid Rabbit Award</option>
					<option value="ot3">Other (Petition)</option>
				</select> <span class="error">*</span> <br /> <br />
				Description <i>(include duration of project, if applicable; For a petition, be as descriptive as possible)</i>:<br />
				<textarea name="info" rows="3" cols="60"></textarea><br /><br />
				Points requested <i>(If submitting for a student project, enter one point per day)</i>:
				<input type="number" name="points" size="2" step="1" min=0> <br /> <br />
				<?php
				break;
			default:
				echo "Oops, something went wrong. Please contact your VP."; // Let's hope this doesn't happen
	}
		
	?>
	<!-- Common form elements:  -->
	<!-- Date -->
	<!-- In a perfect world, I would use <input type="date" />, which works beautifully in chrome and edge. Not so in firefox or ie. So I borrowed a public script-->
	<!-- Check the <header> of header.php for more info-->
	Date: <input type="text" name="date" id="datepicker" required />
	<span class="error">*</span>	<br /> <br />
	
	<!-- Submit button-->
	<input type="submit" name='submit' value="Submit">
	</form> <br />
	
</div>


<?php
include('footer.php'); // footer info remains constant
?>

</body>
</html>