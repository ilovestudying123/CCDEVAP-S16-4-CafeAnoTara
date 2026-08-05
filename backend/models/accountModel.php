<?php
class accountModel{

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getUser($user_id){

        $sql = "SELECT * FROM Users WHERE user_id=?";

        $stmt = mysqli_prepare($this->conn,$sql);

        mysqli_stmt_bind_param($stmt,"i",$user_id);

        mysqli_stmt_execute($stmt);

        return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    }

    public function updateUser(
        $user_id,
        $username,
        $firstname,
        $lastname,
        $mobilenumber
    )
    {
        $query = "UPDATE Users
                SET username = ?,
                    firstname = ?,
                    lastname = ?,
                    mobilenumber = ?
                WHERE user_id = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssi",
            $username,
            $firstname,
            $lastname,
            $mobilenumber,
            $user_id
        );

        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $success;
    }

}

?>