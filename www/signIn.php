<?php
session_start();
$pTitle = "SignIn";
include('required/navBarOut.php');

if (isset($_SESSION['cID'])) {
    header("Location: account.php");
}

if (!isset($err)) {
    $err = array();
};

if (isset($err) && !empty($err)) {
    echo '<p id="errMsg">There was a problem:<br>';
    foreach ($err as $errMsg) {
        echo " $errMsg<br>";
    }
    echo('Please try again or <a href="signUp.php">SignUp</a></p>');
};
?>
<div class="section" align="center">
    <h1>Sign In</h1>
    <form action="signIn_action.php" method="post">
    <div class="form-group">
            <label for="email">Email</label>
            <div class="row">
                <div class="col">
        <input type="text" name="cEmail" required>
    </div></div></div>
    <div class="form-group">
            <label for="password">Password</label>
            <div class="row">
                <div class="col">
        <input type="password" name="cPass" required>
        </div></div></div>
        <div class="checkbox">
            <label>
                <p>New User? <a href="signUp.php">Sign Up!</a>
            </label>
        </div>
        <button type="submit" role="button"> Sign In
        </button>
        <hr>
    </form>
    <?php include('required/footer.html'); ?>
