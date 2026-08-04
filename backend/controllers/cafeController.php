<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/cafeModel.php';

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

    public function getCafeByOwnerId($owner_id) {
        return $this->model->getCafeByOwnerId(
            $this->conn, $owner_id
        );
    }

    public function getCafePhotos($cafe_id) {
        return $this->model->getCafePhotos(
            $this->conn, $cafe_id
        );
    }

    public function updateCafeDetails($cafe_id, $wifi, $outlet, $open, $close, $price) {
        return $this->model->updateCafeDetails(
            $this->conn, $cafe_id, $wifi, $outlet, $open, $close, $price
        );
    }

    public function updatePhoto($photo_id, $url) {
        return $this->model->updatePhoto(
            $this->conn, $photo_id, $url
        );
    }

    public function addPhoto($cafe_id, $url) {
        return $this->model->addPhoto(
            $this->conn, $cafe_id, $url
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
        case "update_owner_cafe":
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $user_ID = $_SESSION['user_id'] ?? 2;

                $row = $controller->getCafeByOwnerId($user_ID);
                if (!$row) {
                    die("Cafe not found.");
                }
                $cafe_id = $row['cafe_id'];

                $wifi_speed = trim($_POST['wifi_speed'] ?? '');
                $outlet_num = trim($_POST['outlet_num'] ?? '');
                $price      = trim($_POST['price'] ?? '');
                
                $hours_input = $_POST['operating_hours'] ?? ''; 
                $times = explode('-', $hours_input);
                
                if (count($times) == 2) {
                    $opening_time = date("H:i:s", strtotime(trim($times[0])));
                    $closing_time = date("H:i:s", strtotime(trim($times[1])));
                } else {
                    $opening_time = $row['opening_time'];
                    $closing_time = $row['closing_time'];
                }

                // Update text details
                $success = $controller->updateCafeDetails($cafe_id, $wifi_speed, $outlet_num, $opening_time, $closing_time, $price);

                if ($success) {
                    // Fetch all existing photo records dynamically
                    $existing_photos = $controller->getCafePhotos($cafe_id);

                    // 1. Process Cover Photo (Index 0)
                    if (isset($_POST['cover_photo_url'])) {
                        $new_cover = trim($_POST['cover_photo_url']);
                        if (!empty($new_cover)) {
                            if (isset($existing_photos[0])) {
                                $controller->updatePhoto($existing_photos[0]['photo_id'], $new_cover);
                            } else {
                                $controller->addPhoto($cafe_id, $new_cover);
                            }
                        }
                    }

                    // Re-fetch to get accurate IDs after possible cover insert
                    $existing_photos = $controller->getCafePhotos($cafe_id);

                    // 2. Process Extra Photos (Indices 1 to N)
                    if (isset($_POST['extra_photos']) && is_array($_POST['extra_photos'])) {
                        foreach (array_values($_POST['extra_photos']) as $index => $url) {
                            $url = trim($url);
                            if (!empty($url)) {
                                $db_target_index = $index + 1; // Cover photo is index 0
                                if (isset($existing_photos[$db_target_index])) {
                                    $target_id = $existing_photos[$db_target_index]['photo_id'];
                                    $controller->updatePhoto($target_id, $url);
                                } else {
                                    $controller->addPhoto($cafe_id, $url);
                                }
                            }
                        }
                    }

                    header("Location: ../../../frontend/pages/owner/cafeInfo.php");
                    exit();
                } else {
                    echo "Error updating record.";
                    exit();
                }
            }
        break;
    }
}
?>