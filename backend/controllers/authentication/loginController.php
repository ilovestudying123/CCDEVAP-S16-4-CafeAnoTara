<?php
require_once '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
        include '../../../frontend/pages/authentication/index.php';
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please input a correct email format.";
        include '../../../frontend/pages/authentication/index.php';
        exit();
    }

    require_once '../../models/authentication/loginModel.php';
    $loginModel = new loginModel($conn);

    $userData = $loginModel->getUserByEmail($email);

    if ($userData && $password === $userData['password']) {
    // if ($userData && password_verify($password, $userData['password'])) {    for hashed passwords

        session_start();
        $_SESSION['user'] = $userData['username'];
        $_SESSION['user_id'] = $userData['user_id'];
        $_SESSION['role'] = $userData['role'];

        switch ($_SESSION['role']) {
            case 'customer':
                header("Location: ../../../frontend/pages/user/dashboard.php");
                exit();

            case 'owner':
                header("Location: ../../../frontend/pages/owner/dashboard.php");
                exit();

            case 'admin':
                header("Location: ../../../frontend/pages/admin/dashboard.php");
                exit();

            default:
                echo "Unknown role.";
                exit();
        }

    } else {
        $error = "Invalid email or password.";
        include '../../../frontend/pages/authentication/index.php';
        exit();
    }

} else {
    header("Location: ../../../frontend/pages/authentication/index.php");
    exit();
}