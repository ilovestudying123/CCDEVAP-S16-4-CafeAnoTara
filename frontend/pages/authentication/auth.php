<?php
// starts session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirects to login if users not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../authentication/");
    exit();
}
?>