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
        if (isset($_FILES['cafe_images'])) {
            $images = $_FILES['cafe_images'];
            for ($i = 0; $i < count($images['name']); $i++) {
                if ($images['error'][$i] == 0) {
                    $imageName = $images['name'][$i];
                    $uploadPath = "../../../frontend/resources/imgs/" . $imageName;

                    move_uploaded_file(
                        $images['tmp_name'][$i],
                        $uploadPath
                    );
                    
                    $controller->addCafeImage(
                        $cafe_id,
                        $imageName
                    );
                }
            }
        }

        header("Location: ../../../frontend/pages/admin/cafes.php");
        exit;
    }

echo "Failed to create cafe";
?>