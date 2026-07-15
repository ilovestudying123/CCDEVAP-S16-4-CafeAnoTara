<?php

require_once "../../config/connection.php";
require_once "cafe-verification.php";

$controller = new CafeVerificationController($conn);

// collect form data from the add cafe form
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


// insert the cafe into the Cafes table
$cafe_id = $controller->createCafe($data);
    if ($cafe_id) {
        // save each image URL into the CafeIMG table
        if (isset($_POST['cafe_images'])) {
            foreach ($_POST['cafe_images'] as $imageUrl) {

                $imageUrl = trim($imageUrl);

                // skip empty image URL fields
                if ($imageUrl !== "") {
                    $controller->addCafeImage(
                        $cafe_id,
                        $imageUrl
                    );
                }
            }
        }

        // return to the Cafe Verification page
        header("Location: ../../../frontend/pages/admin/cafes.php");
        exit;
    }

echo "Failed to create cafe";
?>