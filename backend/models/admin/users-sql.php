<?php 
class UserModel
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
    public function updateUserStatus($id, $status)
    {
        
        $stmt = $this->conn->prepare("
            UPDATE users
            SET account_status = ?
            WHERE user_id = ?
        ");

        $stmt->bind_param("si", $status, $id);

        return $stmt->execute();
    }

    // delete a specific user by ID in the users table
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("
            UPDATE users
            SET firstname = 'Deleted', lastname = 'User', 
                username = 'deleted_user', email = 'deleted@example.com', 
                mobilenumber = '0000000000', account_status = 'deleted'
            WHERE user_id = ?
        ");

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>