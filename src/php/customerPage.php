<?php
session_start();
require_once './functions.php';
require_once '../db/MySQLDB.php';
require '../db/db.php';
include "../ini/localization.php";

$func = new Functions();
$ini = parse_ini_file('../ini/community.ini', true);

if ( isset( $_SESSION[ 'theUserID' ] ) ) {
    $theUserID = $_SESSION[ 'theUserID' ];
    if ( isset( $_SESSION[ 'theCommunity' ] )) {
        $theCommunity = $_SESSION[ 'theCommunity' ];
    }
    else {
        echo "Uh-oh";
    }
}
else {
    $theUserID = 107;
    $_SESSION[ 'theUserID' ] = $theUserID;
}

$customer= $func->getAUser($db, $theUserID);
$row = $customer->fetch();
$fullName = $row['firstName'] . " " . $row['lastName'];
echo "<script>console.log('The customer ID is:  $theUserID')</script>";

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    if ( isset($_POST[ 'search' ]) ) {
        $string = htmlentities($_POST[ 'search' ], ENT_QUOTES, 'UTF-8');
        $_SESSION[ 'search' ] = $string;
        header("Location: ./search.php");
    }
    if (isset($_POST['btn-locale'])) {
        $locale = htmlentities($_POST['btn-locale'], ENT_QUOTES, 'UTF-8');
        header("Location: customerPage.php?$locale");
    }
}

?>
<html lang="en">
<head>
    <title><?php echo $ini[$theCommunity]["title"] . " - Profile"; ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
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
                <a class="nav-link" href="./home.php"><?php echo msg('Home'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo msg('Profile'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo msg('Game'); ?></a>
            </li>
            <li>
                <form action="customerPage.php" method="POST">
                    <button class="btn" id="btn-locale" name="btn-locale" value="English"><?php echo msg('English')?></button>
                    <button class="btn" id="btn-locale" name="btn-locale" value="Hindi"><?php echo msg('Hindi')?></button>
                </form>
            </li>
        </ul>
    </div>
    <div class="search-container">
        <form action="customerPage.php" method="POST">
            <input type="text" name="search" class="search-bar" id="search" placeholder="<?php echo msg('Search')?>" required/>
            <button type="submit" id="submit" value="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <button class="btn btn-share" id="btn-share">
        <img src="../image/shareButton.png" class="img-share" />
    </button>
</nav>
<div class="container-fluid">
    <?php echo "<h2>" . msg('Welcome') . " $fullName</h2>"; ?>
    <br>
    <div class="profile-ctrl">
        <a href="./friends.php"><?php echo msg('Friends'); ?></a>
        <br><br>
        <a href="./messages.php"><?php echo msg('Messages'); ?></a>
        <br><br>
        <a href="./logout.php"><?php echo msg('Logout and Return'); ?></a>
        <br><br>
    </div>
</div>
</body>
</html>