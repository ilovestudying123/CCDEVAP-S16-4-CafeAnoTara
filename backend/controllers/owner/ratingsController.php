<?php
require_once __DIR__ . "/../../models/owner/ratings-sql.php";

$cafe_id = 1; 
$current_user_id = 2; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_report'])) {
    $review_id = isset($_POST['review_id']) ? intval($_POST['review_id']) : 0;
    $reporter_id = isset($_POST['reporter_id']) ? intval($_POST['reporter_id']) : 0;
    $report_code = isset($_POST['report_code']) ? intval($_POST['report_code']) : 0;

    if ($review_id > 0 && $reporter_id > 0 && $report_code > 0) {
        $review_data = getReviewLookup($conn, $review_id);

        if ($review_data) {
            $reported_user_id = $review_data['customer_id'];
            $reported_cafe_id = $review_data['cafe_id'];

            if (createReport($conn, $reporter_id, $reported_user_id, $reported_cafe_id, $review_id, $report_code)) {
                // Redirects back to ratings.php
                header("Location: ../../../frontend/pages/owner/ratings.php?report=success");
                exit();
            } else {
                header("Location: ../../../frontend/pages/owner/ratings.php?report=error");
                exit();
}
        } else {
            echo "<script>alert('Error: Target review not found.');</script>";
        }
    } else {
        echo "<script>alert('Error: Missing required form fields.');</script>";
    }
}

// Saves the reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['owner_reply'])) {
    $review_id = intval($_POST['review_id']);
    $owner_reply = trim($_POST['owner_reply']);

    if (saveOwnerReply($conn, $review_id, $owner_reply)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error saving your reply: " . $conn->error;
    }
}

$cafe_name = getCafeName($conn, $cafe_id);
$report_codes = getReportCodes($conn);

$selected_star = isset($_GET['stars']) ? $_GET['stars'] : '';
$selected_sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$reviews_result = getReviews($conn, $cafe_id, $selected_star, $selected_sort);