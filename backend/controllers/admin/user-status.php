<?php
require_once "../../config/connection.php";
require_once "../../models/admin/users-sql.php";

$userModel = new UserModel($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["user_id"];
    $status = $_POST["status"];

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