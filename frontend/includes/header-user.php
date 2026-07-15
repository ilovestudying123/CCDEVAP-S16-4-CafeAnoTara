<?php
// get firstname from session to display in header
// $firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';
$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';
?>

<div class="header">
    <h1 class="title">Cafe Tayo </h1>
    <h1 class="name"><?php echo $firstname; ?></h1>
    <h1 class="title">, Ano Tara?</h1>

    <nav class="nav-user">
        <a href="../../../backend/controllers/user/cafeController.php?action=dashboard" class="home">Home</a> |
        <a href="../../../backend/controllers/user/bookmarkController.php?action=bookmarks" class="bookmark">Bookmarks</a> |
        <a href="../../../backend/controllers/user/reviewController.php?action=myReviews" class="review">My Reviews</a> |
        <a href="accountSettings.php">Account Settings</a>
    </nav>
</div>
