<!DOCTYPE html PUBLIC>
<!--
Form for submitting dates for quarter start and end times. Primarily HTML
-->
<?php
include_once('../header.php'); // header info (CSS, etc) is consistent. This will make updating style easier. I think.
// NOTE: because we're down a directory, we use '../header.php' instead of '/header.php' - If we went down another directory,
// it would become ../../header.php. Just something to note if you're creating a new folder somewhere
?>
<body>
<div id="container">
<h1> Chapin Hall Points - Set Quarter Dates </h1>
<p> Use this form to set the start and end dates of the year's quarters. This information
will be used to track restricted points per quarter and point totals per year. The dates here
should be chosen carefully - Fall quarter, for example, starts before Wildcat Welcome (before
the academic quarter begins) and should end no earlier than the last day of finals.<a href="http://www.registrar.northwestern.edu/calendars/">
The University Registrar's calendars</a> may be helpful for setting this. Quarter start/end
dates should also be chosen to be during break (<b>not</b> on the exact first or last day) to avoid
ambiguity. </p>

<p> <i> Note: This form should only need to be submitted once per year. If a record already
exists for a given year, the record will be overwritten. </i></p><br />

<form action="AdminSetDates2.php" method="post">

Year in which fall quarter begins: (ie, for the "2015-2016" school year, enter "2015") <br />
<input type="number" name="year" size="4" required> <br />
<br />
Start date for fall quarter: <br />
<input type="text" name="StartFall" id="datepicker" required /><br />
<br />
End date for fall quarter: <br />
<input type="text" name="EndFall" id="datepicker2" required /><br />
<br />
End date for winter quarter: <br />
<input type="text" name="EndWinter" id="datepicker3" required /><br />
<br />
End date for spring quarter: <br />
<input type="text" name="EndSpring" id="datepicker4" required /><br />
<br />
<!-- Thanks to my brute-force, "I don't know how to JavaScript" solution in header.php, we have 4 datepickers available-->
<!-- (If you're wondering why the datepickers are numbered. You need a unique ID per field-->
<input type="submit" name='submit' value="Submit">

</form>

</div>
<?php
include('../footer.php'); // footer info remains constant. See note on header of this page
?>
