<!DOCTYPE html>
<html lang="en">
<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/owner-dashboard.css?v=2">

    <div id="header"></div>
    <script src="../../resources/js/script-header-owner.js"></script>
</header>

<?php
    require "../../../backend/config/connection.php";

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
?>

<body>
    <div class="body-box">
        
        <div class="info-box">
            <h1 class="cafe-name"><?php echo $row['cafe_name'];?></h1>
            <p class="desc-text"><?php echo $row['location'];?></p>
            <p class="desc-text"><?php echo $row['description'];?></p>
            
            <div class="info-column">
                <div><p class="header-text">Wifi Speed</p><p class="desc-text"><?php echo $row['wifi_speed'];?> Mbps</p></div>
                <div><p class="header-text">Operating Hours</p><p class="desc-text">8:00 AM - 10:00 PM</p></div>
                <div><p class="header-text">Price Range</p><p class="desc-text">PHP <?php echo $row['price'];?></p></div>
                <div><p class="header-text">No. of Outlets</p><p class="desc-text"><?php echo $row['outlet_num'];?></p></div>
            </div>
        </div>

        <div class="carousel-container">
            <div class="carousel-wrapper">
                <div class="carousel-slide"><img src="../../resources/imgs/cafe.jpg" alt="cafe front"></div>
                <div class="carousel-slide"><img src="../../resources/imgs/cafe1.png" alt="cafe inside"></div>
                <div class="carousel-slide"><img src="../../resources/imgs/c2.jpg" alt="cats"></div>
                <div class="carousel-slide"><img src="../../resources/imgs/cafe3.jpg" alt="counter"></div>
                <div class="carousel-slide"><img src="../../resources/imgs/c1.jpg" alt="seating"></div>
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
                <a href="ratings.html" class="arrow-btn"><img src="../../resources/imgs/arrow-btn.png" alt="arrow"></a>
            </div>
        </div>

    </div>
</body>
</html>