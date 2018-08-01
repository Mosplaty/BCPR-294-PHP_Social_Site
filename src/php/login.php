<?php
session_start();
require_once './functions.php';
include_once '../db/MySQLDB.php';
require '../db/db.php';

$func = new Functions();


if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
     $theEmail = htmlentities($_POST[ 'theEmail' ], ENT_QUOTES, 'UTF-8');
     $thePassword = htmlentities($_POST[ 'thePassword' ], ENT_QUOTES, 'UTF-8');
     $theCommunity = htmlentities($_POST[ 'community' ], ENT_QUOTES, 'UTF-8');
     if ( $func->isValidLogin( $theEmail, $thePassword ) ) {
        $theUserID = $func->getUserID( $db, $theEmail, $thePassword );
        if ( !$theUserID ) {
            $result = false;
            echo "Not a valid surname, password combination <br />";
        }    
        else {
			   $_SESSION[ 'theUserID' ] = $theUserID;
			   $_SESSION[ 'theCommunity' ] = $theCommunity;
			   header("Location: customerPage.php?English");
        }    
    }
}    
?>

<html lang="en">
<head>
    <title>Login</title>
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
    <div class="col-8">
        <form action="login.php" method="POST" class="form-signin">
            <h1>Login</h1><br><br>
            <div class="form-group row">
                <label for="inputEmail">Enter email:</label>
                <input name="theEmail" type="email" id="inputEmail" class="form-control" size='15' required autofocus/>
                <br><br>
            </div>
            <div class="form-group row">
                <label for="inputPassword">Enter password:</label>
                <input name ="thePassword" type ="password" id="inputPassword" class="form-control" size='15' required/>
                <br><br>
            </div>
            <div class="form-group row">
                <label for="community">Community: </label>
                <label class="container radvalue">
                    <input type="radio" name="community" class="radvalue-check" id="community" value="Hindi" checked/>
                    <span class="checkmark"></span>Hindi Language &nbsp;</label>
                <label class="container radvalue">
                    <input type="radio" name="community" class="radvalue-check" id="community" value="Game"/>
                    <span class="checkmark"></span>Gaming Community &nbsp;</label>
            </div>
            <input type="submit" class="btn btn-primary" id="submit" value="Submit">
            <br><br>
        </form>
        <a href="./register.php">Not a member? Register now!!</a>
        <br><br>
        <a href="../main.php">Return To Main Form</a>
        <br><br>
    </div>
</div>
</body>
</html>