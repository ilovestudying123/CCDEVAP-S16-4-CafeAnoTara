<?php
    require "../../../backend/config/connection.php";
    require_once "../authentication/auth.php";
    require_once __DIR__ . '/../../../backend/models/cafeModel.php';

    $cafeModel = new cafeModel();
    $user_ID = $_SESSION['user_id'];

    $row = $cafeModel->getCafeByOwnerId($conn, $user_ID);

    $db_photos = [];
    if ($row) {
        $cafe_id = $row['cafe_id'];
        
        $images = $cafeModel->getCafeImagesOrdered($conn, $cafe_id);
        
        foreach ($images as $img) {
            $db_photos[] = $img['photo_url'];
        }
    }

    // Sets the cafe images and gives default emply image if there are none
    $cover_img = isset($db_photos[0]) ? $db_photos[0] : '../../resources/imgs/default.png';
    $thumb_1   = isset($db_photos[1]) ? $db_photos[1] : '../../resources/imgs/default.png';
    $thumb_2   = isset($db_photos[2]) ? $db_photos[2] : '../../resources/imgs/default.png';
    $thumb_3   = isset($db_photos[3]) ? $db_photos[3] : '../../resources/imgs/default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/cafeInfo.css?v=3">
    <title>Cafe Info</title>
</head>

<body>
    <!-- header -->
    <?php require "../../includes/header-owner.php"; ?>

    <div class="body-box">
        <?php if ($row): ?>
            <h1 class="cafe-name"><?php echo htmlspecialchars($row['cafe_name']); ?></h1>
            
            <!-- Redirects to edit the cafe information -->
            <a href="cafeInfo-update.php" class="update-btn">Update Profile</a>

            <section class="info-box">
                <div class="pic-column">
                    <div class="cafe-pic">
                        <img src="<?php echo htmlspecialchars($cover_img); ?>">
                    </div>
                </div>

                <!-- Displays the cafe information details-->
                <div class="info-column">
                    <div class="grid-container">
                        <div class="grid-item">
                            <span class="header-text">Wifi Speed</span>
                            <span class="desc-text"><?php echo htmlspecialchars($row['wifi_speed']); ?> Mbps</span>
                        </div>
                        <div class="grid-item">
                            <span class="header-text">Operating Hours</span>
                            <span class="desc-text"><?php echo date("g:i A", strtotime($row['opening_time'])); ?> - <?php echo date("g:i A", strtotime($row['closing_time'])); ?></span>
                        </div>
                        <div class="grid-item">
                            <span class="header-text">Price Range</span>
                            <span class="desc-text"><?php echo htmlspecialchars($row['price']); ?></span>
                        </div>
                        <div class="grid-item">
                            <span class="header-text">No. of Outlets</span>
                            <span class="desc-text"><?php echo htmlspecialchars($row['outlet_num']); ?></span>
                        </div>
                    </div>

                    <!-- Displays the images -->
                    <div class="thumbnails-row">
                        <img src="<?php echo htmlspecialchars($thumb_1); ?>" class="thumb">
                        <img src="<?php echo htmlspecialchars($thumb_2); ?>" class="thumb">
                        <img src="<?php echo htmlspecialchars($thumb_3); ?>" class="thumb">
                    </div>
                </div>
            </section>
        <?php else: ?>
            <p>No cafe information found for this owner.</p>
        <?php endif; ?>
    </div>

    <script src="../../resources/js/cafeInfo.js"></script>
</body>
</html>