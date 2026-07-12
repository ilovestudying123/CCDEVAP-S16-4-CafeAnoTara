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

<!DOCTYPE html>
<html lang="en">
<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/cafeInfo.css?v=3">
    
    <div id="header"></div>
    <script src="../../resources/js/script-header-owner.js"></script>
</header>

<body>
    <div class="body-box">
        <h1 class="cafe-name"><?php echo $row['cafe_name'];?></h1>
        
        <a href="cafeInfo-update.php" class="update-btn">Update Profile</a>

        <section class="info-box">
            <div class="pic-column">
                <div class="cafe-pic">
                    <img src="../../resources/imgs/cafe.jpg" alt="Main Cafe Image">
                </div>
            </div>

            <div class="info-column">
                <div class="grid-container">
                    <div class="grid-item">
                        <span class="header-text">Wifi Speed</span>
                        <span class="desc-text"><?php echo $row['wifi_speed'];?> Mbps</span>
                    </div>
                    <div class="grid-item">
                        <span class="header-text">Operating Hours</span>
                        <span class="desc-text"><?php echo date("g:i A", strtotime($row['opening_time'])); ?>-<?php echo date("g:i A", strtotime($row['closing_time'])); ?></span>
                    </div>
                    <div class="grid-item">
                        <span class="header-text">Price Range</span>
                        <span class="desc-text"><?php echo $row['price'];?></span>
                    </div>
                    <div class="grid-item">
                        <span class="header-text">No. of Outlets</span>
                        <span class="desc-text"><?php echo $row['outlet_num'];?></span>
                    </div>
                </div>

                <div class="thumbnails-row">
                    <img src="../../resources/imgs/m3.jpg" alt="Thumb 1" class="thumb">
                    <img src="../../resources/imgs/y1.jpg" alt="Thumb 2" class="thumb">
                    <img src="../../resources/imgs/s2.jpg" alt="Thumb 3" class="thumb">
                </div>
            </div>
        </section>
    </div>

    <script src="../../resources/js/cafeInfo.js"></script>
</body>

</html>