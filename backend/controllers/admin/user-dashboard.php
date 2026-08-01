<?php
// Include the database connection file
require_once __DIR__ . "/../../config/connection.php";

// Include the dashboard model that contains all SQL queries
require_once __DIR__ . "/../../models/admin/dashboard-sql.php";

// Create an object of the UserDashboard class
$dashboardModel = new UserDashboard($conn);


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

// Stores the number of users for each role
$usersByRole = [];

// Temporarily stores every row returned by MySQL
$rawRows = [];

// Read every row from the SQL query
while ($row = $userResult->fetch_assoc()) {

    // Save the row for later use
    $rawRows[] = $row;

    // If this month hasn't been added yet, add it
    if (!in_array($row['month'], $userMonths)) {
        $userMonths[] = $row['month'];
    }

    // If this role doesn't exist yet, create an empty array for it
    if (!isset($usersByRole[$row['role']])) {
        $usersByRole[$row['role']] = [];
    }
}


// Fill in the data for every role.
foreach ($usersByRole as $role => &$totals) {

    foreach ($userMonths as $month) {

        // Look for a row that matches BOTH the current month and the current role
        $match = array_filter(
            $rawRows,
            fn($r) => $r['month'] === $month && $r['role'] === $role
        );

        // If found, use its total. Otherwise store 0.
        $totals[] = $match
            ? array_values($match)[0]['total']
            : 0;
    }
}

// Remove the reference variable after the foreach
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