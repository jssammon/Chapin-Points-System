<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Chapin Points Submission Form</title>
<link rel="stylesheet" type="text/css" href="http://www.000webhost.com/images/index/styles.css" />
</head>

<body>
<h1> Chapin Hall Points Submission Form </h1>
<p> The complete points policy may be found <a href="http://chapinhall.weebly.com/points-policy.html"> here </a> <br />
<a href="http://chapinhall.weebly.com/"> Return to Chapin Hall site </a> <br />
</p>
<div id="container">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> <!-- This is the main form block (Part 1) -->

<!-- Input Name-->
Name:  <input type="text" name="name"  size="40"> <br /> <br />

<!-- Input NetID-->
NetID: <input type =text" name="netid" size="6">  <br /> <br />

<!-- Input Points Category (If you're adding new categories of points or reshuffling
Exec roles, you may have to edit this accordingly) -->
Points Category :
<select name="PointsCategory">

<option value="Academic">Academic</option>
<option value="Communications">Communications</option>
<option value="Fellows">Fellows</option>
<option value="Cultural">Cultural</option>
<option value="History">History/Archive</option>
<option value="Sports">IM Sports</option>
<option value="Northwestern">Northwestern</option>
<option value="Philanthropy">Philanthropy</option>
<option value="Social">Social</option>
<option value="Project">Student Project</option>
<option value="Award">Rabid Rabbit Award</option>

</select> <br /> <br />

<input type="submit" name='submit' value="Submit">
</form>
<?php
/* if the "submit" variable does not exist, the form has not been submitted - display initial page */
if (isset($_POST['submit'])) {

    
	/* if the "submit" variable exists, the form has been submitted - look for and process form data */
    // Store the variables
    $name = $_POST['name'];
	$netid= $_POST['netid'];
	// Display
	echo "Name: $name <br /> NetID: $netid";
}
?>

</div>
<div id="copy">
Form created by Jonathan Sammon &copy; 2015
Free <a href="http://www.hosting24.com/">Web Hosting</a> by <a href="http://www.000webhost.com/">www.000webhost.com</a>

</div>
</body>
</html>
<!-- Hosting24 Analytics Code -->
<script type="text/javascript" src="http://stats.hosting24.com/count.php"></script>
<!-- End Of Analytics Code -->
</body>
</html>