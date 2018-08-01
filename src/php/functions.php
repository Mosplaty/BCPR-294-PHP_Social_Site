<?php
class Functions {

    public function getUsers($db) {
        $sql = "SELECT * FROM `users` ORDER BY userId;";
        $result = $db->query($sql);
        //echo "there were " . $result->size() . " rows <br />";
        return $result;
    }

    public function getFriends($db) {
        $sql = "SELECT * FROM `friends` ORDER BY userId;";
        $result = $db->query($sql);
        //echo "<br />there were " . $result->size() . " rows <br />";
        return $result;
    }

    public function getMessages($db) {
        $sql = "SELECT * FROM `messages` ORDER BY messageId;";
        $result = $db->query($sql);
        //echo "there were " . $result->size() . " rows <br />";
        return $result;
    }

    public function getTopics($db) {
        $sql = "SELECT * FROM `topics` ORDER BY topicId;";
        $result = $db->query($sql);
        //echo "there were " . $result->size() . " rows <br />";
        return $result;
    }

    public function getComments($db) {
        $sql = "SELECT * FROM `comments` ORDER BY commentId;";
        $result = $db->query($sql);
        //echo "there were " . $result->size() . " rows <br />";
        return $result;
    }

    public function displayUsers($users) {
        echo '<table border=1><tr><td>User ID</td><td>e-Mail</td><td>Username</td><td>First Name</td><td>Surname</td><td>Password</td><td>Gender</td></tr>';
        while ( $aRow = $users->fetch() ) {
            $outputLine = "<tr><td>$aRow[userId]</td>";
            $outputLine .= "<td>$aRow[email]</td>";
            $outputLine .= "<td>$aRow[username]</td>";
            $outputLine .= "<td>$aRow[firstName]</td>";
            $outputLine .= "<td>$aRow[lastName]</td>";
            $outputLine .= "<td>$aRow[password]</td>";
            $outputLine .= "<td>$aRow[gender]</td></tr>";
            echo $outputLine;
        }
        echo '</table>';
    }

    public function displayFriends($friends) {
        echo '<table border=1><tr><td>User ID</td><td>Friend ID</td></tr>';
        while ( $aRow = $friends->fetch() ) {
            $outputLine = "<tr><td>$aRow[userId]</td>";
            $outputLine .= "<td>$aRow[friendId]</td></tr>";
            echo $outputLine;
        }
        echo '</table>';
    }

    public function displayMessages($messages) {
        echo '<table border=1><tr><td>Message ID</td><td>User ID</td><td>Friend ID</td><td>Date & Time</td><td>link</td><td>content</td></tr>';
        while ( $aRow = $messages->fetch() ) {
            $outputLine = "<tr><td>$aRow[messageId]</td>";
            $outputLine .= "<td>$aRow[userId]</td>";
            $outputLine .= "<td>$aRow[friendId]</td>";
            $outputLine .= "<td>$aRow[dateTime]</td>";
            $outputLine .= "<td>$aRow[link]</td>";
            $outputLine .= "<td>$aRow[content]</td></tr>";
            echo $outputLine;
        }
        echo '</table>';
    }

    public function displayTopics($topics) {
        echo '<table border=1><tr><td>Topic ID</td><td>User ID</td><td>Date & Time</td><td>Title</td><td>Content</td></tr>';
        while ( $aRow = $topics->fetch() ) {
            $outputLine = "<tr><td>$aRow[topicId]</td>";
            $outputLine .= "<td>$aRow[userId]</td>";
            $outputLine .= "<td>$aRow[dateTime]</td>";
            $outputLine .= "<td>$aRow[title]</td>";
            $outputLine .= "<td>$aRow[content]</td></tr>";
            echo $outputLine;
        }
        echo '</table>';
    }

    public function displayComments($comments) {
        echo '<table border=1><tr><td>Comment ID</td><td>User ID</td><td>Topic ID</td><td>Date & Time</td><td>Content</td></tr>';
        while ( $aRow = $comments->fetch() ) {
            $outputLine = "<tr><td>$aRow[commentId]</td>";
            $outputLine .= "<td>$aRow[userId]</td>";
            $outputLine .= "<td>$aRow[topicId]</td>";
            $outputLine .= "<td>$aRow[dateTime]</td>";
            $outputLine .= "<td>$aRow[content]</td></tr>";
            echo $outputLine;
        }
        echo '</table>';
    }

    // -- -- LOGIN STUFF -- --
    public function isValidLogin($email , $password) {
        $result = true;
        if ( empty( $email )) {
            $result = false;
            echo 'An email address must be entered <br>';
        }
        if ( empty( $password )) {
            $result = false;
            echo 'A password must be entered <br>';
        }
        return $result;
    }

