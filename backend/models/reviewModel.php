<?php
class reviewModel {

    // add a new review
    public function addReview($conn, $customer_id, $cafe_id, $rating, $comment) {
        $stmt = mysqli_prepare($conn,
            "INSERT INTO Reviews (customer_id, cafe_id, rating, comment)
             VALUES (?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "iiis", $customer_id, $cafe_id, $rating, $comment);
        return mysqli_stmt_execute($stmt);
    }

    // check if user already reviewed this cafe
    public function hasReviewed($conn, $customer_id, $cafe_id) {
        $stmt = mysqli_prepare($conn,
            "SELECT review_id FROM Reviews
             WHERE customer_id = ? AND cafe_id = ?"
        );
        mysqli_stmt_bind_param($stmt, "ii", $customer_id, $cafe_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    // get all reviews by a specific user
    public function getUserReviews($conn, $customer_id) {
        $stmt = mysqli_prepare($conn,
            "SELECT r.*, c.cafe_name, c.location,
                    MIN(ci.photo_url) as main_image
             FROM Reviews r
             JOIN Cafes c ON r.cafe_id = c.cafe_id
             LEFT JOIN CafeIMG ci ON c.cafe_id = ci.cafe_id
             WHERE r.customer_id = ?
             GROUP BY r.review_id
             ORDER BY r.created_on DESC"
        );
        mysqli_stmt_bind_param($stmt, "i", $customer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // delete a review
    public function deleteReview($conn, $review_id, $customer_id) {
        // customer_id check ensures users can only delete their own reviews
        $stmt = mysqli_prepare($conn,
            "DELETE FROM Reviews
             WHERE review_id = ? AND customer_id = ?"
        );
        mysqli_stmt_bind_param($stmt, "ii", $review_id, $customer_id);
        return mysqli_stmt_execute($stmt);
    }

    // edit a review
    public function editReview($conn, $review_id, $customer_id, $rating, $comment) {
        $stmt = mysqli_prepare($conn,
            "UPDATE Reviews
             SET rating = ?, comment = ?
             WHERE review_id = ? AND customer_id = ?"
        );
        mysqli_stmt_bind_param($stmt, "isii", $rating, $comment, $review_id, $customer_id);
        return mysqli_stmt_execute($stmt);
    }

    //get a specific review by its ID
    public function getReviewById($conn, $review_id) {
    $stmt = mysqli_prepare($conn,
        "SELECT * FROM Reviews
         WHERE review_id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $review_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
    }

    public function getCafeName($conn, $cafe_id) {
        $sql = "SELECT cafe_name FROM Cafes WHERE cafe_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cafe_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ? $row['cafe_name'] : "Unknown Cafe";
    }

    // Fetches review details
    public function getReviewLookup($conn, $review_id) {
        $sql = "SELECT customer_id, cafe_id FROM Reviews WHERE review_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $review_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Creates a report
    public function createReport($conn, $reporter_id, $reported_user_id, $reported_cafe_id, $review_id, $report_code) {
        $sql = "INSERT INTO Reports (reporter_id, reported_user_id, reported_cafe_id, reported_review_id, report_code) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiii", $reporter_id, $reported_user_id, $reported_cafe_id, $review_id, $report_code);
        return $stmt->execute();
    }

    // Fetches report code options
    public function getReportCodes($conn) {
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

    // Saves an owner's reply
    public function saveOwnerReply($conn, $review_id, $reply) {
        $sql = "UPDATE Reviews SET owner_reply = ? WHERE review_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $reply, $review_id);
        return $stmt->execute();
    }

    // Fetches reviews for filtering/sorting
    public function getReviews($conn, $cafe_id, $selected_star, $selected_sort) {
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
                    u.lastname,
                    rp.report_id,
                    rp.status
                FROM Reviews r
                INNER JOIN Users u
                    ON r.customer_id = u.user_id
                LEFT JOIN Reports rp
                    ON r.review_id = rp.reported_review_id
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

    

    // ================= ADMIN REVIEW REPORT FUNCTIONS =================

    // Get all reported reviews
    public function getAllReportedReviews($conn)
    {
        $sql = "
            SELECT
                rp.report_id,
                CONCAT(u.firstname, ' ', u.lastname) AS reported_by,
                rv.review_id,
                rv.comment,
                rc.report,
                rp.created_on,
                rp.status

            FROM Reports rp

            INNER JOIN Users u
                ON rp.reporter_id = u.user_id

            INNER JOIN Reviews rv
                ON rp.reported_review_id = rv.review_id

            INNER JOIN ReportCode rc
                ON rp.report_code = rc.report_code

            ORDER BY rp.created_on DESC
        ";
        $result = $conn->query($sql);
        return $result;
    }


    // Get specific review report
    public function getReviewReport($conn, $reportID)
    {
        $sql = "
            SELECT
                rp.report_id,
                rp.status,
                rp.created_on,
                rp.report_code,

                rv.review_id,
                rv.comment

            FROM Reports rp

            JOIN Reviews rv
                ON rp.reported_review_id = rv.review_id

            WHERE rp.report_id = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "i",
            $reportID
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    // Get report categories
    public function getAdminReportCodes($conn)
    {
        $sql = "
            SELECT *
            FROM ReportCode
            ORDER BY report
        ";
        return $conn->query($sql);
    }


    // Update report details
    public function updateReviewReport(
        $conn,
        $reportID,
        $status,
        $reportCode,
        $createdOn
    )
    {
        $sql = "
            UPDATE Reports
            SET
                status = ?,
                report_code = ?,
                created_on = ?
            WHERE report_id = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sisi",
            $status,
            $reportCode,
            $createdOn,
            $reportID
        );
        return $stmt->execute();
    }

    // Update review comment
    public function updateReview(
        $conn,
        $reviewID,
        $comment
    )
    {
        $sql = "
            UPDATE Reviews
            SET comment = ?
            WHERE review_id = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "si",
            $comment,
            $reviewID
        );
        return $stmt->execute();
    }


    // Approve report
    public function approveReview(
        $conn,
        $reportID
    )
    {
        $sql = "
            UPDATE Reports
            SET status='approved'
            WHERE report_id=?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "i",
            $reportID
        );
        return $stmt->execute();
    }


    // Remove review and resolve report
    public function removeReview(
        $conn,
        $reportID,
        $reviewID
    )
    {
        // Delete review
        $stmt = $conn->prepare(
            "DELETE FROM Reviews
            WHERE review_id=?"
        );
        $stmt->bind_param(
            "i",
            $reviewID
        );
        $stmt->execute();

        // Resolve report
        $stmt = $conn->prepare(
            "UPDATE Reports
            SET status='rejected'
            WHERE report_id=?"
        );
        $stmt->bind_param(
            "i",
            $reportID
        );
        return $stmt->execute();
    }
}
?>