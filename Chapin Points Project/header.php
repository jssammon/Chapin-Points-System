<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- This header file replaces the opening <html> tag plus the <head></head> section -->
<!--
Adds some basic heading information. Provides several necessary functions used elsewhere for connection and input handling

requires mySQL access
-->
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta name="robots" content="noindex" charset="utf-8" http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<title>Chapin Points Submission Site</title>

<!-- CSS stylesheet, default for now-->
<!-- <link rel="stylesheet" type="text/css" href="http://www.000webhost.com/images/index/styles.css" /> -->
<link rel="stylesheet" type="text/css" href="http://chapin-points.net16.net/styles.css" />
<!-- Additional style (error in form) - may be incorporated in CSS later-->



<!-- A section courtesy of https://jqueryui.com/datepicker/ . This runs our "datepicker" input field -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<!-- This next part is really inelegant. But I've already learned PHP, SQL, and HTML, I really, really
don't want to learn JavaScript, too -->
<script>
$(function() {
	var pickerOpts = {
        dateFormat: $.datepicker.ATOM
    };
	$( "#datepicker" ).datepicker(pickerOpts);
});
</script>
<script>
$(function() {
	var pickerOpts = {
        dateFormat: $.datepicker.ATOM
    };
	$( "#datepicker2" ).datepicker(pickerOpts);
});
</script>
<script>
$(function() {
	var pickerOpts = {
        dateFormat: $.datepicker.ATOM
    };
	$( "#datepicker3" ).datepicker(pickerOpts);
});
</script>
<script>
$(function() {
	var pickerOpts = {
        dateFormat: $.datepicker.ATOM
    };
	$( "#datepicker4" ).datepicker(pickerOpts);
});
</script>
<!-- end cited section-->

</head>
<?php
	// Also a function: This will prevent most low-effort hacking. Not that I anticipate anyone trying,
	// But on the off-chance anyone reads XKCD and wants to try the "Bobby Tables" attack, this will stop it.
	// Too obscure a reference for the Humanities Res College?
	// Anyways, call this on any raw inputted data before doing anything with it. It's like a condom for your webform.
	
	function connect_to_mySQL() {
		$server = "mysql11.000webhost.com";
		$username = "a5454234_admin";
		$password = "chapin726";
		$dbname = "a5454234_Points";
		// connect to mySQL, as per usual
		$connection = mysql_connect($server,$username,$password);
		// Check connection
		if (!$connection) {
			die(" :( Connection failed: " . mysql_error());
		}
		// select a database
		$db_selected = mysql_select_db($dbname, $connection);
		if (!$db_selected){
			die('Cannot connect to ' . $db_name . ': '.mysql_error());
		}
		return $connection;
	}
	
	function sanitize_input($data) {
	$connection = connect_to_mySQL();
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysql_real_escape_string($data);
	mysql_close($connection);
	return $data;
	}
	
	
	// And here, our standard connection variables
	$server = "mysql11.000webhost.com";
	$username = "a5454234_admin";
	$password = "chapin726";
	$dbname = "a5454234_Points";
?>

