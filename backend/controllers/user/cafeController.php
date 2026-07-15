<?php
require_once '../../config/connection.php';
require_once '../../models/user/cafeModel.php';

class cafeController {
    private $model;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new cafeModel();
    }

    public function showTopCafes() {
        $cafes = $this->model->getTopCafes($this->conn, 4);
        include '../../../frontend/pages/user/dashboard.php';
    }

    public function showCafeDetails() {
        $cafe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($cafe_id == 0) {
            header('Location: cafeController.php?action=dashboard');
            exit;
        }

        $cafe = $this->model->getCafeById($this->conn, $cafe_id);
        $images = $this->model->getCafeImages($this->conn, $cafe_id);
        $reviews = $this->model->getCafeReviews($this->conn, $cafe_id);

        if (!$cafe) {
            echo "Cafe not found.";
            return;
        }

        include '../../../frontend/pages/user/cafeDetails.php';
    }

    public function showSearch() {
         $name = isset($_GET['name']) ? trim($_GET['name']) : '';
        $results = [];

        if ($name !== '') {
            $results = $this->model->searchCafe($this->conn, $name);
        }

        include '../../../frontend/pages/user/search.php';
    }
}

    $controller = new cafeController($conn);
    $action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

    if ($action === 'dashboard') {
        $controller->showTopCafes();
    } elseif ($action === 'cafeDetails') {
        $controller->showCafeDetails();
    } elseif ($action === 'search') {
        $controller->showSearch();
    }

?>
