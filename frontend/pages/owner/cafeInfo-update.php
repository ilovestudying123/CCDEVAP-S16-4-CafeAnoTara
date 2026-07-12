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

    $cafe_id = $row['cafe_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $wifi_speed = $_POST['wifi_speed'];
        $outlet_num = $_POST['outlet_num'];
        $price      = $_POST['price'];
        
        // transforms INFO into a format that SQL can read
        $hours_input = $_POST['operating_hours']; 
        $times = explode('-', $hours_input);
        
        if(count($times) == 2) {
            $opening_time = date("H:i:s", strtotime(trim($times[0])));
            $closing_time = date("H:i:s", strtotime(trim($times[1])));
        } else {
            $opening_time = $row['opening_time'];
            $closing_time = $row['closing_time'];
        }

        // Updates  the database
        $update_sql = "UPDATE Cafes SET 
                        wifi_speed = '$wifi_speed', 
                        outlet_num = '$outlet_num', 
                        opening_time = '$opening_time', 
                        closing_time = '$closing_time', 
                        price = '$price' 
                    WHERE cafe_id = '$cafe_id'";

        if ($conn->query($update_sql) === TRUE) {
            header("Location: cafeInfo.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/cafeInfo-update.css?v=4">

    <div id="header"></div>
    <script src="../../resources/js/script-header-owner.js"></script>
</header>

<body>
    <form action="cafeInfo-update.php" method="POST">
        <div class="body-box">
            <h1 class="cafe-name"><?php echo $row['cafe_name'];?></h1>

            <button type="submit" id="save-btn" class="update-btn">Update</button>

            <section class="info-box">
                <div class="pic-column">
                    <img src="../../resources/imgs/cafe.jpg" alt="pookie">
                    
                    <button type="button" class="form-btn cover-btn">Change Cover Photo</button>
                </div>

                <div class="info-column">
                    <button type="button" class="form-btn edit-btn">Edit Photos</button>
                    
                    <div class="info-text">
                        <label class="header-text" for="wifi-speed">Wifi Speed:</label>
                        <input type="text" name="wifi_speed" id="input-wifi" class="form-btn" value="<?php echo $row['wifi_speed']; ?>">
                        <label class="header-text" for="outlet">Outlet Number:</label>
                        <input type="text" name="outlet_num" id="input-outlets" class="form-btn" value="<?php echo $row['outlet_num']; ?>">
                    </div>

                    <label class="header-text" for="operating-hrs">Operating Hours:</label>
                    <input type="text" name="operating_hours" id="input-hours" class="form-btn" value="<?php echo date('H:i', strtotime($row['opening_time'])) . ' - ' . date('H:i', strtotime($row['closing_time']));?>">
                    <label class="header-text" for="price">Price Range:</label>
                    <input type="text" name="price" id="input-price" class="form-btn" value="<?php echo $row['price']; ?>">
                </div>
            </section>
        </div>
    </form>
    
    <script src="../../resources/js/cafeInfo.js"></script>
</body>

</html>