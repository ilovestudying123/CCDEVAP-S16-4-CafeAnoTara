<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../models/user/cafeModel.php';

class cafeController {
    private $model;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new cafeModel();
    }

    public function getTopCafes() {
        return $this->model->getTopCafes($this->conn, 4);
    }

    public function getCafeDetails($cafe_id) {
        $cafe = $this->model->getCafeId($this->conn, $cafe_id);
        $images = $this->model->getCafeImages($this->conn, $cafe_id);
        $reviews = $this->model->getCafeReviews($this->conn, $cafe_id);
        return ['cafe' => $cafe, 'images' => $images, 'reviews' => $reviews];
    }

    public function getSearchResults($name) {
        if ($name === '') return [];
        return $this->model->searchCafe($this->conn, $name);
    }
}
?>