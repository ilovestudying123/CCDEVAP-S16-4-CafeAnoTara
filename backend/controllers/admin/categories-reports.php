<?php
require_once __DIR__ . "/../../models/admin/categories-sql.php";

class CategoriesController
{
    private $conn;
    private $categoriesModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->categoriesModel = new CategoriesModel();
    }

    public function getCategories() {
        return $this->categoriesModel->getCategories($this->conn);
    }

    public function createCategory($report) {
        return $this->categoriesModel->createCategory($this->conn, $report);
    }

    public function updateCategory($report_code, $report) {
        return $this->categoriesModel->updateCategory($this->conn, $report_code, $report );
    }

    public function deleteCategory($report_code) {
        return $this->categoriesModel
            ->deleteCategory(
                $this->conn,
                $report_code
            );
    }
}
?>