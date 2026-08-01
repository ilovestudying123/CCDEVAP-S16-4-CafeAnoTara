<?php
    // DELETE ME!!!!!!!!!!!!!!!!!!!!!
    
    require '../../../backend/config/connection.php';

    $user_ID = 2; 

    $sql = "SELECT 
                c.cafe_id,
                c.cafe_name,
                c.location,
                c.description,
                c.wifi_speed,
                c.opening_time,
                c.closing_time,
                c.price,
                c.outlet_num,
                IFNULL(ROUND(AVG(r.rating), 1), 0.0) AS average_rating,
                COUNT(r.review_id) AS total_reviews
            FROM 
                Cafes c
            LEFT JOIN 
                Reviews r ON c.cafe_id = r.cafe_id
            WHERE 
                c.owner_id = '$user_ID'
            GROUP BY 
                c.cafe_id";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $carousel_images = [];
    if ($row) {
        $cafe_id = $row['cafe_id'];
        $img_sql = "SELECT photo_url FROM CafeIMG WHERE cafe_id = '$cafe_id' ORDER BY photo_id ASC";
        $img_result = $conn->query($img_sql);

        while ($img_row = $img_result->fetch_assoc()) {
            $carousel_images[] = $img_row['photo_url'];
        }
    }
?>