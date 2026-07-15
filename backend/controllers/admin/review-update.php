<?php

require_once "../../config/connection.php";
require_once "../../models/admin/reviews-sql.php";

$model = new ReviewModel($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $model = new ReviewModel($conn);

    $result1 = $model->updateReviewReport(
        $_POST['reportID'],
        $_POST['status'],
        $_POST['reason'],
        $_POST['dateCreated']
    );

    $result2 = $model->updateReview(
        $_POST['reviewID'],
        $_POST['review']
    );

    header("Location: ../../../frontend/pages/admin/reviews.php");
    exit;
} else {
    header("Location: ../../../frontend/pages/admin/reviews.php");
    exit;
}