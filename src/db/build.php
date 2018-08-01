<?php
include_once 'MySQLDB.php';
require 'db.php';

//  create the database again
$db->createDatabase();
// select the database
$db->selectDatabase();

// drop the tables
$sql = "drop table if exists profile";
$result = $db->query($sql);

$sql = "drop table if exists friends";
$result = $db->query($sql);

$sql = "drop table if exists messages";
$result = $db->query($sql);

$sql = "drop table if exists comments";
$result = $db->query($sql);

$sql = "drop table if exists topics";
$result = $db->query($sql);

$sql = "drop table if exists users";
$result = $db->query($sql);

// CREATE USERS TABLE
$sql = "CREATE TABLE users (
    userId INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(64) NOT NULL,
    username VARCHAR(64) NOT NULL,
    firstName VARCHAR(64) NOT NULL,
    lastName VARCHAR(64) NOT NULL,
    password VARCHAR(255) NOT NULL,
    gender ENUM('M', 'F', 'O'),
    PRIMARY KEY (userId)
    )ENGINE = InnoDB;";

$result = $db->query($sql);
if ( $result ) {
    echo 'the users table was added<br>';
}
else {
    echo 'the users table was not added<br>';
}
// CREATE FRIENDS TABLE
$sql = "CREATE TABLE friends (
    userId INT,
    friendId INT,
    PRIMARY KEY (userId, friendId),
    FOREIGN KEY (userId) REFERENCES users (userId),
    FOREIGN KEY (friendId) REFERENCES users (userId)
    )ENGINE=InnoDB;";

$result = $db->query($sql);
if ( $result ) {
    echo 'the friends table was added<br>';
}
else {
    echo 'the friends table was not added<br>';
}
// CREATE MESSAGES TABLE
$sql = "CREATE TABLE messages (
    messageId INT NOT NULL AUTO_INCREMENT,
    userId INT,
    friendId INT,
    dateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    link VARCHAR(128),
    content VARCHAR(255),
    PRIMARY KEY (messageId),
    FOREIGN KEY (userId) REFERENCES users (userId),
    FOREIGN KEY (friendId) REFERENCES users (userId)
    )ENGINE=InnoDB;";

$result = $db->query($sql);
if ( $result ) {
    echo 'the messages table was added<br>';
}
else {
    echo 'the messages table was not added<br>';
}
// CREATE TOPICS TABLE
$sql = "CREATE TABLE topics (
    topicId INT NOT NULL AUTO_INCREMENT,
    userId INT,
    dateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(64),
    content VARCHAR(255),
    PRIMARY KEY (topicId),
    FOREIGN KEY (userId) REFERENCES users (userId)
    )ENGINE=InnoDB;";

$result = $db->query($sql);
if ( $result ) {
    echo 'the topics table was added<br>';
}
else {
    echo 'the topics table was not added<br>';
}
// CREATE COMMENTS TABLE
$sql = "CREATE TABLE comments (
    commentId INT NOT NULL AUTO_INCREMENT,
    userId INT,
    topicId INT,
    dateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    content VARCHAR(255),
    PRIMARY KEY (commentId),
    FOREIGN KEY (userId) REFERENCES users (userId),
    FOREIGN KEY (topicId) REFERENCES topics (topicId)
    )ENGINE=InnoDB;";
    
$result = $db->query($sql);
if ( $result ) {
    echo 'the comments table was added<br>';
}
else {
    echo 'the comments table was not added<br>';
}

// USERS
$pass = password_hash('pass123', PASSWORD_DEFAULT);
$sql = "INSERT INTO `users` VALUES (DEFAULT, 'user1@mail.com', 
'UserOne', 'John', 'Smith', '$pass', 'M');";
$result = $db->query($sql);

$pass = password_hash('pass234', PASSWORD_DEFAULT);
$sql = "INSERT INTO `users` VALUES (DEFAULT, 'user2@mail.com', 
'UserTwo', 'Jane', 'Smith', '$pass', 'F');";
$result = $db->query($sql);

$pass = password_hash('pass345', PASSWORD_DEFAULT);
$sql = "INSERT INTO `users` VALUES (DEFAULT, 'user3@mail.com', 
'UserThree', 'Sam', 'Smith', '$pass', 'O');";
$result = $db->query($sql);

$pass = password_hash('pass456', PASSWORD_DEFAULT);
$sql = "INSERT INTO `users` VALUES (DEFAULT, 'user4@mail.com', 
'UserFour', 'Bob', 'Harding', '$pass', 'M');";
$result = $db->query($sql);

$pass = password_hash('pass567', PASSWORD_DEFAULT);
$sql = "INSERT INTO `users` VALUES (DEFAULT, 'user5@mail.com', 
'UserFive', 'Heather', 'Chester', '$pass', 'F');";
$result = $db->query($sql);

// FRIENDS
$sql = "INSERT INTO `friends` VALUES (1, 2);";
$result = $db->query($sql);

$sql = "INSERT INTO `friends` VALUES (1, 3);";
$result = $db->query($sql);

$sql = "INSERT INTO `friends` VALUES (4, 3);";
$result = $db->query($sql);

$sql = "INSERT INTO `friends` VALUES (4, 5);";
$result = $db->query($sql);

$sql = "INSERT INTO `friends` VALUES (5, 1);";
$result = $db->query($sql);

// MESSAGES
$sql = "INSERT INTO `messages` VALUES (DEFAULT, 1, 2, CURRENT_TIMESTAMP, 'theLink', 
'THIS IS THE MESSSAGE');";
$result = $db->query($sql);

$sql = "INSERT INTO `messages` VALUES (DEFAULT, 2, 1, CURRENT_TIMESTAMP, 'theLink2', 
'THIS IS THE REPLY MESSSAGE');";
$result = $db->query($sql);

// TOPICS
$sql = "INSERT INTO `topics` VALUES (DEFAULT, 1, CURRENT_TIMESTAMP, 'The First Title', 
'THIS IS THE CONTENT OF THE FIRST TOPIC');";
$result = $db->query($sql);

$sql = "INSERT INTO `topics` VALUES (DEFAULT, 1, CURRENT_TIMESTAMP, 'The Second Title', 
'THIS IS THE CONTENT OF THE SECOND TOPIC');";
$result = $db->query($sql);

$sql = "INSERT INTO `topics` VALUES (DEFAULT, 1, CURRENT_TIMESTAMP, 'The Best topic EVER', 
'This is simply the best topic post ever. There has never been a better post in the history of the internet');";
$result = $db->query($sql);

// COMMENTS
$sql = "INSERT INTO `comments` VALUES (DEFAULT, 1, 1, CURRENT_TIMESTAMP,
'THIS IS MY COMMENT GUYS!');";
$result = $db->query($sql);

$sql = "INSERT INTO `comments` VALUES (DEFAULT, 2, 1, CURRENT_TIMESTAMP,
'THIS IS ANOTHER COMMENT!');";
$result = $db->query($sql);

$sql = "INSERT INTO `comments` VALUES (DEFAULT, 1, 2, CURRENT_TIMESTAMP,
'HEY');";
$result = $db->query($sql);

$sql = "INSERT INTO `comments` VALUES (DEFAULT, 4, 3, CURRENT_TIMESTAMP,
'You were right, this is by far the best');";
$result = $db->query($sql);

?>
<html>
<body>

<br><br>
<a href="../main.php">Back to main</a>
<br><br>

</body>
</html>
