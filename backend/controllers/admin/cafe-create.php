<?php

require_once "../../config/connection.php";
require_once "cafe-verification.php";

$controller = new CafeVerificationController($conn);

$data = [
    "owner_id" => $_POST['owner_id'],
    "cafe_name" => $_POST['cafe_name'],
    "location" => $_POST['location'],
    "description" => $_POST['description'],
    "wifi_speed" => $_POST['wifi_speed'],
    "noise_level" => $_POST['noise_level'],
    "outlet_num" => $_POST['outlet_num'],
    "opening_time" => $_POST['opening_time'],
    "closing_time" => $_POST['closing_time'],
    "price" => $_POST['price']
];

$cafe_id = $controller->createCafe($data);
    if ($cafe_id) {
        if (isset($_POST['cafe_images'])) {
            foreach ($_POST['cafe_images'] as $imageUrl) {

                $imageUrl = trim($imageUrl);

                if ($imageUrl !== "") {
                    $controller->addCafeImage(
                        $cafe_id,
                        $imageUrl
                    );
                }
            }
        }

        header("Location: ../../../frontend/pages/admin/cafes.php");
        exit;
    }

echo "Failed to create cafe";
?>