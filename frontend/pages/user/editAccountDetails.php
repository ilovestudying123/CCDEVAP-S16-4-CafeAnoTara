<?php
    require "../../../backend/config/connection.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account Details</title>
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/editAccountDetails.css">

    <div id="header"></div>
    <script src="../../resources/js/script-header-user.js"></script>
</head>

<body>

    <div class="editDetails">

        <h1 class="editTitle">Edit Account Details</h1>

        <form class="form">
            <div class="form-row">
                <div class="form-group button-group">
                    <button type="button" onclick="saveChanges()">Save Changes</button>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="username" value="j_delacruz123" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="email" value="juan.delacruz@gmail.com" disabled>
                </div>

                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" id="contactNumber" value="09123456789" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" id="firstName" value="Juan" disabled>
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" id="lastName" value="Dela Cruz" disabled>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" value="juan2345!" disabled>
            </div>

        </form>

    </div>

</body>
</html>
