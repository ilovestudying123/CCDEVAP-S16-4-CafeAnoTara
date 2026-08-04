<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/bookmarkModel.php';

class bookmarkController {
    private $model;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new bookmarkModel();
    }

    public function getBookmarks($customer_id) {
        return $this->model->getUserBookmarks($this->conn, $customer_id);
    }

    public function addBookmark($customer_id, $cafe_id) {
        $bookmarks = $this->model->getUserBookmarks($this->conn, $customer_id);
        if (count($bookmarks) >= 10) {
            $_SESSION['bookmark_error'] = "You can only bookmark up to 10 cafes.";
            return false;
        }
        if ($this->model->isBookmarked($this->conn, $customer_id, $cafe_id)) {
            $_SESSION['bookmark_error'] = "You have already bookmarked this cafe.";
            return false;
        }
        return $this->model->addBookmark($this->conn, $customer_id, $cafe_id);
    }

    public function removeBookmark($customer_id, $cafe_id) {
        return $this->model->removeBookmark($this->conn, $customer_id, $cafe_id);
    }

    public function isBookmarked($customer_id, $cafe_id) {
        return $this->model->isBookmarked($this->conn, $customer_id, $cafe_id);
    }
}

// handle POST actions (add/remove) — these still redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new bookmarkController($conn);
    $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 4;
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $cafe_id = isset($_POST['cafe_id']) ? intval($_POST['cafe_id']) : 0;

    if ($action === 'add') {
        $controller->addBookmark($customer_id, $cafe_id);
        header('Location: /CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/cafeDetails.php?id=' . $cafe_id);
        exit;
    } elseif ($action === 'remove') {
        $controller->removeBookmark($customer_id, $cafe_id);
        header('Location: /CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/bookmarks.php');
        exit;
    }
}
?>