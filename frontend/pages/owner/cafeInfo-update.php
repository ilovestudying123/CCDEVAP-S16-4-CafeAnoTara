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

    // 3. Handle Form Submission
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

        // Update Cafe Details
        $update_sql = "UPDATE Cafes SET 
                        wifi_speed = '$wifi_speed', 
                        outlet_num = '$outlet_num', 
                        opening_time = '$opening_time', 
                        closing_time = '$closing_time', 
                        price = '$price' 
                    WHERE cafe_id = '$cafe_id'";

        if ($conn->query($update_sql) === TRUE) {
            
            // --- COVER PHOTO UPDATE ---
            if (isset($_POST['cover_photo_url'])) {
                $new_cover = $conn->real_escape_string(trim($_POST['cover_photo_url']));
                if (!empty($new_cover)) {
                    if ($has_existing_cover) {
                        // Update existing first item
                        $target_id = $all_photos[0]['photo_id'];
                        $conn->query("UPDATE CafeIMG SET photo_url = '$new_cover' WHERE photo_id = '$target_id'");
                    } else {
                        // Create primary entry if empty
                        $conn->query("INSERT INTO CafeIMG (cafe_id, photo_url) VALUES ('$cafe_id', '$new_cover')");
                    }
                }
            }

            // --- EXTRA PHOTOS UPDATE (4 LINKS) ---
            if (isset($_POST['extra_photos']) && is_array($_POST['extra_photos'])) {
                // Ensure the cover photo anchor exists so extra photos don't steal index 0
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/cafeInfo-update.css?v=4">
    <title>Update Cafe Info</title>

    <div id="header"></div>
    <script src="../../resources/js/script-header-owner.js"></script>
</head>

<body>
    <form action="cafeInfo-update.php" method="POST">
        <div class="body-box">
            <h1 class="cafe-name"><?php echo htmlspecialchars($row['cafe_name']);?></h1>

            <button type="submit" id="save-btn" class="update-btn">Update</button>

            <section class="info-box">
                <div class="pic-column">
                    <img id="cafe-cover-preview" src="<?php echo htmlspecialchars($cover_photo); ?>" alt="Cafe Cover Photo">
                    
                    <!-- Hidden input to store cover URL dynamically -->
                    <input type="hidden" name="cover_photo_url" id="cover-photo-input" value="<?php echo $has_existing_cover ? htmlspecialchars($all_photos[0]['photo_url']) : ''; ?>">

                    <button type="button" id="change-cover-btn" class="form-btn cover-btn">Change Cover Photo</button>
                </div>

                <div class="info-column">
                    <button type="button" id="edit-photos-btn" class="form-btn edit-btn">Edit Photos</button>
                    
                    <!-- Hidden inputs mapping to the 4 extra photos -->
                    <?php for($i = 0; $i < 4; $i++): ?>
                        <input type="hidden" name="extra_photos[<?php echo $i; ?>]" id="extra-photo-<?php echo $i; ?>" value="<?php echo isset($extra_photos[$i]) ? htmlspecialchars($extra_photos[$i]['photo_url']) : ''; ?>">
                    <?php endfor; ?>

                    <div class="info-text">
                        <label class="header-text" for="wifi-speed">Wifi Speed:</label>
                        <input type="text" name="wifi_speed" id="input-wifi" class="form-btn" value="<?php echo htmlspecialchars($row['wifi_speed']); ?>">
                        <label class="header-text" for="outlet">Outlet Number:</label>
                        <input type="text" name="outlet_num" id="input-outlets" class="form-btn" value="<?php echo htmlspecialchars($row['outlet_num']); ?>">
                    </div>

                    <label class="header-text" for="operating-hrs">Operating Hours:</label>
                    <input type="text" name="operating_hours" id="input-hours" class="form-btn" value="<?php echo date('H:i', strtotime($row['opening_time'])) . ' - ' . date('H:i', strtotime($row['closing_time']));?>">
                    <label class="header-text" for="price">Price Range:</label>
                    <input type="text" name="price" id="input-price" class="form-btn" value="<?php echo htmlspecialchars($row['price']); ?>">
                </div>
            </section>
        </div>
    </form>

    <!-- IMG Modals -->
    <div id="coverModal" class="modal">
        <div class="modal-content">
            <h3>Edit Cover Photo</h3>
            <label>Cover Photo Link:</label>
            <input type="text" id="modal-cover-img">
            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="closeCoverModal">Cancel</button>
                <button type="button" class="btn-confirm" id="saveCoverModal">Done</button>
            </div>
        </div>
    </div>

    <div id="photoModal" class="modal">
        <div class="modal-content">
            <h3>Edit Cafe Photos</h3>
            <label>Photo Link 1:</label>
            <input type="text" id="modal-img-0">
            <label>Photo Link 2:</label>
            <input type="text" id="modal-img-1">
            <label>Photo Link 3:</label>
            <input type="text" id="modal-img-2">
            <label>Photo Link 4:</label>
            <input type="text" id="modal-img-3">
            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="closePhotoModal">Cancel</button>
                <button type="button" class="btn-confirm" id="savePhotoModal">Done</button>
            </div>
        </div>
    </div>
    
    <script src="../../resources/js/cafe-info.js"></script>
</body>
</html>