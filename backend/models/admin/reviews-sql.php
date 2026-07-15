<?php

class ReviewModel {

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    //Get all reported reviews
    public function getAllReportedReviews(){
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

    $result = $this->conn->query($sql);

    if (!$result) {
        die("SQL Error: " . $this->conn->error);
    }

    return $result;
    }

    //Get specific report to update
    public function getReviewReport($reportID){

    $sql = "
        SELECT
            rp.report_id,
            rp.status,
            rp.created_on,
            rp.report_code,

            rv.review_id,
            rv.comment

        FROM Reports rp

        JOIN Users u
            ON rp.reporter_id = u.user_id

        JOIN Reviews rv
            ON rp.reported_review_id = rv.review_id

        WHERE rp.report_id = ?
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i",$reportID);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
    }

    //Get report codes
    public function getReportCodes()
    {
        $sql = "SELECT * FROM ReportCode ORDER BY report";
        return $this->conn->query($sql);
    }

    // Updates reports
    public function updateReviewReport($reportID, $status, $reportCode, $createdOn)
    {
    $sql = "
        UPDATE Reports
        SET
            status = ?,
            report_code = ?,
            created_on = ?
        WHERE report_id = ?
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "sisi",
        $status,
        $reportCode,
        $createdOn,
        $reportID
    );

    return $stmt->execute();
    }

    public function updateReview($reviewID, $comment)
    {
        $sql = "
            UPDATE Reviews
            SET comment = ?
            WHERE review_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $comment, $reviewID);

        return $stmt->execute();
    }
}
?>