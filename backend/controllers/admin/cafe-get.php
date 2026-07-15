<?php

require_once "../../config/connection.php";
require_once "cafe-verification.php";

$controller = new CafeVerificationController($conn);

$cafe = $controller->getCafeById($_GET['id']);

header("Content-Type: application/json");

echo json_encode($cafe);

?>