<?php
    require "../../../backend/models/admin/dashboard-sql.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-dashboard.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                <p class="count">0</p>
                    <div class="redirect">
                    <a href="reviews.php"><img src="../../resources/imgs/arrow-btn-color2.png"></a>
                    </div>
            </div>

            <div class="preview-box">
                <p>Pending Cafe Approvals</p>
                <p class="count">3</p>
                    <div class="redirect">
                    <a href="cafes.php"><img src="../../resources/imgs/arrow-btn-color2.png"></a>
                    </div>
            </div>
        </div>
        
        <div class="chart-container">
            <div class="chart">
                <h3>Monthly Sign Ups</h3>
                <canvas id="barChart1"></canvas>
            </div>

            <div class="chart">
                <h3>Customer Satisfaction by Age Group</h3>
                <canvas id="barChart2"></canvas>
            </div>

            <div class="chart">
                <h3>Cafe Visit Times</h3>
                <canvas id="lineChart"></canvas>
            </div>

            <div class="chart">
                <h3>Most Used Search Filters</h3>
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
    </div>
</body>
</html>