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
        <a href="dashboard.php" class="home">Home |</a> 
        <a href="bookmarks.php" class="bookmark">Bookmarks |</a>
        <a href="postedreviews.php" class="reviews">My Reviews |</a>
        <a href="accountSettings.php" class="accSetting">Account Settings</a>
    </nav>
</div>
