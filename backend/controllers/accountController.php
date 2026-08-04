
<?php

session_start();

require_once '../config/connection.php';
require_once '../models/accountModel.php';


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../frontend/pages/authentication/index.php");
    exit();
}


// Create model
$accountModel = new accountModel($conn);


// Get current logged-in user's ID
$user_id = $_SESSION['user_id'];


// Get action
$action = $_GET['action'] ?? 'view';


// =====================================================
// VIEW ACCOUNT SETTINGS
// =====================================================

if ($action === 'view') {

    $user = $accountModel->getUser($user_id);

    if (!$user) {
        $_SESSION['error'] = "User account not found.";
        header("Location: ../../../frontend/pages/authentication/index.php");
        exit();
    }

    require_once '../../../frontend/pages/user/accountSettings.php';
    exit();
}

// =====================================================
// EDIT ACCOUNT SETTINGS
// =====================================================

if ($action === 'edit') {

    $user = $accountModel->getUser($user_id);

    if (!$user) {
        $_SESSION['error'] = "User account not found.";
        header("Location: ../../../frontend/pages/authentication/index.php");
        exit();
    }

    require_once '../../../frontend/pages/user/editAccountDetails.php';
    exit();
}


// =====================================================
// UPDATE ACCOUNT
// =====================================================

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $mobilenumber = trim($_POST['mobilenumber'] ?? '');


    // Check if all fields are filled
    if (empty($firstname) || empty($lastname) || empty($mobilenumber)) {

        $_SESSION['error'] = "Please fill in all fields.";

        header("Location: accountController.php?action=edit");
        exit();
    }


    // Update user's information
    $accountModel->updateUser(
        $user_id,
        $firstname,
        $lastname,
        $mobilenumber
    );


    $_SESSION['success'] = "Account updated successfully.";

    header("Location: accountController.php?action=view");
    exit();
}


// =====================================================
// INVALID ACTION
// =====================================================

header("Location: accountController.php?action=view");
exit();
?>
