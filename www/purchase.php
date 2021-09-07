<?php
$pTitle = "Purchase";
session_start();

if (!isset($_SESSION['cID'])) {
    require('signIn_tools.php');
    loadPage();
}
$cID=$_SESSION['cID'];
include('required/navBar.php');

if (isset($_GET['mID'])) $mID = $_GET['mID'];

require('required/connect_db.php');

$customer = $_SESSION['cID'];
$sql = "SELECT * FROM Customers WHERE cID =" . $customer;
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $discount=$row['cDiscount'];
    }
}

if ($discount=='1'){
    $discount=true;
} else {
    $discount=false;
}

$tDate=date("Y-m-d");
$sql = "INSERT INTO Transactions (mID, cID, tDate) VALUES ('$mID','$cID','$tDate')";
$result = @mysqli_query($db, $sql);
if ($result) {
    $sql = "SELECT * FROM Movies WHERE mID=$mID";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) == '1') {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo('
        <div id="movie_entry" style="text-align: center;">
        <img src="' . $row['mPoster'] . '" style="float: left; width: 30%; margin-right: 1%; margin-bottom: 0.5em;">
        ');
        if ($discount){
            $sql = "UPDATE Customers SET cDiscount=0 WHERE cID =" . $_SESSION['cID'];
            if (mysqli_query($db, $sql)){
                echo('<h1>Thank you for buying: \'' . $row["mName"] . '\' for $' . ($row["mPrice"]/2) . '</h1>');
            }
        } else {
            echo('<h1>Thank you for buying: \'' . $row["mName"] . '\' for $' . $row["mPrice"] . '</h1>');
        }
        echo('
        <br>
        <h3>Buy more movies to improve your movie recommendations!</h3>
        </div>
        ');
        
    }
}

mysqli_close($db);
include('required/footer.html'); 
?>