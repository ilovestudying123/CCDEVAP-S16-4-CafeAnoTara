<?php 
class userModel
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // ================= ADMIN FUNCTIONS =================

    // Add a new user to the users table
    public function addUser(
        $firstname,
        $lastname,
        $username,
        $email,
        $mobilenumber,
        $password,
        $role,
        $account_status
    )
    {
        $stmt = $this->conn->prepare("
            INSERT INTO users
            (firstname, lastname, username, email, mobilenumber, password, role, account_status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssssss",
            $firstname,
            $lastname,
            $username,
            $email,
            $mobilenumber,
            $password,
            $role,
            $account_status
        );

        return $stmt->execute();
    }

    // Get all users to display from the users table
    public function getUsers()
    {
        $stmt = $this->conn->prepare("
            SELECT
                user_id,
                CONCAT(firstname, ' ', lastname) AS fullname,
                username,
                email,
                mobilenumber,
                role,
                account_status,
                created_on
            FROM users
        ");

        $stmt->execute();

        return $result = $stmt->get_result();
    }

    //Get a specific user by ID from the users table
    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE user_id = ?
        ");

        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    //update a specific user by ID in the users table
    public function updateUser($id, $firstname, $lastname, $username, $email, $mobilenumber, $role, $account_status)
    {
        $stmt = $this->conn->prepare("
            UPDATE users
            SET firstname = ?, lastname = ?, username = ?, email = ?, mobilenumber = ?, role = ?, account_status = ?
            WHERE user_id = ?
        ");

        $stmt->bind_param("sssssssi", $firstname, $lastname, $username, $email, $mobilenumber, $role, $account_status, $id);

        return $stmt->execute();
    }

    //updates user status by ID in the users table
    public function updateStatus($user_id, $status)
    {
    $stmt = $this->conn->prepare("
        UPDATE users
        SET account_status = ?
        WHERE user_id = ?
    ");

    $stmt->bind_param("si", $status, $user_id);

    return $stmt->execute();
    }

    // delete a specific user by ID in the users table
    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("
            DELETE FROM users
            WHERE user_id = ?
        ");

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // ================= USER FUNCTIONS =================
    
    // Get a specific user by ID
    public function getUser($user_id)
    {
        $sql = "SELECT * FROM Users WHERE user_id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);

        return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    }

    // Update user profile (user)
    public function updateProfile($user_id, $username, $firstname, $lastname, $mobilenumber)
    {
        $sql = "UPDATE users
                SET username = ?,
                    firstname = ?,
                    lastname = ?,
                    mobilenumber = ?
                WHERE user_id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

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

    public function getUserByEmail($email)
    {
        $query = "SELECT
                    user_id,
                    username,
                    firstname,
                    lastname,
                    email,
                    password,
                    role
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

    public function getUserByUsername($username)
    {
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

    public function createUser(
        $username,
        $email,
        $firstName,
        $lastName,
        $password,
        $userType
    )
    {
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

    public function updatePassword($email, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE users
                SET password = ?
                WHERE email = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "ss",
                $hashedPassword,
                $email
            );

            $success = mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

            return $success;
        }

        return false;
    }
}
?>