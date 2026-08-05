<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../config/connection.php";
require_once __DIR__ . "/../models/userModel.php";

class UserController
{
    private $conn;
    private $model;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->model = new userModel($conn);
    }

    /*  ==========================================================
        GET CURRENT USER
        ========================================================== */
        public function getUser($user_id)
        {
            return $this->model->getUser($user_id);
        }

    /*  ==========================================================
        UPDATE PROFILE
        ========================================================== */
        public function updateProfile($user_id, $username, $firstname, $lastname, $mobilenumber)
        {
            return $this->model->updateProfile(
                $user_id,
                $username,
                $firstname,
                $lastname,
                $mobilenumber
            );
        }

    /* ==========================================================
       ADD USER
       ========================================================== */
    public function addUser($data)
    {
        $firstname = trim($data["firstName"]);
        $lastname  = trim($data["lastName"]);
        $username  = trim($data["username"]);
        $email     = trim($data["email"]);
        $phone     = trim($data["telno"]);
        $role      = $data["role"];
        $status    = $data["accStatus"];

        // Validation
        if (!preg_match("/^[A-Za-z -']{2,50}$/", $firstname)) {
            return false;}
        if (!preg_match("/^[A-Za-z -']{2,50}$/", $lastname)) {
            return false;
        }
        if (!preg_match('/^[A-Za-z0-9_]{4,20}$/', $username)) {
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (!preg_match('/^09\d{9}$/', $phone)) {
            return false;
        }

        $password = password_hash("P@ss12345", PASSWORD_DEFAULT);

        return $this->model->addUser(
            $firstname,
            $lastname,
            $username,
            $email,
            $phone,
            $password,
            $role,
            $status
        );
    }

    /* ==========================================================
       UPDATE USER
       ========================================================== */
    public function updateUser($data)
    {
        return $this->model->updateUser(
            $data["user_id"],
            trim($data["firstName"]),
            trim($data["lastName"]),
            trim($data["username"]),
            trim($data["email"]),
            trim($data["telno"]),
            $data["role"],
            $data["accStatus"]
        );
    }

    /* ==========================================================
       DELETE USER
       ========================================================== */
    public function deleteUser($user_id)
    {
        return $this->model->deleteUser($user_id);
    }

    /* ==========================================================
       UPDATE ACCOUNT STATUS
       ========================================================== */
    public function updateStatus($user_id, $status)
    {
        return $this->model->updateStatus($user_id, $status);
    }

    /*  ==========================================================
        UPDATE ACCOUNT STATUS
        ========================================================== */
    public function getUserByEmail($email)
    {
        return $this->model->getUserByEmail($email);
    }

    public function getUserByUsername($username)
    {
        return $this->model->getUserByUsername($username);
    }

    public function createUser(
        $username,
        $email,
        $firstName,
        $lastName,
        $password,
        $userType
    ) {
        return $this->model->createUser(
            $username,
            $email,
            $firstName,
            $lastName,
            $password,
            $userType
        );
    }

    public function updatePassword($email, $password)
    {
        return $this->model->updatePassword($email, $password);
    }

    /* ==========================================================
       LOGIN
       ========================================================== */
    public function login($data)
    {
        $email = trim($data["email"]);
        $password = $data["password"];

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Please fill in all fields.";
            header("Location: ../../frontend/pages/authentication/index.php");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Please input a correct email format.";
            header("Location: ../../frontend/pages/authentication/index.php");
            exit();
        }

        $userData = $this->model->getUserByEmail($email);

        if (!$userData) {
            $_SESSION['error'] = "Email does not exist.";
            header("Location: ../../frontend/pages/authentication/index.php");
            exit();
        }

        if (!password_verify($password, $userData['password'])) {
            $_SESSION['error'] = "Invalid password.";
            header("Location: ../../frontend/pages/authentication/index.php");
            exit();
        }

        $_SESSION['user_id']   = $userData['user_id'];
        $_SESSION['user']      = $userData['username'];
        $_SESSION['firstname'] = $userData['firstname'];
        $_SESSION['lastname']  = $userData['lastname'];
        $_SESSION['email']     = $userData['email'];
        $_SESSION['role']      = $userData['role'];

        $_SESSION['success'] = "Login successful.";

        switch ($_SESSION['role']) {

            case 'customer':
                header("Location: ../../frontend/pages/user/dashboard.php");
                break;

            case 'owner':
                header("Location: ../../frontend/pages/owner/dashboard.php");
                break;

            case 'admin':
                header("Location: ../../frontend/pages/admin/dashboard.php");
                break;

            default:
                echo "Unknown role.";
                exit();
        }

        exit();
    }

    /* ==========================================================
       SIGN UP
       ========================================================== */
    public function signup($data)
    {
        $username = trim($data["username"]);
        $email = trim($data["email"]);
        $firstName = trim($data["firstName"]);
        $lastName = trim($data["lastName"]);
        $password = $data["password"];
        $confirmPassword = $data["confirmPassword"];
        $userType = $data["userType"];

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
            header("Location: ../../frontend/pages/authentication/signUp.php");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"] = "Please enter a valid email.";
            header("Location: ../../frontend/pages/authentication/signUp.php");
            exit();
        }

        if ($password !== $confirmPassword) {
            $_SESSION["error"] = "Passwords do not match.";
            header("Location: ../../frontend/pages/authentication/signUp.php");
            exit();
        }

        if ($this->model->getUserByUsername($username)) {
            $_SESSION["error"] = "Username already exists.";
            header("Location: ../../frontend/pages/authentication/signUp.php");
            exit();
        }


        if ($this->model->getUserByEmail($email)) {
            $_SESSION["error"] = "Email already exists.";
            header("Location: ../../frontend/pages/authentication/signUp.php");
            exit();
        }

        if ($this->model->createUser(
            $username,
            $email,
            $firstName,
            $lastName,
            $password,
            $userType
        )) {

            // $_SESSION["success"] = "Account created successfully! Please log in using your new account.";
            $_SESSION["success_title"] = "Account Created!";
            $_SESSION["success"] = "Please log in using your new account.";
            header("Location: ../../frontend/pages/authentication/index.php");
            exit();

        } else {

            $_SESSION["error"] = "Failed to create account.";
            header("Location: ../../frontend/pages/authentication/signUp.php");
            exit();
        }
    }

    /* ==========================================================
       FORGOT PASSWORD
       ========================================================== */
    public function forgotPassword($data)
    {
        $email = trim($data["email"]);
        $newPassword = $data["newpassword"];
        $confirmPassword = $data["confnewpassword"];

        if (
            empty($email) ||
            empty($newPassword) ||
            empty($confirmPassword)
        ) {
            $_SESSION['error'] = "Please fill in all fields.";
            header("Location: ../../frontend/pages/authentication/forgotPassword.php");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Please input a valid email.";
            header("Location: ../../frontend/pages/authentication/forgotPassword.php");
            exit();
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: ../../frontend/pages/authentication/forgotPassword.php");
            exit();
        }

        $userData = $this->model->getUserByEmail($email);

        if (!$userData) {
            $_SESSION['error'] = "Email does not exist.";
            header("Location: ../../frontend/pages/authentication/forgotPassword.php");
            exit();
        }

        $this->model->updatePassword($email, $newPassword);

        // $_SESSION['success'] = "Password Updated!";
        $_SESSION['success_title'] = "Password Changed!";
        $_SESSION['success'] = "Your password has been updated successfully.";
        header("Location: ../../frontend/pages/authentication/index.php");
        exit();
    }
}

