<?php
class accountController {

    private $model;
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
        $this->model = new accountModel($conn);
    }

    public function viewAccount(){

        session_start();

        $user = $this->model->getUser($_SESSION['user_id']);

        include "../../../frontend/pages/user/accountSettings.php";
    }

    public function editAccount(){

        session_start();

        $user = $this->model->getUser($_SESSION['user_id']);

        include "../../../frontend/pages/user/editAccountDetails.php";
    }

    public function updateAccount()
    {
        session_start();

        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $mobilenumber = trim($_POST['mobilenumber']);

        $this->model->updateUser(
            $_SESSION['user_id'],
            $firstname,
            $lastname,
            $mobilenumber
        );

        header("Location: accountController.php?action=view");
        exit();
    }

}

?>