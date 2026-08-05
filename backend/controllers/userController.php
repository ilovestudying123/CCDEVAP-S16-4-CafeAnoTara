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

    default:
        http_response_code(400);
        echo "Invalid action.";
        exit();
}