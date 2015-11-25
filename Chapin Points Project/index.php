<!DOCTYPE html PUBLIC>
<!--
Intended to be the main page. Gives links to submit points or to check records

Has the only image on the entire site
-->
<?php
session_start(); // We'll keep some variables across pages
include_once('header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
?>
<body>
<div id="container">
<img src="user-content/Chapin_Crest.png"/>
<h1> Chapin Hall Points System </h1>
<p>

The complete points policy may be found <a href="http://chapinhall.weebly.com/points-policy.html"> here</a><br />
<a href="http://chapinhall.weebly.com/"> Return to Chapin Hall site</a><br />

<form action="/FormP1.php">
    <input type="submit" value="Submit a Record">
</form><br />
<form action="/CheckPoints.php">
    <input type="submit" value="View Your Points">
</form>
</p>
<br />
</div>
<?php
include('footer.php'); // footer info remains constant
?>


</body>
</html>
