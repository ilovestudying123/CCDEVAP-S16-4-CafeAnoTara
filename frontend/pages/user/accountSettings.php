<?php
    require "../../../backend/config/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>

    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/accountSettings.css">
</head>

<body>
<!-- header -->
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
            window.location.href="../../../backend/controllers/user/accountController.php?action=edit";
        }

    </script>

</body>
</html>
