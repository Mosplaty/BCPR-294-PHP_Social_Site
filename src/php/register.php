<?php
session_start();
require_once './functions.php';
include_once '../db/MySQLDB.php';
require '../db/db.php';

$func = new Functions();

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    $theEmail = htmlentities($_POST['theEmail'], ENT_QUOTES, 'UTF-8');
    $theUsername = htmlentities($_POST['theUsername'], ENT_QUOTES, 'UTF-8');
    $firstName = htmlentities($_POST['firstName'], ENT_QUOTES, 'UTF-8');
    $lastName = htmlentities($_POST['lastName'], ENT_QUOTES, 'UTF-8');
    $thePassword = htmlentities($_POST['thePassword'], ENT_QUOTES, 'UTF-8');
    $confirmedPassword = htmlentities($_POST['confirmedPassword'], ENT_QUOTES, 'UTF-8');
    $theGender = htmlentities($_POST['theGender'], ENT_QUOTES, 'UTF-8');
    if ($thePassword === $confirmedPassword) {
        if (!$func->isValidLogin($theEmail, $thePassword)) {
            echo "USER ALREADY EXISTS!!";
        }
        else {
            $hashed = password_hash($thePassword, PASSWORD_DEFAULT);
            $func->createUser($db, $theEmail, $theUsername, $firstName, $lastName, $hashed, $theGender);
            $newUserID = $func->getUserID($db, $theEmail, $thePassword);
            $result = $func->getAUser($db, $newUserID);
            header("Location: ./login.php");
        }
    }
}
?>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS (Hindi Language) -->
    <!--<link rel="stylesheet" href="./css/language.css" />-->
    <!-- CSS (Theseus and the Minotaur) -->
    <link rel="stylesheet" href="../css/game.css" />

</head>
<body class="bg" id="mainbody">
    <div class="container row">
        <!-- Login form -->
        <div class="col-8">
            <form action="register.php" method="POST" class="form-signin">
                <h1>Register</h1><br><br>
                <div class="form-group row">
                    <label for="email" class="sr-only">Enter an e-mail address</label><br>
                    <input name="theEmail" type="email" class="form-control" id="email" placeholder="Email Address" required autofocus /><br><br>
                </div>
                <div class="form-group row">
                    <label for="username" class="sr-only">Enter a username</label><br>
                    <input name="theUsername" type="text" class="form-control" id="username" placeholder="User Name" required /><br><br>
                </div>
                <div class="form-group row">
                    <label for="firstName" class="sr-only">Enter your first name</label><br>
                    <input name="firstName" type="text" class="form-control" id="firstName" placeholder="First Name" required /><br><br>
                </div>
                <div class="form-group row">
                    <label for="lastName" class="sr-only">Enter your last name</label><br>
                    <input name="lastName" type="text" class="form-control" id="lastName" placeholder="Last Name" required /><br><br>
                </div>
                <div class="form-group row">
                    <label for="password1" class="sr-only">Enter a password</label><br>
                    <input name="thePassword" type="password" class="form-control" id="password1" placeholder="Password" required /><br><br>
                </div>
                <div class="form-group row">
                    <label for="password2" class="sr-only">Re-enter your password</label><br>
                    <input name="confirmedPassword" type="password" class="form-control" id="password2" placeholder="Confirm Password" required /><br><br>
                </div>
                <div class="form-group row">
                    <label for ="gender">Gender: &nbsp;</label>
                    <label class="container radvalue">
                        <input type="radio" name="theGender" class ="radvalue" id="gender" value="M" checked>
                        <span class="checkmark"></span>Male &nbsp;</label>
                    <label class="container radvalue">
                        <input type="radio" name="theGender" class ="radvalue" id="gender" value="F">
                        <span class="checkmark"></span>Female &nbsp;</label>
                    <label class="container radvalue">
                        <input type="radio" name="theGender" class ="radvalue" id="gender" value="O">
                        <span class="checkmark"></span>Other &nbsp;</label><br/>
                </div>
                <input type="submit" class="btn btn-primary" id="submit" value="Submit" />
            </form>
            <a href="../main.php">Return To Main Form</a>
            <br><br>
        </div>
    </div>
</body>
</html>