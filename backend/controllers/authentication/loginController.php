<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
        include 'login.php';
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please input a correct email format.";
        include 'login.php';
        exit();
    }

    require_once '../../../backend/models/loginModel.php';
    $loginModel = new loginModel();
    
    $userData = $loginModel->getUserByEmail($email);

    if ($userData && $password === $userData['password']) {
        
        session_start();
        $_SESSION['user'] = $userData['username'];
        $_SESSION['user_id'] = $userData['user_id'];
        $_SESSION['role'] = $userData['role'];

        if ($_SESSION['role'] === 'customer') {
            header("Location: ../user/dashboard.php");
            exit();
        } else if ($_SESSION['role'] === 'owner') {
            header("Location: ../owner/dashboard.php");
            exit();
        } else if ($_SESSION['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            echo "Unknown role.";
            exit();
        }

    } else {
        $error = "Invalid email or password.";
        include 'login.php';
        exit();
    }

} else {
    header("Location: login.php");
    exit();
}
?>
