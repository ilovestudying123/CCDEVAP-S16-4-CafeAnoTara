<?php
require_once "../../config/connection.php";
require_once "categories-reports.php";

$controller = new CategoriesController($conn);
$report = trim($_POST["report"]);
$result = $controller->createCategory($report);

header("Content-Type: application/json");

echo json_encode([
    "success" => $result
]);
?>