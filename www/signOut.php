<?php
session_start();

if (!isset($_SESSION['cID'])) {
    require('signIn_tools.php');
    loadPage();
}

$pTitle = 'SignOut';
include('required/navBarOut.php');
$_SESSION = array();
session_destroy();
?>
<div class="section"><h1>See you later!</h1>
    <p>You are now signed out.</p>
</div>
<?php include('required/footer.html'); ?>
