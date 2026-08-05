<?php
session_start();

require_once '../../config/connection.php';
require_once '../../models/authentication/signUpModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $userType = $_POST["userType"];

    if (
        empty($username) ||
        empty($email) ||
        empty($firstName) ||
        empty($lastName) ||
        empty($password) ||
        empty($confirmPassword) ||
        empty($userType)
    ) {
        $_SESSION["error"] = "Please fill in all fields.";
        header("Location: ../../../frontend/pages/authentication/signUp.php");
        exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Please enter a valid email.";
        header("Location: ../../../frontend/pages/authentication/signUp.php");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION["error"] = "Passwords do not match.";
        header("Location: ../../../frontend/pages/authentication/signUp.php");
        exit();
    }

    $signUpModel = new SignUpModel($conn);

    // Check if username already exists
    if ($signUpModel->getUserByUsername($username)) {
        $_SESSION["error"] = "Username already exists.";
        header("Location: ../../../frontend/pages/authentication/signUp.php");
        exit();
    }

    // Check if email already exists
    if ($signUpModel->getUserByEmail($email)) {
        $_SESSION["error"] = "Email already exists.";
        header("Location: ../../../frontend/pages/authentication/signUp.php");
        exit();
    }

    // Create the account
    if ($signUpModel->createUser(
        $username,
        $email,
        $firstName,
        $lastName,
        $password,
        $userType
    )) {

        $_SESSION["success"] = "Account created successfully! Please log in using your new account.";
        header("Location: ../../../frontend/pages/authentication/index.php");
        exit();

    } else {

        $_SESSION["error"] = "Failed to create account.";
        header("Location: ../../../frontend/pages/authentication/signUp.php");
        exit();
    }

} else {

    header("Location: ../../../frontend/pages/authentication/signUp.php");
    exit();
}