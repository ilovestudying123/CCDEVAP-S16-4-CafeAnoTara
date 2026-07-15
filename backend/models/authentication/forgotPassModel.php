<?php

class forgotPassModel{

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getUserByEmail($email) {

        $query = "SELECT user_id, username, password, role
                  FROM users
                  WHERE email = ?
                  LIMIT 1";

        $stmt = mysqli_prepare($this->conn, $query);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            return $user;
        }

        return null;
    }

    public function updatePassword($email, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE users
                SET password = ?
                WHERE email = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);

            $success = mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

            return $success;
        }

        return false;
    }


}



?>