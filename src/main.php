<?php
session_save_path( './' );
session_start();
session_unset();
session_destroy();
?>
<html>

<a href="db/build.php">Build The Database</a>
<br><br>

<a href="php/displayTables.php">Display All Tables</a>
<br><br>

<a href="php/login.php">Login</a>
<br><br>

</html>