<?php
require_once "../../config/connection.php";
require_once "categories-reports.php";

$controller = new CategoriesController($conn);

$report_code = $_POST['report_code'];
$report = $_POST['report'];

$result = $controller->updateCategory(
    $report_code,
    $report
);

header("Content-Type: application/json");

echo json_encode([
    "success"=>$result
]);
?>