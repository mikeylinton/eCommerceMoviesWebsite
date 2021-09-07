<?php
require('required/connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('signIn_tools.php');
    list ($check, $data) = validEmailPassword($db, $_POST['cEmail'], $_POST['cPass']);

    if ($check) {
        session_start();
        $_SESSION['cID'] = $data['cID'];
        $_SESSION['cForename'] = $data['cForename'];
        $_SESSION['cSurname'] = $data['cSurname'];
        $_SESSION['cEmail'] = $data['cEmail'];
        loadPage('account.php');
    } else {
        $err = $data;
        header("Location: signIn.php");
    }

    mysqli_close($db);
} else {
    header("Location: signIn.php");
}
?>