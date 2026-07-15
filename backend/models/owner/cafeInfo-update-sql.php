<?php
    require_once __DIR__ . '/../../config/connection.php';

    function getCafeByOwnerId($conn, $owner_id) {
        $sql = "SELECT c.cafe_id, c.cafe_name, c.wifi_speed, c.opening_time, 
                    c.closing_time, c.price, c.outlet_num
                FROM Cafes c
                WHERE c.owner_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $owner_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    function getCafePhotos($conn, $cafe_id) {
        $sql = "SELECT photo_id, photo_url FROM CafeIMG WHERE cafe_id = ? ORDER BY photo_id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cafe_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $photos = [];
        while ($row = $result->fetch_assoc()) {
            $photos[] = $row;
        }
        return $photos;
    }

    function updateCafeDetails($conn, $cafe_id, $wifi, $outlet, $open, $close, $price) {
        $sql = "UPDATE Cafes SET 
                    wifi_speed = ?, 
                    outlet_num = ?, 
                    opening_time = ?, 
                    closing_time = ?, 
                    price = ? 
                WHERE cafe_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $wifi, $outlet, $open, $close, $price, $cafe_id);
        return $stmt->execute();
    }

    function updatePhoto($conn, $photo_id, $url) {
        $sql = "UPDATE CafeIMG SET photo_url = ? WHERE photo_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $url, $photo_id);
        return $stmt->execute();
    }

    function addPhoto($conn, $cafe_id, $url) {
        $sql = "INSERT INTO CafeIMG (cafe_id, photo_url) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $cafe_id, $url);
        return $stmt->execute();
    }
?>