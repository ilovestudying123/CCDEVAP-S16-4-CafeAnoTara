<?php
require "../../../backend/controllers/admin/user-dashboard.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-dashboard.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const userMonths = <?= json_encode($userMonths) ?>;
    const userTotals = <?= json_encode($userTotals) ?>;

    const roles = <?= json_encode($roles) ?>;
    const roleTotals = <?= json_encode($roleTotals) ?>;

    const cafeNames = <?= json_encode($cafeNames) ?>;
    const ratings = <?= json_encode($ratings) ?>;

    const bookmarkCafe = <?= json_encode($bookmarkCafe) ?>;
    const bookmarkCount = <?= json_encode($bookmarkCount) ?>;
    </script>

    <script src="../../resources/js/admin-dashboard.js"></script>
</head>

<body>
    <div id="header">
        <?php require "../../includes/header-admin.php"; ?>
    </div>

    <div class="body-box">
        <div class="card-holder">
            <div class="preview-box">
                <p>Pending Reports</p>
                <p class="count"><?= $pendingReports ?></p>
                    <div class="redirect">
                    <a href="reviews.php"><img src="../../resources/imgs/arrow-btn-color2.png"></a>
                    </div>
            </div>

            <div class="preview-box">
                <p>Pending Cafe Approvals</p>
                <p class="count"><?= $pendingCafes ?></p>
                    <div class="redirect">
                    <a href="cafes.php"><img src="../../resources/imgs/arrow-btn-color2.png"></a>
                    </div>
            </div>
        </div>
        
        <div class="chart-container">
            <div class="chart">
                <h3>Monthly Sign Ups</h3>
                <canvas id="lineChart"></canvas>
            </div>

            <div class="chart">
                <h3>Users Per Role</h3>
                <canvas id="pieChart"></canvas>
            </div>

            <div class="chart">
                <h3>Highest Rated Cafes</h3>
                <canvas id="barGraph1"></canvas>
            </div>

            <div class="chart">
                <h3>Most Bookmarked Cafes</h3>
                <canvas id="barGraph2"></canvas>
            </div>
        </div>
    </div>
</body>
</html>