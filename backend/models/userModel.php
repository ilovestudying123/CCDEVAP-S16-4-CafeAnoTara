<?php 
class userModel
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

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

    public function getUser($user_id)
    {
        $sql = "SELECT * FROM Users WHERE user_id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);

        return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    }

    public function updateProfile($user_id, $firstname, $lastname, $mobilenumber)
    {
        $sql = "UPDATE Users
                SET firstname = ?,
                    lastname = ?,
                    mobilenumber = ?
                WHERE user_id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $firstname,
            $lastname,
            $mobilenumber,
            $user_id
        );

        return mysqli_stmt_execute($stmt);
    }
}
?>