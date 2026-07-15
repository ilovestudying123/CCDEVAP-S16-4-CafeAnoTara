<?php
require_once "../config/connection.php";
require_once "../models/UserModel.php";

$userModel = new UserModel($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);

    if (empty($firstname)) {
        die("First name is required.");
    }

    $userModel->createUser($firstname, $lastname);

    header("Location: ../../frontend/pages/admin/users.php");
    exit();
}
?>