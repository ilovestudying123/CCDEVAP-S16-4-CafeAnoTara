<?php
    require_once __DIR__ . "/../../models/owner/cafeInfo-update-sql.php";

    $user_ID = 2;

    $row = getCafeByOwnerId($conn, $user_ID);
    if (!$row) {
        die("Cafe not found.");
    }
    $cafe_id = $row['cafe_id'];

    $all_photos = getCafePhotos($conn, $cafe_id);
    $has_existing_cover = !empty($all_photos);
    $cover_photo = $has_existing_cover ? $all_photos[0]['photo_url'] : "../../resources/imgs/cafe.jpg";
    $extra_photos = array_slice($all_photos, 1, 4);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $wifi_speed = trim($_POST['wifi_speed']);
        $outlet_num = trim($_POST['outlet_num']);
        $price      = trim($_POST['price']);
        
        $hours_input = $_POST['operating_hours']; 
        $times = explode('-', $hours_input);
        
        if (count($times) == 2) {
            $opening_time = date("H:i:s", strtotime(trim($times[0])));
            $closing_time = date("H:i:s", strtotime(trim($times[1])));
        } else {
            $opening_time = $row['opening_time'];
            $closing_time = $row['closing_time'];
        }

        // Updates the database
        $success = updateCafeDetails($conn, $cafe_id, $wifi_speed, $outlet_num, $opening_time, $closing_time, $price);

        if ($success) {
            // Updates the cover photo
            if (isset($_POST['cover_photo_url'])) {
                $new_cover = trim($_POST['cover_photo_url']);
                if (!empty($new_cover)) {
                    if ($has_existing_cover) {
                        $target_id = $all_photos[0]['photo_id'];
                        updatePhoto($conn, $target_id, $new_cover);
                    } else {
                        addPhoto($conn, $cafe_id, $new_cover);
                    }
                }
            }

            // Updates the other photos
            if (isset($_POST['extra_photos']) && is_array($_POST['extra_photos'])) {
                if (!$has_existing_cover && empty($_POST['cover_photo_url'])) {
                    addPhoto($conn, $cafe_id, '../../resources/imgs/cafe.jpg');
                }

                foreach ($_POST['extra_photos'] as $index => $url) {
                    $url = trim($url);
                    if (!empty($url)) {
                        if (isset($extra_photos[$index])) {
                            $target_id = $extra_photos[$index]['photo_id'];
                            updatePhoto($conn, $target_id, $url);
                        } else {
                            addPhoto($conn, $cafe_id, $url);
                        }
                    }
                }
            }

            header("Location: ../../../frontend/pages/owner/cafeInfo.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
?>