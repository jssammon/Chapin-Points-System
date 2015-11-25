<!DOCTYPE html PUBLIC>
<!--
Homepage for the Admin half of the site. Provides links to the rest of the functions. Primarily HTML
-->
<?php
include_once('../header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
// NOTE: because we're down a directory, we use '../header.php' instead of '/header.php' - If we went down another directory,
// it would become ../../header.php. Just something to note if you're creating a new folder somewhere
?>
<body>
<div id="container">
<h1> Chapin Hall Points - Administrative Page </h1>
<br>
<b><u> Internal Links </b></u>
<ul>
<li><a href="http://chapinpointssubmission.webuda.com/admin/AdminApproval.php"> Approve/Reject points</a></li>
<li><a href="http://chapinpointssubmission.webuda.com/admin/AdminTotals.php"> Get point totals and subtotals</a></li>
<li><a href="http://chapinpointssubmission.webuda.com/admin/AdminSetDates.php"> Set quarter start/end dates </a></li>
<li><a href="http://chapinpointssubmission.webuda.com/CheckPoints.php"> Get point record by NetID (Public Page) </a></li>
<li><a href="http://chapinpointssubmission.webuda.com/default.php"> Points homepage (Public Page) </a></li>
</ul>
<b><u> External Links </b></u>
<ul>
<li><a href="http://members.000webhost.com/login.php"> Site Management Login</a></li>
</ul>

</div>
<?php
include('../footer.php'); // footer info remains constant. See note on header of this page
?>


</html>
</body>
</html>