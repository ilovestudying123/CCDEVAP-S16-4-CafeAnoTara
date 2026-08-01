<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/cafeInfo.css?v=3">
    <?php require "../../../backend/models/owner/cafeInfo-sql.php"; ?>
    <title>Cafe Info</title>
</head>

<body>
    <!-- header -->
    <?php require "../../includes/header-owner.php"; ?>

    <div class="body-box">
        <h1 class="cafe-name"><?php echo htmlspecialchars($row['cafe_name']);?></h1>
        
        <a href="cafeInfo-update.php" class="update-btn">Update Profile</a>

        <section class="info-box">
            <div class="pic-column">
                <div class="cafe-pic">
                    <img src="<?php echo htmlspecialchars($cover_img); ?>" alt="Main Cafe Image">
                </div>
            </div>

            <div class="info-column">
                <div class="grid-container">
                    <div class="grid-item">
                        <span class="header-text">Wifi Speed</span>
                        <span class="desc-text"><?php echo htmlspecialchars($row['wifi_speed']);?> Mbps</span>
                    </div>
                    <div class="grid-item">
                        <span class="header-text">Operating Hours</span>
                        <span class="desc-text"><?php echo date("g:i A", strtotime($row['opening_time'])); ?>-<?php echo date("g:i A", strtotime($row['closing_time'])); ?></span>
                    </div>
                    <div class="grid-item">
                        <span class="header-text">Price Range</span>
                        <span class="desc-text"><?php echo htmlspecialchars($row['price']);?></span>
                    </div>
                    <div class="grid-item">
                        <span class="header-text">No. of Outlets</span>
                        <span class="desc-text"><?php echo htmlspecialchars($row['outlet_num']);?></span>
                    </div>
                </div>

                <div class="thumbnails-row">
                    <img src="<?php echo htmlspecialchars($thumb_1); ?>" alt="Thumb 1" class="thumb">
                    <img src="<?php echo htmlspecialchars($thumb_2); ?>" alt="Thumb 2" class="thumb">
                    <img src="<?php echo htmlspecialchars($thumb_3); ?>" alt="Thumb 3" class="thumb">
                </div>
            </div>
        </section>
    </div>

    <script src="../../resources/js/cafeInfo.js"></script>
</body>
</html>