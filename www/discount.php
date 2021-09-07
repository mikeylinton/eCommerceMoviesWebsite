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

$sql = "UPDATE Customers SET cDiscount=1 WHERE cID =" . $_SESSION['cID'];

if (mysqli_query($db, $sql)) {
    echo('
	<div class="form-group">
    <a href="movies.php">
    <img src="images/discount.jpeg" style="float: center; width: 100%; margin-right: 1%; margin-bottom: 0.5em;">
    </a>
    <br>
	');
} else {
    echo("error applying coupon " . mysqli_error($db));
}

include('required/footer.html'); 
?>