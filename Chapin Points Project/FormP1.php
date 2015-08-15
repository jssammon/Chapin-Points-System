<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
First page of the main points submission form.
Collects name, netid, and category
-->
<?php
session_start(); // We'll keep some variables across pages
include_once('header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
?>

<body>
<div id="container">
<h1> Chapin Hall Points Submission Form </h1>
<p> The complete points policy may be found <a href="http://chapinhall.weebly.com/points-policy.html"> here</a><br />
<a href="http://chapinhall.weebly.com/"> Return to Chapin Hall site</a><br />
<a href="http://chapinpointssubmission.webuda.com/default.php"> Return to Point homepage</a><br />
</p>

<form action="FormP2.php" method="post"> <!-- This is the main form block (Part 1) -->

<!-- Input Name-->
Name:  <input type="text" name="name" size="40" required value="<?php if (!empty($_SESSION['name'])){ echo $_SESSION['name'];}?>">
	   <span class="error">*</span>
	   <br /> <br />

<!-- Input NetID-->
NetID: <input type =text" name="netid" size="6" required value="<?php if (!empty($_SESSION['netid'])){ echo $_SESSION['netid'];}?>">
	   <span class="error">*</span>
	   <br /> <br />
<!-- Note: The value="?php... sections above just supply a default value if you're returning to this page during the same session.-->
	   
	   
<!-- Input Points Category (If you're adding new categories of points or reshuffling
Exec roles, you may have to edit this accordingly) -->
Points Category :
<select name="category">

<option value="Academic">Academic</option>
<option value="Communications">Communications</option>
<option value="Fellows">Fellows</option>
<option value="Cultural">Cultural</option>
<option value="History">History/Archive</option>
<option value="Sports">IM Sports</option>
<option value="Northwestern">Northwestern</option>
<option value="Philanthropy">Philanthropy</option>
<option value="Social">Social</option>
<option value="Other">Other</option>

</select> <br /> <br />

<input type="submit" name='submit' value="Continue">
</form>
</div>
<?php
include('footer.php'); // footer info remains constant
?>

</body>
</html>