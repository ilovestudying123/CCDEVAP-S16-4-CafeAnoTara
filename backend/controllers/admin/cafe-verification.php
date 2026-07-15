<?php

require_once __DIR__ . '../../../config/connection.php';
require_once __DIR__ . "/../../models/admin/cafeVerificationModel.php";

class CafeVerificationController
{
    private $conn;
    private $cafeVerificationModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->cafeVerificationModel = new CafeVerificationModel();
    }

    public function getCafeById($cafe_id) {
        return $this->cafeVerificationModel->getCafeById($this->conn, $cafe_id);
    }

    public function getPendingCafes($search, $status, $sort) {
        return $this->cafeVerificationModel->getPendingCafes($this->conn, $search, $status, $sort);
    }

    public function getOwners() {
        return $this->cafeVerificationModel->getOwners($this->conn);
    }

    public function createCafe($data) {
        return $this->cafeVerificationModel->createCafe($this->conn, $data);
    }

    public function addCafeImage($cafe_id, $photo_url) {
        return $this->cafeVerificationModel->addCafeImage($this->conn, $cafe_id, $photo_url);
    }

    public function approveCafe($cafe_id) {
        return $this->cafeVerificationModel->approveCafe($this->conn, $cafe_id);
    }   
 
    public function rejectCafe($cafe_id) {
        return $this->cafeVerificationModel->rejectCafe($this->conn, $cafe_id);
    }
}
?>