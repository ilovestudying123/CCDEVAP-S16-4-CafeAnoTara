    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/../config/connection.php';
    require_once __DIR__ . '/../models/reviewModel.php';

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

        public function getCafeRatingsData($cafe_id, $selected_star = '', $selected_sort = '') {
            return [
                'cafe_name'      => $this->model->getCafeName($this->conn, $cafe_id),
                'report_codes'   => $this->model->getReportCodes($this->conn),
                'reviews_result' => $this->model->getReviews($this->conn, $cafe_id, $selected_star, $selected_sort)
            ];
        }

        /** Processes report submission */
        public function submitReport($reporter_id, $review_id, $report_code) {
            if ($review_id <= 0 || $reporter_id <= 0 || $report_code <= 0) {
                return false;
            }

            $review_data = $this->model->getReviewLookup($this->conn, $review_id);
            if (!$review_data) {
                return false;
            }

            $reported_user_id = $review_data['customer_id'];
            $reported_cafe_id = $review_data['cafe_id'];

            return $this->model->createReport(
                $this->conn,
                $reporter_id,
                $reported_user_id,
                $reported_cafe_id,
                $review_id,
                $report_code
            );
        }

        /** Processes owner reply submission */
        public function submitReply($review_id, $reply) {
            if ($review_id <= 0 || empty($reply)) {
                return false;
            }

            return $this->model->saveOwnerReply($this->conn, $review_id, $reply);
        }

        // ADMIN REVIEW FUNCTIONS

        public function getAllReportedReviews() {
            return $this->model->getAllReportedReviews($this->conn);
        }

        public function getReviewReport($reportID) {
            return $this->model->getReviewReport($this->conn, $reportID);
        }

        public function getReportCodes() {
            return $this->model->getAdminReportCodes($this->conn);
        }

        public function approveReview($reportID) {
            return $this->model->approveReview($this->conn, $reportID);
        }

        public function removeReview($reportID, $reviewID) {
            return $this->model->removeReview(
                $this->conn,
                $reportID,
                $reviewID
            );
        }

        public function updateReviewReport($data) {

            $result1 = $this->model->updateReviewReport(
                $this->conn,
                $data['reportID'],
                $data['status'],
                $data['reason'],
                $data['dateCreated']
            );


            $result2 = $this->model->updateReview(
                $this->conn,
                $data['reviewID'],
                $data['review']
            );


            return ($result1 && $result2);
        }
    }

    // handle POST actions — these still redirect
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new reviewController($conn);
        $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 4;
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if ($action === 'addReview') {
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

        if (isset($_POST['submit_report']) || isset($_POST['report_code'])) {
            $review_id   = isset($_POST['review_id']) ? intval($_POST['review_id']) : 0;
            $reporter_id = isset($_POST['reporter_id']) ? intval($_POST['reporter_id']) : 0;
            $report_code = isset($_POST['report_code']) ? intval($_POST['report_code']) : 0;

            $success = $controller->submitReport($reporter_id, $review_id, $report_code);

            $status = $success ? 'success' : 'error';
            header("Location: ../../../frontend/pages/owner/ratings.php?report=" . $status);
            exit();
        }

        // handles owner reply submissions
        if (isset($_POST['owner_reply'])) {
            $review_id   = intval($_POST['review_id']);
            $owner_reply = trim($_POST['owner_reply']);

            $controller->submitReply($review_id, $owner_reply);

            $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '../../../frontend/pages/owner/ratings.php';
            header("Location: " . $redirectUrl);
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $controller = new reviewController($conn);
        $action = $_GET["action"] ?? "";

        switch($action) {
            case "approveReview":
                $success = $controller->approveReview(
                    $_POST["report_id"]
                );
                echo json_encode([
                    "success"=>$success
                ]);
                exit;

            case "removeReview":
                $success = $controller->removeReview(
                    $_POST["report_id"],
                    $_POST["review_id"]
                );
                echo json_encode([
                    "success"=>$success
                ]);

                exit;

            case "updateReview":
                $success = $controller->updateReviewReport($_POST);
                if($success){
                    header(
                        "Location: ../../../frontend/pages/admin/reviews.php"
                    );
                } else {
                    header(
                        "Location: ../../../frontend/pages/admin/reviews.php?error=update"
                    );
                }

                exit;
        }
    }
    ?>