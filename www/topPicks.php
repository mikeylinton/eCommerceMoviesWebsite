<?php
session_start();
$pTitle = "TopPicks";
require('required/connect_db.php');
$discount=true;
if (!isset($_SESSION['cID'])) {
    include('required/navBarOut.php');
} else {
    include('required/navBar.php');
}
$customer = $_SESSION['cID'];
$sql = "SELECT * FROM Customers WHERE cID =" . $customer;
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $cName=$row['cForename'];
        $discount=$row['cDiscount'];
    }
}

if ($discount=='1'){
    $discount=true;
} else {
    $discount=false;
}


#$command_exec = escapeshellcmd('/usr/bin/python3 collab_filtering.py "Emma."');
#$str_output = shell_exec($command_exec);
#echo 'Python Output: ' . $str_output;


$sql = "SELECT * FROM Movies as m, Customers as c WHERE c.cID = " . $customer ." ORDER BY RAND(c.cID) LIMIT 10";
$result = mysqli_query($db, $sql);
echo('
<body>
<h1>Top Picks for ' . $cName . '</h1>
');

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo(
            '<div id="movie_entry" style="text-align: center;">
            <img src="' . $row['mPoster'] . '" style="float: left; width: 30%; margin-right: 1%; margin-bottom: 0.5em;">						
            <h3>' . $row['mName'] . '</h3>
            <p>' . $row['mDescription'] . '</p>
            ');
        if ($discount){
            echo('<p style="text-decoration: line-through; color: red;"> $ ' . $row['mPrice'] . '</p>');
            echo('<p> $ ' . ($row['mPrice']/2) . '</p>');
        }
        else {
            echo('<p> $ ' . $row['mPrice'] . '</p>');
        }
        echo('
            <button type="button"><a href="purchase.php?mID=' . $row['mID'] . '">Buy Now</a>		
		</div>
        ');
    }
    mysqli_close($db);
} else {
    echo('<h2>There are currently no movies available.</h2>');
}
mysqli_close($db);
include('required/footer.html'); 
?>
