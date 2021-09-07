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

$sql = "DELETE FROM Customers WHERE cID =" . $_SESSION['cID'];

if (mysqli_query($db, $sql)) {
    echo('
	<div class="section">
	<p> Customer account deleted<p>
	<button type="button">
	<a href="signIn.php": white;">Sign In</a>
	</button>
	</div>
	');
    session_destroy();
} else {
    echo("error deleting account " . mysqli_error($db));
}
?>