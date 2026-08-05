<?php

class dashboardModel
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // ================= ADMIN FUNCTIONS =================

    // Get the total number of pending reports
    public function getPendingReports() {
    $stmt = $this->conn->prepare("
        SELECT COUNT(rp.report_id) AS total
        FROM Reports rp
        INNER JOIN Users u ON rp.reporter_id = u.user_id
        INNER JOIN Reviews rv ON rp.reported_review_id = rv.review_id
        INNER JOIN ReportCode rc ON rp.report_code = rc.report_code
        WHERE rp.status = 'ongoing'
    ");

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
    }

    // Get the total number of pending cafes
    public function getPendingCafes() {
        $stmt = $this->conn->prepare("
        SELECT COUNT(cafe_id) AS total
        FROM cafes WHERE is_verified = 0");

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
    }

    // ================= ADMIN CHART GETTERS =================

    // Get the number of users registered per month
    public function getUsersPerMonth() {
    $stmt = $this->conn->prepare("
        SELECT
            DATE_FORMAT(created_on, '%Y-%m') AS month_key,
            MONTHNAME(created_on) AS month,
            YEAR(created_on) AS year,
            role,
            COUNT(*) AS total
        FROM Users
        GROUP BY DATE_FORMAT(created_on, '%Y-%m'), MONTHNAME(created_on), YEAR(created_on), role
        ORDER BY month_key");

    $stmt->execute();
    return $stmt->get_result();
    }

    // Get the number of users per role 
    public function getUserPerRole() {
        $stmt = $this->conn->prepare("
        SELECT role, COUNT(*) AS total
        FROM Users
        GROUP BY role");

        $stmt->execute();
        return $stmt->get_result();
    }

    // Calculate the weighted rating for each cafe based on the number of reviews and average rating
    public function getRankedCafes($minReviews = 5) {
        // C = average rating across all cafes (with at least 1 review)
        $stmt = $this->conn->prepare("
        SELECT
            c.cafe_id,
            c.cafe_name,
            COUNT(r.review_id) AS review_count,
            COALESCE(ROUND(AVG(r.rating), 2), 0) AS average_rating,
            (
                SELECT AVG(rating) FROM Reviews
            ) AS overall_avg
        FROM Cafes c
        LEFT JOIN Reviews r
        ON c.cafe_id = r.cafe_id
        GROUP BY c.cafe_id, c.cafe_name");

        $stmt->execute();
        $result = $stmt->get_result();

        $cafes = [];
        while ($row = $result->fetch_assoc()) {
            $v = (int) $row['review_count'];
            $R = (float) $row['average_rating'];
            $C = (float) $row['overall_avg'];
            $m = $minReviews;

            // Calculate the weighted rating using the average formula
            $row['weighted_rating'] = $v > 0
                ? round((($v / ($v + $m)) * $R) + (($m / ($v + $m)) * $C), 2)
                : 0;

            $cafes[] = $row;
        }

        // Sort by weighted rating, descending
        usort($cafes, fn($a, $b) => $b['weighted_rating'] <=> $a['weighted_rating']);

        return $cafes;
    }

    // Get the top 10 most bookmarked cafes
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