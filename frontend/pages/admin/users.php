<?php
    require_once "../../../backend/config/connection.php";
    require "../../../backend/models/user/userModel.php";
    require_once "../authentication/auth.php";

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../frontend/pages/authentication/index.php");
    exit();
    }

    $userModel = new UserModel($conn);
    $result = $userModel->getUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-users.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../../resources/js/admin-users.js"></script>
</head>

<body>
    <!-- header -->
    <?php require "../../includes/header-admin.php"; ?>

    <div class="body-box">
        <div class="header-section">
            <h1>Manage Users</h1>
            <a href="users-add.php" class="add-btn">Add User</a>  
        </div>
        
        <div class="table-wrapper">
        <table id="usersTable" class="display">
            <thead>
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Role</th>
                <th>Status</th>
                <th>Account Creation</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row["user_id"]) ?></td>
                    <td><?= htmlspecialchars($row["fullname"]) ?></td>
                    <td><?= htmlspecialchars($row["username"]) ?></td>
                    <td><?= htmlspecialchars($row["email"]) ?></td>
                    <td><?= $row["mobilenumber"] ?></td>
                    <td><?= $row["role"] ?></td>
                    <td id="status<?= $row['user_id'] ?>"><?= $row["account_status"] ?></td>
                    <td><?= $row["created_on"] ?></td>
                    <td>
                        <div class="action-btn">

                        <?php if ($row['account_status'] == 'deleted'): ?>
                            <!-- No actions avilable for deleted users -->
                            <span>No actions available</span>
                        <?php else: ?>

                            <!-- Edit -->
                            <a href="users-edit.php?id=<?= $row['user_id'] ?>">
                                <img src="../../resources/imgs/edit-btn.png" alt="Modify">
                            </a>

                            <!-- Suspend / Activate -->
                            <form class="status-form" action="../../../backend/controllers/user/userController.php?action=status" method="POST">
                                <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">

                                <?php if ($row['account_status'] == 'active'): ?>
                                    <input type="hidden" name="status" value="suspended">
                                    <button type="submit" class="hidden-btn">
                                        <img src="../../resources/imgs/x-mark.png" alt="Suspend">
                                    </button>
                                <?php elseif ($row['account_status'] == 'suspended'): ?>
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="hidden-btn">
                                        <img src="../../resources/imgs/check-mark.png" alt="Activate">
                                    </button>
                                <?php endif; ?>
                            </form>

                            <!-- Delete -->
                            <form class="delete-form" action="../../../backend/controllers/user/userController.php?action=delete" method="POST">
                                <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">

                                <button class="hidden-btn" type="submit">
                                    <img src="../../resources/imgs/delete.png" alt="Delete">
                                </button>
                            </form>

                        <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </div>
</body>
</html>