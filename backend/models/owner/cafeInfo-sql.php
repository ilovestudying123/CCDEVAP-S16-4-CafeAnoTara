<?php
    require "../../../backend/config/connection.php";

    $user_ID = 2; 

    $sql = "SELECT 
                c.cafe_id,
                c.cafe_name,
                c.wifi_speed,
                c.opening_time,
                c.closing_time,
                c.price,
                c.outlet_num
            FROM 
                Cafes c
            WHERE 
                c.owner_id = '$user_ID'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>