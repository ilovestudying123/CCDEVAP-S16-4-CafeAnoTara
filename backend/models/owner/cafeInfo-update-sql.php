<?php
    require '../../../backend/config/connection.php';

    $user_ID = 2;

    $sql = "SELECT c.cafe_id, c.cafe_name, c.wifi_speed, c.opening_time, 
                   c.closing_time, c.price, c.outlet_num
            FROM Cafes c
            WHERE c.owner_id = '$user_ID'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $cafe_id = $row['cafe_id'];

    $img_sql = "SELECT photo_id, photo_url FROM CafeIMG WHERE cafe_id = '$cafe_id' ORDER BY photo_id ASC";
    $img_result = $conn->query($img_sql);
    
    $all_photos = [];
    while ($img_row = $img_result->fetch_assoc()) {
        $all_photos[] = $img_row;
    }

    $has_existing_cover = !empty($all_photos);
    $cover_photo = $has_existing_cover ? $all_photos[0]['photo_url'] : "../../resources/imgs/cafe.jpg";
    
    $extra_photos = array_slice($all_photos, 1, 4);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $wifi_speed = $conn->real_escape_string($_POST['wifi_speed']);
        $outlet_num = $conn->real_escape_string($_POST['outlet_num']);
        $price      = $conn->real_escape_string($_POST['price']);
        
        $hours_input = $_POST['operating_hours']; 
        $times = explode('-', $hours_input);
        
        if(count($times) == 2) {
            $opening_time = date("H:i:s", strtotime(trim($times[0])));
            $closing_time = date("H:i:s", strtotime(trim($times[1])));
        } else {
            $opening_time = $row['opening_time'];
            $closing_time = $row['closing_time'];
        }

        $update_sql = "UPDATE Cafes SET 
                        wifi_speed = '$wifi_speed', 
                        outlet_num = '$outlet_num', 
                        opening_time = '$opening_time', 
                        closing_time = '$closing_time', 
                        price = '$price' 
                    WHERE cafe_id = '$cafe_id'";

        if ($conn->query($update_sql) === TRUE) {
            
            if (isset($_POST['cover_photo_url'])) {
                $new_cover = $conn->real_escape_string(trim($_POST['cover_photo_url']));
                if (!empty($new_cover)) {
                    if ($has_existing_cover) {
                        $target_id = $all_photos[0]['photo_id'];
                        $conn->query("UPDATE CafeIMG SET photo_url = '$new_cover' WHERE photo_id = '$target_id'");
                    } else {
                        $conn->query("INSERT INTO CafeIMG (cafe_id, photo_url) VALUES ('$cafe_id', '$new_cover')");
                    }
                }
            }

            if (isset($_POST['extra_photos']) && is_array($_POST['extra_photos'])) {
                if (!$has_existing_cover && empty($_POST['cover_photo_url'])) {
                    $conn->query("INSERT INTO CafeIMG (cafe_id, photo_url) VALUES ('$cafe_id', '../../resources/imgs/cafe.jpg')");
                }

                foreach ($_POST['extra_photos'] as $index => $url) {
                    $url = $conn->real_escape_string(trim($url));
                    
                    if (!empty($url)) {
                        if (isset($extra_photos[$index])) {
                            $target_id = $extra_photos[$index]['photo_id'];
                            $conn->query("UPDATE CafeIMG SET photo_url = '$url' WHERE photo_id = '$target_id'");
                        } else {
                            $conn->query("INSERT INTO CafeIMG (cafe_id, photo_url) VALUES ('$cafe_id', '$url')");
                        }
                    }
                }
            }

            header("Location: cafeInfo.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
?>