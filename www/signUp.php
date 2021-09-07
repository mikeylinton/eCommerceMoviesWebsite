<?php
$pTitle = 'SignUp';
include('required/navBarOut.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('required/connect_db.php');

    if (!isset($err)) {
        $err = array();
    }

    if (!isset($err)) {
        $err = array();
    }

    if (empty($_POST['cTitle'])) {
        $err[] = 'Select a title';
    } else {
        $title = mysqli_real_escape_string($db, trim($_POST['cTitle']));
    }

    if (empty($_POST['cForename'])) {
        $err[] = 'Enter your first name.';
    } else {
        $fn = mysqli_real_escape_string($db, trim($_POST['cForename']));
    }

    if (empty($_POST['cSurname'])) {
        $err[] = 'Enter your last name.';
    } else {
        $ln = mysqli_real_escape_string($db, trim($_POST['cSurname']));
    }

    if (empty($_POST['cEmail'])) {
        $err[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($db, trim($_POST['cEmail']));
    }

    if (empty($_POST['cPhoneNumber'])) {
        $err[] = 'Enter your phone number';
    } else {
        $ph = mysqli_real_escape_string($db, trim($_POST['cPhoneNumber']));
    }

    if (empty($_POST['cAddressLine1'])) {
        $err[] = 'Enter your address line 1';
    } else {
        $al1 = mysqli_real_escape_string($db, trim($_POST['cAddressLine1']));
    }

    if (empty($_POST['cAddressLine2'])) {
        $err[] = 'Enter your address line 2';
    } else {
        $al2 = mysqli_real_escape_string($db, trim($_POST['cAddressLine2']));
    }

    if (empty($_POST['cCity'])) {
        $err[] = 'Enter your city';
    } else {
        $city = mysqli_real_escape_string($db, trim($_POST['cCity']));
    }

    if (empty($_POST['cPostcode'])) {
        $err[] = 'Enter your post code';
    } else {
        $pc = mysqli_real_escape_string($db, trim($_POST['cPostcode']));
    }

    if (!empty($_POST['inPass'])) {
        if ($_POST['inPass'] != $_POST['checkPass']) {
            $err[] = 'Passwords do not match.';
        } else {
            $p = mysqli_real_escape_string($db, trim($_POST['inPass']));
        }
    } else {
        $err[] = 'Enter your password.';
    }

    if (empty($err)) {
        $sql = "SELECT cID FROM Customers WHERE cEmail='$e'";
        $result = @mysqli_query($db, $sql);
        if (mysqli_num_rows($result) != 0) $err[] = 'Email address already Signed Up.<a href="signIn.php">SignIn</a>';
    }

    if (empty($err)) {
        $sql = "INSERT INTO Customers (cTitle,cForename,cSurname,cEmail,cPass,cPhoneNumber,cAddressLine1,cAddressLine2,cCity,cPostcode,cDiscount) VALUES ('$title','$fn','$ln','$e',SHA1('$p'),'$ph','$al1','$al2','$city','$pc','0')";
        $result = @mysqli_query($db, $sql);
        if ($result) {
            echo('<div class="section"><h1>Signed Up!</h1><p>You are now Signed Up.</p><p><a href="signIn.php">SignIn</a></p></div>');
        }
        mysqli_close($db);
        exit();
    } else {
        echo('<h1>Error!</h1><p id="errMsg">The following error(s) occurred:<br>');
        foreach ($err as $msg) {
            echo(" - $msg<br>");
        }
        echo('Please try again.</p>');
        mysqli_close($db);
    }
}
?>
<div class="section">
    <background-color
    =#131313>
    <p class="lead"><i class="fa fa-user-plus"></i> Create New Account</p>
    <form action="signUp.php" method="post">
        <div class="form-group">
            <label for="cTitle">Title</label>
            <div class="row">
                <div class="col">
                    <select name="cTitle" id="cTitle">
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Ms">Ms</option>
                        <option value="Mx">Mx</option>
                        <option value="Dr">Dr</option>
                        <option value="Rev">Rev</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cForename">First Name</label>
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="First name" name="cForename" size="20"
                           value="<?php if (isset($_POST['cForename'])) echo($_POST['cForename']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cSurname">Last Name</label>
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Last name" name="cSurname" size="20"
                           value="<?php if (isset($_POST['cSurname'])) echo($_POST['cSurname']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cEmail">Email</label>
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Email" name="cEmail" size="50"
                           value="<?php if (isset($_POST['cEmail'])) echo($_POST['cEmail']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cPhoneNumber">Phone Number</label>
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Phone Number" name="cPhoneNumber" size="50"
                           value="<?php if (isset($_POST['cPhoneNumber'])) echo($_POST['cPhoneNumber']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cAddressLine1">Address Line 1</label>
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Address Line 1" name="cAddressLine1" size="50"
                           value="<?php if (isset($_POST['cAddressLine1'])) echo($_POST['cAddressLine1']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cAddressLine2">Address Line 2</label>
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Address Line 2" name="cAddressLine2" size="50"
                           value="<?php if (isset($_POST['cAddressLine2'])) echo($_POST['cAddressLine2']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cCity">City</label>
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="City" name="cCity" size="50"
                           value="<?php if (isset($_POST['cCity'])) echo($_POST['cCity']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cPostcode">Postcode</label>
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Postcode" name="cPostcode" size="50"
                           value="<?php if (isset($_POST['cPostcode'])) echo($_POST['cPostcode']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="password">Create Password</label>
            <div class="row">
                <div class="col">
                    <input type="password" placeholder="Create Password" name="inPass" size="20"
                           value="<?php if (isset($_POST['inPass'])) echo($_POST['inPass']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="purchase_password">Confirm Password</label>
            <div class="row">
                <div class="col">
                    <input type="password" placeholder="Confirm Password" name="checkPass"
                           size="20"
                           value="<?php if (isset($_POST['checkPass'])) echo($_POST['checkPass']); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="purchase_password">signUp Now</label>
            <div class="row">
                <div class="col">
                    <input type="submit" value="Create Account Now">
                </div>
            </div>
        </div>
    </form>
    <?php include('required/footer.html'); ?>
