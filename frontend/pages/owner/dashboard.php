<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/owner-dashboard.css?v=2">
    <?php require "../../../backend/models/owner/dashboard-sql.php"; ?>
    <title>Owner Dashboard</title>

    <div id="header"></div>
    <script src="../../resources/js/script-header-owner.js"></script>
</head>

<body>
    <div class="body-box">
        
        <div class="info-box">
            <h1 class="cafe-name"><?php echo htmlspecialchars($row['cafe_name']);?></h1>
            <p class="desc-text"><?php echo htmlspecialchars($row['location']);?></p>
            <p class="desc-text"><?php echo htmlspecialchars($row['description']);?></p>
            
            <div class="info-column">
                <div><p class="header-text">Wifi Speed</p><p class="desc-text"><?php echo htmlspecialchars($row['wifi_speed']);?> Mbps</p></div>
                <div><p class="header-text">Operating Hours</p><p class="desc-text"><?php echo date("g:i A", strtotime($row['opening_time'])); ?> - <?php echo date("g:i A", strtotime($row['closing_time'])); ?></p></div>
                <div><p class="header-text">Price Range</p><p class="desc-text">PHP <?php echo htmlspecialchars($row['price']);?></p></div>
                <div><p class="header-text">No. of Outlets</p><p class="desc-text"><?php echo htmlspecialchars($row['outlet_num']);?></p></div>
            </div>
        </div>

        <!-- IMG Carousel -->
        <div class="carousel-container">
            <div class="carousel-wrapper">
                <?php foreach ($carousel_images as $index => $url): ?> <!-- Goes through the array of IMGs -->
                    <div class="carousel-slide">
                        <img src="<?php echo htmlspecialchars($url); ?>" alt="Cafe Photo <?php echo $index + 1; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="box pad rating-box">
            <p class="header-text">Average Rating</p>
            <div class="rating"><span class="star">★</span> <?php echo $row['average_rating'];?>/5</div>
        </div>

        <div class="box pad review-box">
            <div>
                <p class="header-text">Cafe Reviews</p>
                <div class="count"><?php echo $row['total_reviews'];?></div>
            </div>
            <div class="review-redirect">
                <a href="ratings.php" class="arrow-btn"><img src="../../resources/imgs/arrow-btn.png" alt="arrow"></a>
            </div>
        </div>

    </div>
</body>
</html>