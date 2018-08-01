<?php
session_start();
require_once './functions.php';
require_once '../db/MySQLDB.php';
require '../db/db.php';

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

$customer= $func->getAUser($db, $theUserID);
$row = $customer->fetch();
$username = $row['username'];

$topics = $func->getTopics($db);

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    $string = htmlentities($_POST[ 'search' ], ENT_QUOTES, 'UTF-8');
    if ( isset($string) ) {
        $_SESSION[ 'search' ] = $string;
        header("Location: ./search.php");
    }
}

?>

<html lang="en">
<head>
    <title><?php echo $ini[$theCommunity]["title"] . " - Home"; ?></title>
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
    <a class="navbar-brand" href="#">
        <div class="img-brand"></div>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDrop" aria-controls="navbarDrop" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarDrop">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./customerPage.php?English">Profile </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Game </a>
            </li>
        </ul>
    </div>
    <div class="search-container">
        <form action="./home.php" method="POST">
            <input type="text" name="search" class="search-bar" id="search" placeholder="Search.." required/>
            <button type="submit" id="submit" value="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <button class="btn btn-share" id="btn-share">
        <img src="../image/shareButton.png" class="img-share" />
    </button>
</nav>
<div class="container">
    <div class="col-12">
        <h1>Forums</h1>
        <br><br>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
                <td width="10%" align="center" bgcolor="#E6E6E6"><strong>Date & Time</strong></td>
                <td width="30%" align="center" bgcolor="#E6E6E6"><strong>Forum Topic</strong></td>
                <td width="60%" align="center" bgcolor="#E6E6E6"><strong>Content</strong></td>
            </tr>
            <?php while($row = $topics->fetch()) { ?>
            <tr class="clickable-row" data-href="./forum.php?<?php echo $row['topicId'];?>" >
                <td bgcolor="#FFFFFF"><?php echo $row['dateTime']; ?></td>
                <td bgcolor="#FFFFFF"><?php echo $row['title']; ?></td>
                <td bgcolor="#FFFFFF"><?php echo $row['content']; ?></td>
            </tr>
            <?php } ?>
            <script>
                jQuery(document).ready(function ($) {
                    $(".clickable-row").click(function() {
                        window.location = $(this).data("href");
                    });
                });
            </script>
        </table>
        <br><br>
        <button type="submit" value="submit" name="btn-new-topic" class="btn btn-primary" id="btn-new-topic">
            New post...
        </button>
    </div>
</div>
</body>
</html>
