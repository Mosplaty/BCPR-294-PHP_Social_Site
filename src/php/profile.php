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

$friends = $func->getUserFriends($db, $theUserID);

$userId = $_SERVER[ 'QUERY_STRING' ];
$user = $func->getAUser($db, $userId);
$profileRow = $user->fetch();
$fullName = $profileRow['firstName'] . " " . $profileRow['lastName'];

$profileFriends = $func->getUserFriends($db, $userId);

$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if ( isset($_POST['btn-add'])) {
        $func->addFriend($db, $theUserID, $profileRow['userId']);
    }
    if ( isset($_POST['btn-message-user'])) {
        $theLink = htmlentities($_POST['link'], ENT_QUOTES, 'UTF-8');
        $theContent = htmlentities($_POST['content'], ENT_QUOTES, 'UTF-8');
        $theFriend = htmlentities($_POST['btn-message-user'], ENT_QUOTES, 'UTF-8');
        $func->addMessage($db, $theUserID, $theFriend, $theLink, $theContent);
    }
    if (isset($_POST['search'])) {
        $string = htmlentities($_POST[ 'search' ], ENT_QUOTES, 'UTF-8');
        if ( isset($string) ) {
            $_SESSION[ 'search' ] = $string;
            header("Location: ./search.php");
        }
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
    <div class="search-container">
        <form action="./profile.php?<?php echo $profileRow['userId']; ?>" method="POST">
            <input type="text" name="search" class="search-bar" id="search" placeholder="Search.." required/>
            <button type="submit" id="submit" value="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <button class="btn btn-share" id="btn-share">
        <img src="../image/shareButton.png" class="img-share" />
    </button>
</nav>
<div class="container-fluid">
    <?php echo "<h2>$fullName's Profile</h2>"; ?>
    <br>
    <div class="user-friends">
        <?php $func->displayUserFriends($profileFriends); ?>
        <br><br>
    </div>
    <div class="user-actions">
        <form action="./profile.php?<?php echo $profileRow['userId']; ?>" method="POST">
            <button type="submit" value="submit" name="btn-add" class="btn btn-primary" id="btn-add">
                Follow User
            </button>
        </form>
        <br><br>
    </div>
    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Send message</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form action="./profile.php?<?php echo $profileRow['userId']; ?>" method="POST">
                    <label for="link" class="sr-only">Link</label>
                    <input type="text" name="link" class="link-input" id="link" size="50%" align="center" value="<?php echo $link; ?>" required/>
                    <label for="content" class="sr-only">Message Content</label>
                    <textarea name="content" class="content-input" id="content" cols="53%">
                        Message...
                    </textarea>
                </div>
                <div class="modal-footer">
                    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
                        <?php while ($friendsList = $friends->fetch()) { ?>
                            <tr>
                                <td bgcolor="#FFFFFF"><?php echo $friendsList['username']; ?></td>
                                <td bgcolor="#FFFFFF"><?php echo $friendsList['firstName']; ?></td>
                                <td bgcolor="#FFFFFF"><?php echo $friendsList['lastName']; ?></td>
                                <td bgcolor="#FFFFFF">
                                    <button type="submit" value="<?php echo $friendsList['userId']; ?>" name="btn-message-user" class="btn btn-primary" id="btn-message-user">
                                        Send Message
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Get the modal
        let modal = document.getElementById('modal');

        // Get the button that opens the modal
        let btn = document.getElementById("btn-share");

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
</div>
</body>
</html>
