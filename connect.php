<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'forum';

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    exit('Error: could not establish database connection');
}
if (!mysqli_select_db($conn, $database)) {
    exit('Error: could not select the database');
}

?>
