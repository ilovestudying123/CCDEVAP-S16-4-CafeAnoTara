<?php
    require_once "../../../backend/config/connection.php";
    require "../../../backend/models/admin/users-sql.php";

    $userModel = new UserModel($conn);
    $result = $userModel->getUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-users.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>

    <script src="../../resources/js/admin-users.js"></script>
</head>

<body>
    <div id="header">
        <?php require "../../includes/header-admin.php"; ?>
    </div>

    <div class="body-box">
        <div class="header-section">
            <h1>Manage Users</h1>
            <a href="users-add.php" class="add-btn">Add Record</a>  
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
                <tr>
                <?php while ($row = $result->fetch_assoc()) : ?>
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
                            <a href="users-edit.php?id=<?=$row["user_id"]?>">
                                <img src="../../resources/imgs/edit-btn.png" alt="modify"></a>

                            <!-- TO FIX: Implement user status change functionality -->
                            <!-- <?php// if ($row["account_status"] == "active") : ?>
                                <img
                                    id="action<?= //$row['user_id'] ?>"
                                    src="../../resources/imgs/x-mark.png"
                                    alt="Suspend"
                                    onclick="userStatus(
                                        <?= //$row['user_id'] ?>,
                                        'status<?= //$row['user_id'] ?>',
                                        'action<?= //$row['user_id'] ?>'
                                    )"
                                >
                            <?php //else : ?>
                                <img
                                    id="action<?= //$row['user_id'] ?>"
                                    src="../../resources/imgs/check-mark.png"
                                    alt="Activate"
                                    onclick="userStatus(
                                        <?= $row['user_id'] ?>,
                                        'status<?= //$row['user_id'] ?>',
                                        'action<?= //$row['user_id'] ?>'
                                    )"
                                >
                                <?php //endif; ?> -->
                            <img src="../../resources/imgs/delete.png" alt="delete" onclick="confirm('Are you sure you want to DELETE this user?')">
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