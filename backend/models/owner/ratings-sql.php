<?php
require_once __DIR__ . "/../../config/connection.php";

// Fetches cafe name
function getCafeName($conn, $cafe_id) {
    $sql = "SELECT cafe_name FROM Cafes WHERE cafe_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cafe_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ? $row['cafe_name'] : "Unknown Cafe";
}

// Fetches review details
function getReviewLookup($conn, $review_id) {
    $sql = "SELECT customer_id, cafe_id FROM Reviews WHERE review_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function createReport($conn, $reporter_id, $reported_user_id, $reported_cafe_id, $review_id, $report_code) {
    $sql = "INSERT INTO Reports (reporter_id, reported_user_id, reported_cafe_id, reported_review_id, report_code) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiii", $reporter_id, $reported_user_id, $reported_cafe_id, $review_id, $report_code);
    return $stmt->execute();
}

function getReportCodes($conn) {
    $sql = "SELECT report_code, report FROM ReportCode";
    $result = $conn->query($sql);
    $codes = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $codes[] = $row;
        }
    }
    return $codes;
}

function saveOwnerReply($conn, $review_id, $reply) {
    $sql = "UPDATE Reviews SET owner_reply = ? WHERE review_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $reply, $review_id);
    return $stmt->execute();
}

// Fetches the reviews for filtering
function getReviews($conn, $cafe_id, $selected_star, $selected_sort) {
    $filter_condition = "";
    if (!empty($selected_star)) {
        if ($selected_star === "five") {
            $filter_condition = " AND r.rating = 5 ";
        } elseif ($selected_star === "four") {
            $filter_condition = " AND r.rating >= 4 ";
        } elseif ($selected_star === "three") {
            $filter_condition = " AND r.rating >= 3 ";
        } elseif ($selected_star === "two") {
            $filter_condition = " AND r.rating >= 2 ";
        } elseif ($selected_star === "one") {
            $filter_condition = " AND r.rating >= 1 ";
        }
    }

    $sort_order = " r.created_on DESC "; 
    if (!empty($selected_sort)) {
        if ($selected_sort === "old") {
            $sort_order = " r.created_on ASC ";
        } else {
            $sort_order = " r.created_on DESC ";
        }
    }

    $sql = "SELECT 
                r.review_id,
                r.rating,
                r.comment,
                r.owner_reply,
                u.firstname,
                u.lastname
            FROM 
                Reviews r
            INNER JOIN 
                Users u ON r.customer_id = u.user_id
            WHERE 
                r.cafe_id = ? 
                $filter_condition
            ORDER BY 
                $sort_order";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cafe_id);
    $stmt->execute();
    return $stmt->get_result();
}
?>