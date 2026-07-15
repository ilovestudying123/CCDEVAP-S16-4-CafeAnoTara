<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account Details</title>

    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/editAccountDetails.css">

    <script src="../../resources/js/script-header-user.js"></script>
</head>

<body>

<div id="header"></div>

<div class="editDetails">

    <h1 class="editTitle">Edit Account Details</h1>

    <form
        class="form"
        method="POST"
        action="../../../backend/controllers/user/accountController.php?action=update">

        <div class="form-row">
            <div class="form-group button-group">
                <button type="submit">Save Changes</button>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Username</label>
                <input
                    type="text"
                    value="<?= htmlspecialchars($user['username']) ?>"
                    disabled>
            </div>
        </div>

        <div class="form-row">

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    value="<?= htmlspecialchars($user['email']) ?>"
                    disabled>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input
                    type="text"
                    id="contactNumber"
                    name="mobilenumber"
                    value="<?= htmlspecialchars($user['mobilenumber']) ?>">
            </div>

        </div>

        <div class="form-row">

            <div class="form-group">
                <label>First Name</label>
                <input
                    type="text"
                    id="firstName"
                    name="firstname"
                    value="<?= htmlspecialchars($user['firstname']) ?>">
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input
                    type="text"
                    id="lastName"
                    name="lastname"
                    value="<?= htmlspecialchars($user['lastname']) ?>">
            </div>

        </div>

    </form>

</div>

</body>
</html>