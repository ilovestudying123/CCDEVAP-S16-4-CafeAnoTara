<?php
// get firstname from session to display in header
$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';
?>

<div class="header">
    <h1 class="title">Cafe Tayo </h1>
    <h1 class="name"><?php echo $firstname; ?></h1>
    <h1 class="title">, Ano Tara?</h1>

    <nav class="nav-user">
        <a href="../../../backend/controllers/CafeController.php?action=dashboard">Home</a> |
        <a href="../../../backend/controllers/BookmarkController.php?action=bookmarks">Bookmarks</a> |
        <a href="postedReviews.php">My Reviews</a> |
        <a href="accountSettings.php">Account Settings</a>
    </nav>
</div>
