<?php
require_once "../../config/connection.php";
require_once "../../models/admin/users-sql.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_POST["user_id"];
    $status = $_POST["status"];

    $userModel = new UserModel($conn);

    if ($userModel->updateStatus($user_id, $status)) {
        header("Location: ../../../frontend/pages/admin/users.php?success=statusupdated");
    } else {
        header("Location: ../../../frontend/pages/admin/users.php?error=statusfailed");
    }
    exit();
}