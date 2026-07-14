<?php
    require "../../../backend/config/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-dashboard.css">
    <script src="../../resources/js/script-header-admin.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css"/>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
</head>

<body>
    <div id="header"></div>

    <div class="body-box">
        <div class="preview-box">
            <p>Pending Reports</p>
            <p class="count">0</p>
                <div class="redirect">
                <a href="reviews.html"><img src="../../resources/imgs/arrow-btn-color2.png"></a>
                </div>
        </div>

        <div class="preview-box">
            <p>Pending Cafe Approvals</p>
            <p class="count">3</p>
                <div class="redirect">
                <a href="cafes.html"><img src="../../resources/imgs/arrow-btn-color2.png"></a>
                </div>
        </div>

    </div>
</body>
</html>