<?php
require_once "../../config/connection.php";
require_once "../../models/admin/users-sql.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["user_id"];

    $userModel = new UserModel($conn);

    if ($userModel->deleteUser($id)) {
        header("Location: ../../../frontend/pages/admin/users.php?success=deleted");
        exit();
    } else {
        header("Location: ../../../frontend/pages/admin/users.php?error=deletefailed");
        exit();
    }
}