<?php
session_start();
require '../../../backend/config/connection.php';
require_once '../authentication/auth.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>

    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/accountSettings.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<?php if (isset($_SESSION['success'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: "success",
        title: "Success!",
        text: <?= json_encode($_SESSION['success']) ?>,
        confirmButtonColor: "#725420",
        confirmButtonText: "OK"
    });
});
</script>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: "error",
        title: "Error!",
        text: <?= json_encode($_SESSION['error']) ?>,
        confirmButtonColor: "#725420",
        confirmButtonText: "OK"
    });
});
</script>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php require "../../includes/header-user.php"; ?>

    <div class="account-settings">

        <h1 class="accSet">Account Settings</h1>

        <form class="form">

            <div class="form-row">
                <div class="form-group button-group">
                    <button type="button" onclick="goToEditPage()">
                        Edit
                    </button>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Username</label>
                    <input value="<?= htmlspecialchars($user['username']) ?>" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input value="<?= htmlspecialchars($user['email']) ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Contact Number</label>
                    <input value="<?= htmlspecialchars($user['mobilenumber']) ?>" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input value="<?= htmlspecialchars($user['firstname']) ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input value="<?= htmlspecialchars($user['lastname']) ?>" disabled>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" value="juan2345!" disabled>
            </div>

        </form>

    </div>

    <script>
        function goToEditPage() {
            window.location.href = "editAccountDetails.php";
        }
    </script>
</body>
</html>
