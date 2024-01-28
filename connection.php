<?php
$databaseHost = 'jezdb.com';
$databaseName = 'test';
$databaseUsername = 'tester';
$databasePassword = 'tester2024';
 
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 

if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}
 
?>