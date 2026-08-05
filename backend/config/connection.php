<?php
// connection to db
// REMINDER: change information according to your own settings!

$host = "localhost";
$dbname = "cafeanotara";
$username = "root";
$password = ""; 

$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

?>