<?php
require_once "../../config/connection.php";
require_once "../../models/admin/reviews-sql.php";

$model = new ReviewModel($conn);
$model->removeReview(
    $_POST["report_id"],
    $_POST["review_id"]
);

echo json_encode([
    "success" => true
]);