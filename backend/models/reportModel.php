<?php
class reportModel
{
    public function getCategories($conn) {
        $stmt = mysqli_prepare(
            $conn,
            "SELECT *
             FROM ReportCode
             ORDER BY report ASC"
        );
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function createCategory($conn, $report) {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO ReportCode (report)
            VALUES (?)"
        );
        mysqli_stmt_bind_param($stmt, "s", $report);
        return mysqli_stmt_execute($stmt);
    }

    public function updateCategory($conn, $report_code, $report) {
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE ReportCode
            SET report = ?
            WHERE report_code = ?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $report,
            $report_code
        );
        return mysqli_stmt_execute($stmt);
        }

    public function deleteCategory($conn, $report_code) {
        // Check if category is being used
        $check = mysqli_prepare(
            $conn,
            "SELECT COUNT(*) AS total
            FROM Reports
            WHERE report_code = ?"
        );

        mysqli_stmt_bind_param(
            $check,
            "i",
            $report_code
        );

        mysqli_stmt_execute($check);

        $result = mysqli_stmt_get_result($check);
        $row = mysqli_fetch_assoc($result);

        // Category is still used
        if ($row['total'] > 0) {
            return false;
        }

        // Safe to delete
        $stmt = mysqli_prepare(
            $conn,
            "DELETE FROM ReportCode
            WHERE report_code = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $report_code
        );

        return mysqli_stmt_execute($stmt);
    }
}
?>