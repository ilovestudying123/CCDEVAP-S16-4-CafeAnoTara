<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();


require_once '../../config/connection.php';
require_once '../../models/user/BookmarkModel.php';
require_once '../../models/user/CafeModel.php';

class bookmarkController {
    private $model;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new bookmarkModel();
    }

    public function showBookmarks() {
        //$customer_id = $_SESSION['user_id'];
        $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 3;
        $bookmarks = $this->model->getUserBookmarks($this->conn, $customer_id);
        include '../../../frontend/pages/user/bookmarks.php';
    }

    public function addBookmark() {
        //$customer_id = $_SESSION['user_id'];
        $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 3;
        $cafe_id = isset($_POST['cafe_id']) ? intval($_POST['cafe_id']) : 0;

        // check if already at 10 bookmark limit
        $bookmarks = $this->model->getUserBookmarks($this->conn, $customer_id);
        if (count($bookmarks) >= 10) {
            $_SESSION['bookmark_error'] = "You can only bookmark up to 10 cafes.";
            header('Location: cafeController.php?action=cafeDetails&id=' . $cafe_id);
            exit;
        }

        // check if already bookmarked
        if ($this->model->isBookmarked($this->conn, $customer_id, $cafe_id)) {
            header('Location: cafeController.php?action=cafeDetails&id=' . $cafe_id);
            exit;
        }

        // add bookmark
        $this->model->addBookmark($this->conn, $customer_id, $cafe_id);
        header('Location: cafeController.php?action=cafeDetails&id=' . $cafe_id);
        exit;
    }

    //remove bookmark
    public function removeBookmark() {
        //$customer_id = $_SESSION['user_id'];
        $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 3;
        $cafe_id = isset($_POST['cafe_id']) ? intval($_POST['cafe_id']) : 0;

        $this->model->removeBookmark($this->conn, $customer_id, $cafe_id);
        header('Location: bookmarkController.php?action=bookmarks');
        exit;
    }
}

$controller = new bookmarkController($conn);
$action = isset($_GET['action']) ? $_GET['action'] : 'bookmarks';

if ($action === 'bookmarks') {
    $controller->showBookmarks();
} elseif ($action === 'add') {
    $controller->addBookmark();
} elseif ($action === 'remove') {
    $controller->removeBookmark();
}
?>
