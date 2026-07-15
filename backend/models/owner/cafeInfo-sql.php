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

    $db_photos = [];
    if ($row) {
        $cafe_id = $row['cafe_id'];
        $img_sql = "SELECT photo_url FROM CafeIMG WHERE cafe_id = '$cafe_id' ORDER BY photo_id ASC";
        $img_result = $conn->query($img_sql);

        while ($img_row = $img_result->fetch_assoc()) {
            $db_photos[] = $img_row['photo_url'];
        }
    }

    $cover_img = isset($db_photos[0]) ? $db_photos[0] : 'default-cover.jpg';
    $thumb_1   = isset($db_photos[1]) ? $db_photos[1] : 'default-thumb.jpg';
    $thumb_2   = isset($db_photos[2]) ? $db_photos[2] : 'default-thumb.jpg';
    $thumb_3   = isset($db_photos[3]) ? $db_photos[3] : 'default-thumb.jpg';
?>