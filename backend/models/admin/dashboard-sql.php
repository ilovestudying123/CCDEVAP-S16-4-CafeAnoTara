<?php
class UserDashboard 
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function getPendingReports() {
        $stmt = $this->conn->prepare("
        SELECT COUNT(report_id) AS total
        FROM reports WHERE status = 'ongoing'
    ");

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
    }

    public function getPendingCafes() {
        $stmt = $this->conn->prepare("
        SELECT COUNT(cafe_id) AS total
        FROM cafes WHERE is_verified != 1");

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
    }
}
?>