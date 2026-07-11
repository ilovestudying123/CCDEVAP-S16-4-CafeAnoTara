<?php
// connection to db
// REMINDER: change information according to your own settings!
// TO DO: include 'db.php' in all of the files that needs db connection

$host = "localhost";
$dbname = "cafeanotara";
$username = "root";
$password = "12345"; 

$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
} 
else echo "Connected successfully!";

?>