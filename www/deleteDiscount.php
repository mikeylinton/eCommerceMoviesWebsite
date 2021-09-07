<?php
session_start();
$pTitle = "Delete account?";
require('required/connect_db.php');

if (!isset($_SESSION['cID'])) {
    header("Location: signIn.php");
}

if (!isset($_SESSION['cID'])) {
    include('required/navBarOut.php');
} else {
    include('required/navBar.php');
}
?>
<div class="form-group">
<img src="images/leaving.jpeg" style="float: center; width: 100%; margin-right: 1%; margin-bottom: 0.5em;">
<a href="discount.php">
    <img src="images/notLeaving.jpeg" style="float: left; width: 49%; margin-right: 1%; margin-bottom: 0.5em;">
</a>
<a href="delete.php">
    <img src="images/goodbye.jpeg" style="float: right; width: 49%; margin-right: 1%; margin-bottom: 0.5em;">
</a>
</div>
<br>
<?php include('required/footer.html'); ?>