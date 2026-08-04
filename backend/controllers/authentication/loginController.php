<?php
session_start();
require_once '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../../../frontend/pages/authentication/index.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please input a correct email format.";
        header("Location: ../../../frontend/pages/authentication/index.php");
        exit();
    }

    require_once '../../models/authentication/loginModel.php';
    $loginModel = new loginModel($conn);

    $userData = $loginModel->getUserByEmail($email);

        // Check if email exists
        if (!$userData) {
            $_SESSION['error'] = "Email does not exist.";
            header("Location: ../../../frontend/pages/authentication/index.php");
            exit();
        }

        // Check if password is correct
        if (!password_verify($password, $userData['password'])) {
            $_SESSION['error'] = "Invalid password.";
            header("Location: ../../../frontend/pages/authentication/index.php");
            exit();
        }

        $_SESSION['user_id']   = $userData['user_id'];
        $_SESSION['user']      = $userData['username'];
        $_SESSION['firstname'] = $userData['firstname'];
        $_SESSION['lastname']  = $userData['lastname'];
        $_SESSION['email']     = $userData['email'];
        $_SESSION['role']      = $userData['role'];

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
    header("Location: ../../../frontend/pages/authentication/index.php");
    exit();
}