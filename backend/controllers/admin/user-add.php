<?php
require_once "../../config/connection.php";
require_once "../../models/admin/users-sql.php";

$userModel = new UserModel($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstname = trim($_POST["firstName"]);
    $lastname  = trim($_POST["lastName"]);
    $username  = trim($_POST["username"]);
    $email     = trim($_POST["email"]);
    $phone     = trim($_POST["telno"]);
    $role      = $_POST["role"];
    $status    = $_POST["accStatus"];

    // Validation
    if (!preg_match("/^[A-Za-z -']{2,50}$/", $firstname)) {
        echo "<script>alert('Invalid first name.'); window.history.back();</script>";
        exit();
    }

    if (!preg_match("/^[A-Za-z -']{2,50}$/", $lastname)) {
        echo "<script>alert('Invalid last name.'); window.history.back();</script>";
        exit();
    }

    if (!preg_match('/^[A-Za-z0-9_]{4,20}$/', $username)) {
        echo "<script>alert('Invalid username.'); window.history.back();</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email.'); window.history.back();</script>";
        exit();
    }

    if (!preg_match('/^09\d{9}$/', $phone)) {
        echo "<script>alert('Invalid phone number.'); window.history.back();</script>";
        exit();
    }

    // Default password
    $password = "P@ss12345";

    $stmt = $userModel->addUser(
        $firstname,
        $lastname,
        $username,
        $email,
        $phone,
        $password,
        $role,
        $status
    );

    if ($stmt) {
        header("Location: ../../../frontend/pages/admin/users.php");
        exit();
    } else {
        echo "<script>alert('Failed to add user.'); window.history.back();</script>";
        exit();
    }
}