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

    public function getCafeById($cafe_id)
    {
        return $this->model->getCafeById(
            $this->conn,
            $cafe_id
        );
    }

    public function getPendingCafes($search, $status, $sort)
    {
        return $this->model->getPendingCafes(
            $this->conn,
            $search,
            $status,
            $sort
        );
    }

    public function getOwners()
    {
        return $this->model->getOwners($this->conn);
    }

    public function createCafe($data)
    {
        return $this->model->createCafe(
            $this->conn,
            $data
        );
    }

    public function addCafeImage($cafe_id, $photo_url)
    {
        return $this->model->addCafeImage(
            $this->conn,
            $cafe_id,
            $photo_url
        );
    }

    public function approveCafe($cafe_id)
    {
        return $this->model->approveCafe(
            $this->conn,
            $cafe_id
        );
    }

    public function rejectCafe($cafe_id)
    {
        return $this->model->rejectCafe(
            $this->conn,
            $cafe_id
        );
    }
}

if (basename($_SERVER["SCRIPT_FILENAME"]) === basename(__FILE__)) {
    
    $controller = new cafeController($conn);
    $action = $_REQUEST["action"] ?? "";

    switch ($action) {

        case "get":
            $cafe = $controller->getCafeById($_GET["id"]);
            header("Content-Type: application/json");
            echo json_encode($cafe);
            break;
        case "create":
            $data = [
                "owner_id"      => $_POST["owner_id"],
                "cafe_name"     => $_POST["cafe_name"],
                "location"      => $_POST["location"],
                "description"   => $_POST["description"],
                "wifi_speed"    => $_POST["wifi_speed"],
                "noise_level"   => $_POST["noise_level"],
                "outlet_num"    => $_POST["outlet_num"],
                "opening_time"  => $_POST["opening_time"],
                "closing_time"  => $_POST["closing_time"],
                "price"         => $_POST["price"]

            ];

            $cafe_id = $controller->createCafe($data);
            if ($cafe_id) {
                if (isset($_POST["cafe_images"])) {
                    foreach ($_POST["cafe_images"] as $imageUrl) {
                        $imageUrl = trim($imageUrl);
                        if ($imageUrl !== "") {
                            $controller->addCafeImage(
                                $cafe_id,
                                $imageUrl
                            );
                        }
                    }
                }
                header("Location: ../../../frontend/pages/admin/cafes.php");
                exit();
            }
            echo "Failed to create cafe.";
            break;
        case "approve":
            $result = $controller->approveCafe(
                $_POST["cafe_id"]);

            header("Content-Type: application/json");
            echo json_encode([
                "success" => $result]);
            break;
        case "reject":
            $result = $controller->rejectCafe(
                $_POST["cafe_id"]);

            header("Content-Type: application/json");
            echo json_encode([
                "success" => $result]);
            break;
    }
}
?>