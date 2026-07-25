
// class accountController {

//     private $model;
//     private $conn;

//     public function __construct($conn){
//         $this->conn = $conn;
//         $this->model = new accountModel($conn);
//     }

//     public function viewAccount(){

//         session_start();

//         $user = $this->model->getUser($_SESSION['user_id']);

//         include "../../../frontend/pages/user/accountSettings.php";
//     }

//     public function editAccount(){

//         session_start();

//         $user = $this->model->getUser($_SESSION['user_id']);

//         include "../../../frontend/pages/user/editAccountDetails.php";
//     }

//     public function updateAccount()
//     {
//         session_start();

//         $firstname = trim($_POST['firstname']);
//         $lastname = trim($_POST['lastname']);
//         $mobilenumber = trim($_POST['mobilenumber']);

//         $this->model->updateUser(
//             $_SESSION['user_id'],
//             $firstname,
//             $lastname,
//             $mobilenumber
//         );

//         header("Location: accountController.php?action=view");
//         exit();
//     }

// }

// ?>

<?php
//TO BE FIXED
session_start();

require_once '../../config/connection.php';
require_once '../../models/user/accountModel.php';



if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../frontend/pages/authentication/index.php");
    exit();
}


$accountModel = new AccountModel($conn);

$userId = $_SESSION['user_id'];

$action = $_GET['action'] ?? 'view';



if ($action === 'view') {

    $user = $accountModel->getUser($userId);

    if (!$user) {
        $_SESSION['error'] = "User account not found.";
        header("Location: ../../../frontend/pages/authentication/index.php");
        exit();
    }

    require_once '../../../frontend/pages/user/accountSettings.php';
    exit();
}


if ($action === 'edit') {

    $user = $accountModel->getUser($userId);

    if (!$user) {
        $_SESSION['error'] = "User account not found.";
        header("Location: ../../../frontend/pages/authentication/index.php");
        exit();
    }

    require_once '../../../frontend/pages/user/editAccountDetails.php';
    exit();
}


if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $mobilenumber = trim($_POST['mobilenumber'] ?? '');


    // Check required fields
    if (empty($firstname) || empty($lastname) || empty($mobilenumber)) {

        $_SESSION['error'] = "Please fill in all fields.";

        header("Location: accountController.php?action=edit");
        exit();
    }


    // Update user
    $updated = $accountModel->updateUser(
        $userId,
        $firstname,
        $lastname,
        $mobilenumber
    );


    if ($updated) {

        $_SESSION['success'] = "Account updated successfully.";

        header("Location: accountController.php?action=view");
        exit();

    } else {

        $_SESSION['error'] = "Failed to update account.";

        header("Location: accountController.php?action=edit");
        exit();
    }
}

header("Location: accountController.php?action=view");
exit();

?>
