<?php
require_once "../../config/connection.php";
require_once "../../models/admin/users-sql.php";

$userModel = new UserModel($conn);

//TO DO: Implement user status change functionality
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["user_id"];
    $status = $_POST["status"];

    // Only allow valid statuses
    if (!in_array($status, ["active", "suspended"])) {
        die("Invalid status.");
    }

    $result = $userModel->updateUserStatus($id, $status);

    if ($result) {
        header("Location: ../../../frontend/pages/admin/users.php");
        exit();
    } else {
        echo "<script>
                alert('Failed to update status.');
                window.history.back();
              </script>";
        exit();
    }
}
?>