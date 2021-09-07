<?php
session_start();
$pTitle = "Account";
require('required/connect_db.php');

if (!isset($_SESSION['cID'])) {
    header("Location: signIn.php");
}

include('required/navBar.php');
$customer = $_SESSION['cID'];
$sql = "SELECT * FROM Customers WHERE cID =" . $customer;
$result = mysqli_query($db, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    echo('
	<p>
	<div class="row">
	<div class="col-md-3 col-sm-12">
	<div class="card w-100 text-white bg-dark mb-4">
	<h3> Customer Details</h3><table>
	<tr><td> Customer ID:</td><td>' . $row['cID'] . ' </td></tr>
	<tr><td> Title:</td><td>' . $row['cTitle'] . ' </td></tr>
	<tr><td>First name:</td><td>' . $row["cForename"] . '</td></tr>
	<tr><td>Last name:</td><td>' . $row['cSurname'] . '</td></tr>
	<tr><td>E-mail:</td><td> ' . $row['cEmail'] . '</td></tr>
	<tr><td>Phone Number: </td><td> ' . $row['cPhoneNumber'] . '</td></tr>
	<tr><td>Address Line 1: </td><td> ' . $row['cAddressLine1'] . '</td></tr>
	<tr><td>Address Line 2: </td><td> ' . $row['cAddressLine2'] . '</td></tr>
	<tr><td>City: </td><td> ' . $row['cCity'] . '</td></tr>
	<tr><td>Postcode: </td><td> ' . $row['cPostcode'] . '</td></tr>
	</table>
	</div>
	</div>
	</div>
	</p>
	');
}

mysqli_close($db);
?>
<div class="row">
    <div class="col-md-3 col-sm-12">
        <div class="card w-100 text-white bg-dark mb-4">
            <h5>WARNING! This action cannot be undone.</h5>
            <button type="button">
                <a href="deleteDiscount.php">Delete Account</a>
            </button>
        </div>
    </div>
</div>
<br>
<?php include('required/footer.html'); ?>
