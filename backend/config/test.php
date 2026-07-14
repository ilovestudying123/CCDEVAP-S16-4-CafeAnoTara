<?php
require_once 'connection.php';
$result = mysqli_query($conn, "SELECT cafe_name FROM Cafes");
$cafe = mysqli_fetch_assoc($result);
echo $cafe['cafe_name'];
?>