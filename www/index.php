<?php
session_start();
$pTitle = "Home";
require('required/connect_db.php');

if (!isset($_SESSION['cID'])) {
    include('required/navBarOut.php');
} else {
    include('required/navBar.php');
}

$sql = "SELECT * FROM Movies WHERE mPoster != 'NULL' ORDER BY mYear DESC LIMIT 12";
$result = mysqli_query($db, $sql);
echo('
<body>
<h3>Welcome to the Heriot-Watt Movie Store.</h3>
<h3>The newest releases</h3>
');

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo('
			<div class="form-group">
				<img src="' . $row['mPoster'] . '" title="' . $row['mName'] . '" style="float: left; width: 24%; margin-right: 1%; margin-bottom: 0.5em;">						
			</div>
		');
    };
};
mysqli_close($db);
include('required/footer.html');
?>