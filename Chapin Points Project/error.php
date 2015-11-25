<?php

include("header.php");

$error = $_POST['error'];

?>

<body>

<div id="container">
<h1>Error thrown!</h1>

<p>An error was thrown.</p>

<pre>

<?php print $error;?>

</pre>



</div>
</body>


<?php

include("footer.php");

 ?>
