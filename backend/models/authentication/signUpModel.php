<?php

class SignUpModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUserByUsername($username) {

        $query = "SELECT user_id
                  FROM users
                  WHERE username = ?
                  LIMIT 1";

        $stmt = mysqli_prepare($this->conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            return $user;
        }

        return null;
    }

    public function getUserByEmail($email) {

        $query = "SELECT user_id
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

    public function createUser($username, $email, $firstName, $lastName, $password, $userType) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO Users
                  (username, email, firstname, lastname, password, role)
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $query);

        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "ssssss",
                $username,
                $email,
                $firstName,
                $lastName,
                $hashedPassword,
                $userType
            );

            $success = mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

            return $success;
        }

        return false;
    }

}

?>