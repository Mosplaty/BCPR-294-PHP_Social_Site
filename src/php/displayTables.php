<?php
require_once 'functions.php';
require_once '../db/MySQLDB.php';
require_once '../db/db.php';

$func = new Functions();

//---- Display The Users Table
echo '<h2>Users</h2>';
$users = $func->getUsers($db);
$func->displayUsers($users);

//---- Display The Friends Table
echo '<h2>Friends</h2>';
$friends = $func->getFriends($db);
$func->displayFriends($friends);        
      
//---- Display The Messages Table
echo '<h2>Private Messages</h2>';
$messages = $func->getMessages($db);
$func->displayMessages($messages);

//---- Display The Topics Table
echo '<h2>Topics</h2>';
$topics = $func->getTopics($db);
$func->displayTopics($topics);

//---- Display The Comments Table
echo '<h2>Comments</h2>';
$comments = $func->getComments($db);
$func->displayComments($comments);
?>
<html>
<body>

<br><br>
<a href='../main.php'>Return To Main Form</a>
<br><br>

</body>
</html>