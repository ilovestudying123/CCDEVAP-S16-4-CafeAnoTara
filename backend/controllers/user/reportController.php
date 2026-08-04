<?php

require_once __DIR__ . "/../../config/connection.php";
require_once __DIR__ . "/../../models/user/reportModel.php";

class reportController
{
    private $conn;
    private $reportModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->reportModel = new reportModel();
    }

    public function getCategories() {
        return $this->reportModel->getCategories($this->conn);
    }

    public function createCategory($report) {
        return $this->reportModel->createCategory($this->conn, $report);
    }

    public function updateCategory($report_code, $report) {
        return $this->reportModel->updateCategory($this->conn, $report_code, $report );
    }

    public function deleteCategory($report_code) {
        return $this->reportModel
            ->deleteCategory(
                $this->conn,
                $report_code
            );
    }
}

if (basename($_SERVER["SCRIPT_FILENAME"]) === basename(__FILE__)) {

    $controller = new reportController($conn);
    $action = $_REQUEST["action"] ?? "";

    switch ($action) {

        case "create":

            $report = trim($_POST["report"]);

            $result = $controller->createCategory($report);

            header("Content-Type: application/json");

            echo json_encode([
                "success"=>$result
            ]);

            break;

        case "update":

            $result = $controller->updateCategory(
                $_POST["report_code"],
                $_POST["report"]
            );

            header("Content-Type: application/json");

            echo json_encode([
                "success"=>$result
            ]);

            break;
        
        case "delete":

            $result = $controller->deleteCategory(
                $_POST["report_code"]
            );

            header("Content-Type: application/json");

            echo json_encode([
                "success"=>$result
            ]);

            break;
    }
}
?>