    public function getUserID($db, $email, $password) {
        $sql = "SELECT * FROM `users` WHERE email = '$email'";
        $user = $db->query($sql);
        $row = $user->fetch();
        $pass = $row['password'];
        if (password_verify($password, $pass)) {
            $result = $row['userId'];
        }
        else {
            $result = false;
            echo "Not verified!!";
        }
        return $result;
    }

    public function getAUser($db, $userId) {
        $sql = "SELECT * FROM `users` WHERE userId = '$userId'";
        $result = $db->query($sql);
        return $result;
    }

    // -- -- REGISTRATION STUFF -- --
    public function createUser($db, $theEmail, $theUsername, $firstName, $lastName, $thePassword, $theGender) {
        $sql = "INSERT INTO `users` VALUES (DEFAULT, '$theEmail', '$theUsername', '$firstName', '$lastName', '$thePassword', '$theGender');";
        $result = $db->query($sql);
        return $result;
    }

    // -- -- FRIEND STUFF -- --
    public function getUserFriends($db, $userID) {
        $sql = "SELECT users.username, users.firstName, users.lastName, users.userId
            FROM `friends` INNER JOIN `users` ON friends.friendId = users.userId
            WHERE friends.userId = $userID ORDER BY friends.userId;";
        $result = $db->query($sql);
        return $result;
    }

    public function displayUserFriends($friends) {
        echo '<table class="table-friends"><tr><td>UserName</td><td>First Name</td><td>Last Name</td></tr>';
        while ( $aRow = $friends->fetch() ) {
            $outputLine = "<tr><td>$aRow[username]</td>";
            $outputLine .= "<td>$aRow[firstName]</td>";
            $outputLine .= "<td>$aRow[lastName]</td></tr>";
            echo $outputLine;
        }
        echo '</table>';
    }

    public function addFriend($db, $userId, $friendId) {
        $sql = "INSERT INTO `friends` VALUES ('$userId', '$friendId');";
        $result = $db->query($sql);
        $message = "User followed!!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return $result;
    }

    public function deleteFriend($db, $userId, $friendId) {
        $sql = "DELETE FROM `friends` WHERE userId = '$userId' AND friendId = '$friendId';";
        $result = $db->query($sql);
        $message = "User un-followed!!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return $result;
    }

    // -- -- MESSAGING STUFF -- --
    public function getUserMessages($db, $userID) {
        $sql = "SELECT username, link, content, dateTime
            FROM `messages` INNER JOIN `users` ON messages.friendId = users.userId
            WHERE users.userId = $userID;";
        $result = $db->query($sql);
        return $result;
    }

    public function displayUserMessages($messages) {
        echo '<table class="table-messages"><tr><td>UserName</td><td>Link</td><td>Message</td><td>Time Sent</td></tr>';
        while ( $aRow = $messages->fetch() ) {
            $outputLine = "<tr><td>$aRow[username]</td>";
            $outputLine .= "<td>$aRow[link]</td>";
            $outputLine .= "<td>$aRow[content]</td>";
            $outputLine .= "<td>$aRow[dateTime]</td></tr>";
            echo $outputLine;
        }
        echo '</table>';
    }

    public function addMessage($db, $userId, $friendId, $link, $content) {
        $sql = "INSERT INTO `messages` VALUES (DEFAULT, '$userId', '$friendId', CURRENT_TIMESTAMP, '$link', '$content');";
        $result = $db->query($sql);
        return $result;
    }

    // -- -- FORUM STUFF -- --
    public function getSelectedTopic($db, $topicId) {
        $sql = "SELECT * FROM `topics` WHERE topicId = $topicId;";
        $result = $db->query($sql);
        return $result;
    }

    public function getSelectedComments($db, $topicId) {
        $sql = "SELECT * FROM `comments` WHERE topicId = $topicId;";
        $result = $db->query($sql);
        return $result;
    }

    public function createComment($db, $topicId, $userId, $content) {
        $sql = "INSERT INTO `comments` VALUES (DEFAULT, '$userId', '$topicId', CURRENT_TIMESTAMP, '$content');";
        $result = $db->query($sql);
        return $result;
    }

    // -- -- SEARCH STUFF -- --
    public function searchUsers($db, $string) {
        $sql = "SELECT * FROM `users` WHERE firstName LIKE '%$string%' OR lastName LIKE '%$string%' OR username LIKE '%$string%';";
        $result = $db->query($sql);
        return $result;
    }

    public function searchTopics($db, $string) {
        $sql = "SELECT * FROM `topics` WHERE title LIKE '%$string%' OR content LIKE '%$string%';";
        $result = $db->query($sql);
        return $result;
    }
}