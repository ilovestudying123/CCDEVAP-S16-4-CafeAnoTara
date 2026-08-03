<?php
require "../../../backend/controllers/user/dashboardController.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-dashboard.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>

    <script>
    const userMonths = <?= json_encode($userMonths) ?>;
    const usersByRole = <?= json_encode($usersByRole) ?>;

    const roles = <?= json_encode($roles) ?>;
    const roleTotals = <?= json_encode($roleTotals) ?>;

    const bookmarkCafe = <?= json_encode($bookmarkCafe) ?>;
    const bookmarkCount = <?= json_encode($bookmarkCount) ?>;
    </script>

    <script src="../../resources/js/admin-dashboard.js"></script>
</head>

<body>
    <!-- header -->
    <?php require "../../includes/header-admin.php"; ?>

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
            <h3>Cafe Rankings</h3>
            <table id="rankedCafesTable">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Cafe</th>
                        <th>Avg Rating</th>
                        <th>Reviews</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rankedCafes as $i => $cafe) : ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($cafe["cafe_name"]) ?></td>
                        <td><?= htmlspecialchars($cafe["average_rating"]) ?></td>
                        <td><?= htmlspecialchars($cafe["review_count"]) ?></td>
                        <td><?= htmlspecialchars($cafe["weighted_rating"]) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

            <div class="chart">
                <h3>Most Bookmarked Cafes</h3>
                <canvas id="barGraph2"></canvas>
            </div>
        </div>
    </div>
</body>
</html>