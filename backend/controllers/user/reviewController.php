<?php
session_start();
require_once '../../config/connection.php';
require_once '../../models/user/reviewModel.php';

class reviewController {

    private $model;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new reviewModel();
    }

    public function addReview() {
        $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 4;

        $cafe_id = isset($_POST['cafe_id']) ? intval($_POST['cafe_id']) : 0;
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

        // validate inputs
        if ($cafe_id === 0 || $rating === 0 || $comment === '') {
            $_SESSION['review_error'] = "Please fill in all fields and select a star rating.";
            header('Location: /CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/cafeController.php?action=cafeDetails&id=' . $cafe_id);
            exit;
        }

        // check if user already reviewed this cafe
        if ($this->model->hasReviewed($this->conn, $customer_id, $cafe_id)) {
            $_SESSION['review_error'] = "You have already reviewed this cafe.";
            header('Location: /CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/cafeController.php?action=cafeDetails&id=' . $cafe_id);
            exit;
        }

        // add the review
        $this->model->addReview($this->conn, $customer_id, $cafe_id, $rating, $comment);

        // redirect back to cafe details
        header('Location: /CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/cafeController.php?action=cafeDetails&id=' . $cafe_id);
        exit;
    }

    public function deleteReview() {
        $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 4;
        $review_id = isset($_POST['review_id']) ? intval($_POST['review_id']) : 0;
        $cafe_id = isset($_POST['cafe_id']) ? intval($_POST['cafe_id']) : 0;

        $this->model->deleteReview($this->conn, $review_id, $customer_id);
        header('Location: /CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/reviewController.php?action=myReviews');
        exit;
    }

    public function getUserReviews() {
    $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 4;

    $reviews = $this->model->getUserReviews($this->conn, $customer_id);

    include '../../../frontend/pages/user/postedReviews.php';
    }

    public function updateReview() {

    $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 3;

    $review_id = intval($_POST['review_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    $this->model->editReview(
        $this->conn,
        $review_id,
        $customer_id,
        $rating,
        $comment
    );

    header("Location: reviewController.php?action=myReviews");
    exit;
}

}


$controller = new reviewController($conn);
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'add') {
    $controller->addReview();
} elseif ($action === 'delete') {
    $controller->deleteReview();
} elseif ($action === 'myReviews') {
    $controller->getUserReviews();
} elseif ($action === 'update') {
    $controller->updateReview();
} 
?>