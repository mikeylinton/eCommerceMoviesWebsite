<?php
function loadPage($page = 'signIn.php')
{
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    header("Location: $url");
    exit();
}

function validEmailPassword($db, $email = '', $pass = '')
{

    if (!isset($err)) {
        $err = array();
    };

    if (empty($email)) {
        $err[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($db, trim($email));
    }


    if (empty($pass)) {
        $err[] = 'Enter your password.';
    } else {
        $p = mysqli_real_escape_string($db, trim($pass));
    }

    echo($p);


    if (empty($err)) {
        $sql = "SELECT cID,cForename,cSurname FROM Customers WHERE cEmail='$e' AND cPass=SHA1('$p')";
        $result = mysqli_query($db, $sql);

        if (@mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return array(true, $row);
        } else {
            $err[] = 'email address and password not found.';
        }
    }

    return array(false, $err);
}

?>