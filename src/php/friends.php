<?php
session_start();
require_once './functions.php';
include_once '../db/MySQLDB.php';
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

$friends = $func->getUserFriends($db, $theUserID);

$customer= $func->getAUser($db, $theUserID);
$row = $customer->fetch();
$fullName = $row['firstName'] . " " . $row['lastName'];
echo "<script>console.log('The customer ID is:  $theUserID')</script>";

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if (isset($_POST['btn-unfriend'])) {
        $theFriend = htmlentities($_POST['btn-unfriend'], ENT_QUOTES, 'UTF-8');
        $func->deleteFriend($db, $theUserID, $theFriend);
    }
}

?>

<html lang="en">
<head>
    <title><?php echo $ini[$theCommunity]["title"] . " - Friends"; ?></title>
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
        <div class="friends">
            <?php echo "<h1>$fullName's Friends</h1>"; ?>
            <br>
            <?php $func->displayUserFriends($friends); ?>
            <br><br>
            <button type="submit" value="submit" name="btn-unfriend-user" class="btn btn-primary" id="btn-unfriend-user">
                Unfollow Users
            </button>
            <br><br>
        </div>
        <div class="modal" id="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Unfollow Users</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
                        <form action="./friends.php" method="POST">
                            <?php while ($friendsList = $friends->fetch()) { ?>
                                <tr>
                                    <td bgcolor="#FFFFFF"><?php echo $friendsList['username']; ?></td>
                                    <td bgcolor="#FFFFFF"><?php echo $friendsList['firstName']; ?></td>
                                    <td bgcolor="#FFFFFF"><?php echo $friendsList['lastName']; ?></td>
                                    <td bgcolor="#FFFFFF">
                                        <button type="submit" value="<?php echo $friendsList['userId']; ?>" name="btn-unfriend" class="btn btn-primary" id="btn-unfriend">
                                            Unfollow user
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </form>
                    </table>
                </div>
            </div>
        </div>
        <script>
            // Get the modal
            let modal = document.getElementById('modal');

            // Get the button that opens the modal
            let btn = document.getElementById("btn-unfriend-user");

            // Get the <span> element that closes the modal
            let span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal
            btn.onclick = function() {
                modal.style.display = "block";
            };

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            };

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        <br>
        <div class="profile-ctrl">
            <a href="#">Friends</a>
            <br><br>
            <a href="./messages.php">Messages</a>
            <br><br>
            <a href="./logout.php">Logout and Return</a>
            <br><br>
        </div>
    </div>
</div>
</body>
</html>
