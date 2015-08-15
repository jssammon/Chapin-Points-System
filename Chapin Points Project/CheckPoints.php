<!DOCTYPE html PUBLIC>
<!--
lead-in page to check point totals by netID (this is intended as a public page)
-->
<?php
session_start(); // We'll keep some variables across pages
include_once('header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
?>
<body>
<div id="container">
<h1> Chapin Hall Points - View Points </h1>

<form action="CheckPoints2.php" method="post">
NetID: <input type ="text" name="netid" size="6" required value="<?php if (!empty($_SESSION['netid'])){ echo $_SESSION['netid'];}?>">
	   <br /> <br />
<input type="submit" name='submit' value="Continue">
</form>

</div>
<?php
include('footer.php'); // footer info remains constant
?>


</body>
</html>