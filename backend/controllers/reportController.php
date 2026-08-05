<?php

require_once __DIR__ . "/../config/connection.php";
require_once __DIR__ . "/../models/reportModel.php";

class reportController
{
    private $conn;
    private $reportModel;

    // constructor to initialize the database connection and model
    public function __construct($conn) {
        $this->conn = $conn;
        $this->reportModel = new reportModel();
    }

    // get all report categories
    public function getCategories() {
        return $this->reportModel->getCategories($this->conn);
    }

    // create a new report category
    public function createCategory($report) {
        return $this->reportModel->createCategory($this->conn, $report);
    }

    // update an existing report category
    public function updateCategory($report_code, $report) {
        return $this->reportModel->updateCategory($this->conn, $report_code, $report );
    }

    // delete a report category if it is not being used in the Reports table
    public function deleteCategory($report_code) {
        return $this->reportModel
            ->deleteCategory(
                $this->conn,
                $report_code
            );
    }
}

// if the script is accessed directly, handle the request based on the action parameter
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


