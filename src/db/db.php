<?php
$host = 'localhost' ;
$dbUser ='root';
$dbPass ='';
$dbName ='social';
 
$db = new MySQL( $host, $dbUser, $dbPass, $dbName ) ;
$db->selectDatabase();
