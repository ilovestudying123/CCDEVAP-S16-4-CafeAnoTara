<?php
    require_once "../../../backend/config/connection.php";
    require "../../../backend/models/admin/users-sql.php";

    $userModel = new UserModel($conn);

    //GET user id from URL
    $id = $_GET['id'];
    $user = $userModel->getUserById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-users-add.css">
</head>

<body>
    <div class="body-box">
        <div class="header-section">
            <h1>Edit Record</h1>
        </div>

        <form action="../../../backend/controllers/admin/user-update.php" method="POST">

        <!-- Hidden user ID -->
        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

            <a href="users.php" class="back-link">Go Back</a>

            <div class="row">
                <div class="field">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName"
                     value="<?= htmlspecialchars($user['firstname']) ?>"
                     pattern="[A-Za-z -']{2,50}"
                     title="First name must be 2-50 characters and contain only letters, spaces, apostrophes, or hyphens." required>
                </div>

                <div class="field">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName"
                        value="<?= htmlspecialchars($user['lastname']) ?>"
                        pattern="[A-Za-z -']{2,50}" required 
                        title="Last name must be 2-50 characters and contain only letters, spaces, apostrophes, or hyphens." required>
                </div>
            </div>

            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                 value="<?= htmlspecialchars($user['username']) ?>"
                 pattern="[A-Za-z0-9_]{4,20}"
                 title="Username must be 4-20 characters and contain only letters, numbers, or underscores." required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                 value="<?= htmlspecialchars($user['email']) ?>">
            </div>

            <div class="field">
                <label for="telno">Phone Number</label>
                <input type="tel" id="telno" name="telno"
                 value="<?= $user['mobilenumber'] ?>"
                 pattern="^09\d{9}$"
                 title="Please enter a valid Philippine mobile number (e.g., 09123456789)." required>
            </div>

            <div class="row">
                <div class="field">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
                        <option value="owner" <?= $user['role'] === 'owner' ? 'selected' : '' ?>>Owner</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <div class="field">
                    <label for="accStatus">Account Status</label>
                    <select id="accStatus" name="accStatus" required>
                        <option value="active" <?= $user['account_status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="suspended" <?= $user['account_status'] === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                        <option value="deleted" <?= $user['account_status'] === 'deleted' ? 'selected' : '' ?>>Deleted</option>
                    </select>
                </div>
            </div>

            <input type="submit" value="Update Record">
        </form>
    </div>
</body>
</html>