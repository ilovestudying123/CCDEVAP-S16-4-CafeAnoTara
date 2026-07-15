<?php
require_once "../../config/connection.php";
require_once "../../models/admin/users-sql.php";

$userModel = new UserModel($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["user_id"];
    $firstname = trim($_POST["firstName"]);
    $lastname = trim($_POST["lastName"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["telno"]);
    $role = $_POST["role"];
    $status = $_POST["accStatus"];

    // Double Validation

    // firstname and lastname should only contain letters, spaces, hyphens, and apostrophes
    if (!preg_match("/^[A-Za-z\s'-]{2,50}$/", $firstname)) {

        $message = "First name must be 2-50 characters and contain only letters, spaces, apostrophes, or hyphens.";

        echo "<script> alert('$message'); window.history.back(); </script>";
        exit();
    }
    if (!preg_match("/^[A-Za-z\s'-]{2,50}$/", $lastname)) {
        $message = "Last name must be 2-50 characters and contain only letters, spaces, apostrophes, or hyphens.";
        echo "<script> alert('$message'); window.history.back(); </script>";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email address.";
        echo "<script> alert('$message'); window.history.back(); </script>";
        exit();
    }

    // Validate phone number format (assuming using PH mobile numbers)
    if (!preg_match('/^09\d{9}$/', $phone)) {
        $message = "Please enter a valid Philippine mobile number (e.g., 09123456789).";
        echo "<script> alert('$message'); window.history.back(); </script>";
        exit();
    }

    // Validate username (alphanumeric and underscores, 4-20 characters)
    if (!preg_match('/^[A-Za-z0-9_]{4,20}$/', $username)) {
        $message = "Username must be 4-20 characters and contain only letters, numbers, or underscores.";
        echo "<script> alert('$message'); window.history.back(); </script>";
        exit();
    }

    // Update user
    $stmt = $userModel->updateUser(
        $id,
        $firstname,
        $lastname,
        $username,
        $email,
        $phone,
        $role,
        $status
    );

    if ($stmt) {
        header("Location:../../../frontend/pages/admin/users.php");
        exit();
    } else {
        $message = "Failed to update user.";
        echo "<script> alert('$message'); window.history.back(); </script>";
        exit();
    }
}
?>