$controller = new UserController($conn);
$action = $_REQUEST["action"] ?? "";

switch ($action) {

    case "add":
        $success = $controller->addUser($_POST);
        if ($success) {
            header("Location: ../../frontend/pages/admin/users.php");
        } else {
            header("Location: ../../frontend/pages/admin/users.php?error=validation");
        }
        exit();

    case "update":
        $success = $controller->updateUser($_POST);
        if ($success) {
            header("Location: ../../frontend/pages/admin/users.php");
        } else {
            header("Location: ../../frontend/pages/admin/users.php?error=update");
        }
        exit();

    case "delete":
        $success = $controller->deleteUser($_POST["user_id"]);
        if ($success) {
            header("Location: ../../frontend/pages/admin/users.php?success=deleted");
        } else {
            header("Location: ../../frontend/pages/admin/users.php?error=deletefailed");
        }
        exit();

    case "status":
        $success = $controller->updateStatus(
            $_POST["user_id"],
            $_POST["status"]
        );
        if ($success) {
            header("Location: ../../frontend/pages/admin/users.php?success=statusupdated");
        } else {
            header("Location: ../../frontend/pages/admin/users.php?error=statusfailed");
        }
        exit();
        
    case "viewAccount":

        $user = $controller->getUser($_SESSION['user_id']);

        require "../../frontend/pages/user/accountSettings.php";
        exit();

    case "editAccount":

        $user = $controller->getUser($_SESSION['user_id']);

        require "../../frontend/pages/user/editAccountDetails.php";
        exit();

    case "updateAccount":

        $success = $controller->updateProfile(
            $_SESSION['user_id'],
            trim($_POST['username']),
            trim($_POST['firstname']),
            trim($_POST['lastname']),
            trim($_POST['mobilenumber'])
        );

        if ($success) {
            $_SESSION['success'] = "Account details updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update account details.";
        }

        header("Location: ../../frontend/pages/user/accountSettings.php");
        exit();

    case "login":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login($_POST);
        } else {
            header("Location: ../../frontend/pages/authentication/index.php");
        }
    exit();

    case "signup":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->signup($_POST);
        } else {
            header("Location: ../../frontend/pages/authentication/signUp.php");
        }
    exit();

    case "forgotPassword":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->forgotPassword($_POST);
        } else {
            header("Location: ../../frontend/pages/authentication/forgotPassword.php");
        }
    exit();

    default:
        http_response_code(400);
        echo "Invalid action.";
        exit();
    }
