<?php
session_start();
require_once './functions.php';
require_once '../db/MySQLDB.php';
require '../db/db.php';

$func = new Functions();
$ini = parse_ini_file('../ini/community.ini', true);

if ( isset( $_SESSION[ 'theUserID' ] ) ) {
    $theUserID = $_SESSION['theUserID'];
    if (isset($_SESSION['theCommunity'])) {
        $theCommunity = $_SESSION['theCommunity'];
    } else {
        echo "Uh-oh";
    }
}

$messages = $func->getUserMessages($db, $theUserID);

$customer= $func->getAUser($db, $theUserID);
$row = $customer->fetch();
$fullName = $row['firstName'] . " " . $row['lastName'];
echo "<script>console.log('The customer ID is:  $theUserID')</script>";

?>
<html lang="en">
<head>
    <title><?php echo $ini[$theCommunity]["title"] . " - Messages"; ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href=<?php echo $ini[$theCommunity]["css"]; ?> />

</head>
<body class="bg" id="mainbody">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="./home.php">
        <div class="img-brand"></div>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDrop" aria-controls="navbarDrop" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarDrop">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="./home.php">Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./customerPage.php?English">Profile </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Game </a>
            </li>
        </ul>
    </div>
    <button class="btn btn-share" id="btn-share">
        <img src="../image/shareButton.png" class="img-share" />
    </button>
</nav>
<div class="container row">
    <div class="col-8">
        <div class="messages">
            <?php echo "<h1>$fullName's Messages</h1>"; ?>
            <br>
            <?php $func->displayUserMessages($messages); ?>
        </div>
        <br>
        <div class="profile-ctrl">
            <a href="./friends.php">Friends</a>
            <br><br>
            <a href="#">Messages</a>
            <br><br>
            <a href="./logout.php">Logout and Return</a>
            <br><br>
        </div>
    </div>
</div>
</body>
</html>
