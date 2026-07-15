<?php
require_once __DIR__ . "/../../config/connection.php";
require_once __DIR__ . "/../../models/admin/dashboard-sql.php";

$dashboardModel = new UserDashboard($conn);

// Dashboard cards
$pendingReports = $dashboardModel->getPendingReports();
$pendingCafes = $dashboardModel->getPendingCafes();

// Monthly Users
$userResult = $dashboardModel->getUsersPerMonth();

$userMonths = [];
$userTotals = [];

while ($row = $userResult->fetch_assoc()) {
    $userMonths[] = $row['month'];
    $userTotals[] = $row['total'];
}

// Users Per Role
$roleResult = $dashboardModel->getUserPerRole();

$roles = [];
$roleTotals = [];

while ($row = $roleResult->fetch_assoc()) {
    $roles[] = ucfirst($row['role']);
    $roleTotals[] = $row['total'];
}

// Highest Rated Cafes
$ratingResult = $dashboardModel->getHighestRatedCafes();

$cafeNames = [];
$ratings = [];

while ($row = $ratingResult->fetch_assoc()) {
    $cafeNames[] = $row['cafe_name'];
    $ratings[] = $row['average_rating'];
}

// Most Bookmarked Cafes
$bookmarkResult = $dashboardModel->getMostBookmarkedCafes();

$bookmarkCafe = [];
$bookmarkCount = [];

while ($row = $bookmarkResult->fetch_assoc()) {
    $bookmarkCafe[] = $row['cafe_name'];
    $bookmarkCount[] = $row['bookmarks'];
}
?>