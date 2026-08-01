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
        FROM cafes WHERE is_verified = 0");

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
    }

    //Chart getters
    public function getUsersPerMonth() {
        $stmt= $this->conn->prepare("
        SELECT
            MONTHNAME(created_on) AS month,
            MONTH(created_on) AS month_num,
            COUNT(*) AS total
        FROM Users
        GROUP BY MONTH(created_on), MONTHNAME(created_on)
        ORDER BY month_num");

        $stmt->execute();
        return $stmt->get_result();
    }

    public function getUserPerRole() {
        $stmt = $this->conn->prepare("
        SELECT role, COUNT(*) AS total
        FROM Users
        GROUP BY role");

        $stmt->execute();
        return $stmt->get_result();
    }

    public function getHighestRatedCafes() {
        $stmt = $this->conn->prepare("
        SELECT
            c.cafe_name,
            COALESCE(ROUND(AVG(r.rating),2),0) AS average_rating
        FROM Cafes c
        LEFT JOIN Reviews r
        ON c.cafe_id = r.cafe_id
        GROUP BY c.cafe_id, c.cafe_name 
        ORDER BY average_rating DESC");

        $stmt->execute();
        return $stmt->get_result();
    }

    public function getMostBookmarkedCafes() {
         $stmt = $this->conn->prepare("
        SELECT
            c.cafe_name,
            COUNT(b.bookmark_id) bookmarks
        FROM Cafes c
        LEFT JOIN Bookmarks b
        ON c.cafe_id = b.cafe_id
        GROUP BY c.cafe_id
        ORDER BY bookmarks DESC
        LIMIT 10");

        $stmt->execute();
        return $stmt->get_result();
    }
}
?>