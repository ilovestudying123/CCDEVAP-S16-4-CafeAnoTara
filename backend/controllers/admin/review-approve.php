<?php
require_once "../../config/connection.php";
require_once "../../models/admin/reviews-sql.php";

$model = new ReviewModel($conn);
$model->approveReview($_POST["report_id"]);

echo json_encode([
    "success" => true
]);