<?php
    require_once "../../../backend/config/connection.php";
    require "../../../backend/models/userModel.php";
    require_once "../authentication/auth.php";

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../frontend/pages/authentication/index.php");
    exit();
    }

    $userModel = new UserModel($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add User</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../resources/css/admin-users-add.css">
</head>

<body>
    <div class="body-box">
        <div class="header-section">
            <h1>Add User</h1>
        </div>

        <form action="../../../backend/controllers/userController.php?action=add" method="POST">
            <a href="users.php" class="back-link">Go Back</a>

            <div class="row">
                <div class="field">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                </div>

                <div class="field">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                </div>
            </div>

            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username123"required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="abc123@gmail.com" required>
            </div>

            <div class="field">
                <label for="telno">Phone Number</label>
                <input type="tel" id="telno" name="telno" placeholder="09123456789">
            </div>

            <div class="row">
                <div class="field">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="customer">Customer</option>
                        <option value="owner">Owner</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="field">
                    <label for="accStatus">Account Status</label>
                    <select id="accStatus" name="accStatus" required>
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                        <option value="deleted">Deleted</option>
                    </select>
                </div>
            </div>

            <input type="submit" value="Add User">
        </form>
    </div>
</body>
</html>