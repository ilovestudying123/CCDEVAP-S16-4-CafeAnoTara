<?php

require_once "../../config/connection.php";
require_once "cafe-verification.php";

$controller = new CafeVerificationController($conn);

$cafe_id = $_POST['cafe_id'];

$result = $controller->approveCafe($cafe_id);

header("Content-Type: application/json");

echo json_encode([
    "success" => $result
]);

?>