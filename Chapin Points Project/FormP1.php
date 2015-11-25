<?php
session_start(); // We'll keep some variables across pages
include_once('header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
?>
<!--
First page of the main points submission form.
Collects name, netid, and category
-->
<body>
<div id="container">
<h1> Chapin Hall Points Submission Form </h1>
<p> The complete points policy may be found <a href="http://chapinhall.weebly.com/points-policy.html"> here</a><br />
<a href="http://chapinhall.weebly.com/"> Return to Chapin Hall site</a><br />
<a href="/default.php"> Return to Point homepage</a><br />
</p>

<form action="FormP2.php" method="post" class="form1"> <!-- This is the main form block (Part 1) -->

<!-- Input Name-->
Name: <input type="text" name="name" size="40" required value="<?php if (!empty($_SESSION['name'])){ print $_SESSION['name'];}?>">
	  <span class="error">*</span>
	  <br /> <br />

<!-- Input NetID-->
NetID: <input type="text" name="netid" size="6" required maxlength="6" value="<?php if (!empty($_SESSION['netid'])){ print $_SESSION['netid'];}?>">
	  <span class="error">*</span>
	  <br /> <br />
<!-- Note: The value="?php... sections above just supply a default value if you're returning to this page during the same session.-->

<div class="form1-points-category">
<!-- Input Points Category (If you're adding new categories of points or reshuffling
Exec roles, you may have to edit this accordingly) -->
<p class="points-category-label">Points Category:</p>

<div class="form1-category">

<label><input type="radio" name="category" value="Academic" />Academic</label>
<label><input type="radio" name="category" value="Communications" />Communications</label>
<label><input type="radio" name="category" value="Fellows" />Fellows</label>
<label><input type="radio" name="category" value="Cultural" />Cultural</label>
<label><input type="radio" name="category" value="History" />History/Archive</label>
<label><input type="radio" name="category" value="Sports" />IM Sports</label>
<label><input type="radio" name="category" value="Northwestern" />Northwestern</label>
<label><input type="radio" name="category" value="Philanthropy">Philanthropy</label>
<label><input type="radio" name="category" value="Social" />Social</label>
<label><input type="radio" name="category" value="Other" />Other</label>

</div>

</div>

<input type="submit" name='submit' value="Continue">
</form>
</div>
<?php
include('footer.php'); // footer info remains constant
?>

</body>
</html>
