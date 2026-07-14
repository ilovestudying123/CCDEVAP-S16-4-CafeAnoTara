<?php
class loginModel{
    
    public function getUserByEmail($email){
        require '../../config/connection.php';

         $query = "SELECT user_id, username, password, role FROM users WHERE email = ? LIMIT 1";

         $stmt = mysqli_prepare($conn, $query);

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

}

?>