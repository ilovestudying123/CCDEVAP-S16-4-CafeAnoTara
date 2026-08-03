<?php
// Include the database connection file
require_once __DIR__ . "/../../config/connection.php";

// Include the dashboard model that contains all SQL queries
require_once __DIR__ . "/../../models/user/dashboardModel.php";

// Create an object of the UserDashboard class
$dashboardModel = new dashboardModel($conn);


/* ============================================================
   DASHBOARD CARDS
   ============================================================ */

// Get the number of reports whose status is "ongoing"
$pendingReports = $dashboardModel->getPendingReports();

// Get the number of cafes waiting for approval
$pendingCafes = $dashboardModel->getPendingCafes();


/* ============================================================
   LINE CHART - MONTHLY USER SIGN UPS
   ============================================================ */

    // Retrieve all users grouped by month and role
    $userResult = $dashboardModel->getUsersPerMonth();

    // Stores the names of the months
    $userMonths = [];
    $monthKeys  = [];

    // Stores the number of users for each role
    $usersByRole = [];

    // Temporarily stores every row returned by MySQL
    $rawRows = [];

    while ($row = $userResult->fetch_assoc()) {
        $rawRows[] = $row;

        if (!in_array($row['month_key'], $monthKeys)) {
            $monthKeys[] = $row['month_key'];
            $userMonths[] = $row['month'] . ' ' . $row['year'];
        }

        if (!isset($usersByRole[$row['role']])) {
            $usersByRole[$row['role']] = [];
        }
    }

    foreach ($usersByRole as $role => &$totals) {
        foreach ($monthKeys as $key) {
            $match = array_filter(
                $rawRows,
                fn($r) => $r['month_key'] === $key && $r['role'] === $role
            );
            $totals[] = $match ? array_values($match)[0]['total'] : 0;
        }
    }
    unset($totals);
    

/* ============================================================
   PIE CHART - USERS PER ROLE
   ============================================================ */

// Get the total number of users for each role
$roleResult = $dashboardModel->getUserPerRole();

// Stores role names
$roles = [];

// Stores total users for each role
$roleTotals = [];

// Read every row from the SQL query
while ($row = $roleResult->fetch_assoc()) {

    // Save the role name
    $roles[] = ucfirst($row['role']);

    // Save the number of users
    $roleTotals[] = $row['total'];
}

/* ============================================================
   BAR CHART - MOST BOOKMARKED CAFES
   ============================================================ */

// Get the cafes with the most bookmarks
$bookmarkResult = $dashboardModel->getMostBookmarkedCafes();

// Stores cafe names
$bookmarkCafe = [];

// Stores bookmark counts
$bookmarkCount = [];

// Read every row from the SQL query
while ($row = $bookmarkResult->fetch_assoc()) {

    // Save the cafe name
    $bookmarkCafe[] = $row['cafe_name'];

    // Save its bookmark count
    $bookmarkCount[] = $row['bookmarks'];
}


/* ============================================================
   CAFE RANKINGS TABLE
   ============================================================ */

// Get the ranked cafes
$rankedCafes = $dashboardModel->getRankedCafes();

// These arrays can be used if you later want to display the rankings in a chart.
$cafeNames = [];
$ratings = [];

foreach ($rankedCafes as $cafe) {

    $cafeNames[] = $cafe['cafe_name'];

    $ratings[] = $cafe['weighted_rating'];
}
?>