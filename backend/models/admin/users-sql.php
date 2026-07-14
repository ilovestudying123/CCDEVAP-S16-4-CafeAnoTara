<?php 
class UserModel
{
    // Get all users to display from the users table
    public function getUsers($conn)
    {
        $stmt = $conn->prepare("
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
}
?>