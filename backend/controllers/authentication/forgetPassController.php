<?php
session_start();
require_once '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST["email"]);
    $newPassword = $_POST["newpassword"];
    $confirmPassword = $_POST["confnewpassword"];

    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../../../frontend/pages/authentication/forgotPassword.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please input a valid email.";
        header("Location: ../../../frontend/pages/authentication/forgotPassword.php");
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../../../frontend/pages/authentication/forgotPassword.php");
        exit();
    }

    require_once '../../models/authentication/forgotPassModel.php';
    $forgotPassModel = new ForgotPassModel($conn);

    $userData = $forgotPassModel->getUserByEmail($email);

    if (!$userData) {
        $_SESSION['error'] = "Email does not exist.";
        header("Location: ../../../frontend/pages/authentication/forgotPassword.php");
        exit();
    }

    $forgotPassModel->updatePassword($email, $newPassword);

    $_SESSION['success'] = "Password updated successfully.";
    header("Location: ../../../frontend/pages/authentication/index.php");
    exit();

} else {
    header("Location: ../../../frontend/pages/authentication/index.php");
    exit();
}