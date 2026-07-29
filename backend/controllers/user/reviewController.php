<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../models/user/reviewModel.php';

class reviewController {
    private $model;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new reviewModel();
    }

    public function getUserReviews($customer_id) {
        return $this->model->getUserReviews($this->conn, $customer_id);
    }
}

// handle POST actions — these still redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new reviewController($conn);
    $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 4;
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    if ($action === 'add') {
        $cafe_id = isset($_POST['cafe_id']) ? intval($_POST['cafe_id']) : 0;
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

        if ($cafe_id === 0 || $rating === 0 || $comment === '') {
            $_SESSION['review_error'] = "Please fill in all fields and select a star rating.";
            header('Location: /CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/cafeDetails.php?id=' . $cafe_id);
            exit;
        }

        $model = new reviewModel();
        if ($model->hasReviewed($conn, $customer_id, $cafe_id)) {
            $_SESSION['review_error'] = "You have already reviewed this cafe.";
            header('Location: /CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/cafeDetails.php?id=' . $cafe_id);
            exit;
        }

        $model->addReview($conn, $customer_id, $cafe_id, $rating, $comment);
        header('Location: /CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/cafeDetails.php?id=' . $cafe_id);
        exit;

    } elseif ($action === 'delete') {
        $review_id = isset($_POST['review_id']) ? intval($_POST['review_id']) : 0;
        $model = new reviewModel();
        $model->deleteReview($conn, $review_id, $customer_id);
        header('Location: /CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/postedReviews.php');
        exit;

    } elseif ($action === 'update') {
        $review_id = intval($_POST['review_id']);
        $rating = intval($_POST['rating']);
        $comment = trim($_POST['comment']);
        $model = new reviewModel();
        $model->editReview($conn, $review_id, $customer_id, $rating, $comment);
        header('Location: /CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/postedReviews.php');
        exit;
    }
}
?>