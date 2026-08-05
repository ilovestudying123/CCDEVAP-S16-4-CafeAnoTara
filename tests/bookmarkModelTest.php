<?php
require_once "../backend/config/connection.php";
require_once "../backend/models/bookmarkModel.php";

$model = new bookmarkModel();

$customer_id = 1;
$cafe_id = 2;

echo "<h2>Bookmark Model Tests</h2>";

// Test 1 - Add Bookmark
$result = $model->addBookmark($conn, $customer_id, $cafe_id);

echo "<p>Add Bookmark: ";
echo $result ? "PASS" : "FAIL";
echo "</p>";

// Test 2 - Check Bookmark
$result = $model->isBookmarked($conn, $customer_id, $cafe_id);

echo "<p>Is Bookmarked: ";
echo $result ? "PASS" : "FAIL";
echo "</p>";

// Test 3 - Get Bookmarks
$result = $model->getUserBookmarks($conn, $customer_id);

echo "<p>Get Bookmarks: ";
echo (!empty($result)) ? "PASS" : "FAIL";
echo "</p>";

// Test 4 - Remove Bookmark
$result = $model->removeBookmark($conn, $customer_id, $cafe_id);

echo "<p>Remove Bookmark: ";
echo $result ? "PASS" : "FAIL";
echo "</p>";

// Test 5 - Verify Removed
$result = $model->isBookmarked($conn, $customer_id, $cafe_id);

echo "<p>Verify Removed: ";
echo (!$result) ? "PASS" : "FAIL";
echo "</p>";