<?php


session_start();

$pTitle = "Movies";
if (!isset($_SESSION['cID'])) {
    include('required/navBarOut.php');
} else {
    include('required/navBar.php');
}

if (isset($_GET['mPage'])) $mPage = $_GET['mPage'];
else{
    $mPage=1;
}

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


// Returns the top 10 Movies
$sql = "SELECT m.mName,m.mDescription,m.mPrice,m.mID,m.mPoster,t.mID,count(t.mID) as count
		FROM Transactions as t
		left join Movies as m using(mID)
		group by t.mID 
		order by count(t.mID) desc 
		limit " . (($mPage*10)-10) . "," . ($mPage*10);
$result = mysqli_query($db, $sql);
echo('
<div id="movie_entry" style="text-align: left;">
<button type="button"><a href="movies.php?mPage=' . ($mPage-1) . '">Back</a>
<button type="button"><a href="movies.php?mPage=' . ($mPage+1) . '">Next</a>
</div>
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
echo('
<div id="movie_entry" style="text-align: left;">
<button type="button"><a href="movies.php?mPage=' . ($mPage-1) . '">Back</a>
<button type="button"><a href="movies.php?mPage=' . ($mPage+1) . '">Next</a>
</div>
');
include('required/footer.html'); 
?>