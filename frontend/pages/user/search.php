<?php
require '../../../backend/config/connection.php';
require_once '../authentication/auth.php';
require_once '../../../backend/controllers/cafeController.php';

$controller = new cafeController($conn);
$customer_id = $_SESSION['user_id'];
$name = isset($_GET['name']) ? trim($_GET['name']) : '';
$results = $controller->getSearchResults($name);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/user-search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    <!-- header -->
    <?php require "../../includes/header-user.php"; ?>
<div class="search-filter-sort">
    <section class="search-section">
        <form method="GET" action="search.php">
            <div class="search">
                <input type="search" name="name"
                       placeholder="Search..."
                       value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
                <button type="submit">
                    <img id="search-icon" src="../../resources/imgs/magnifying-glass-solid.png">
                </button>
            </div>
        </form>
    </section>
</div>

<section class="cafe-listings">
    <h2>Cafe Listings</h2>

    <?php if (empty($results) && $name !== ''): ?>
        <p>No cafes found matching "<?php echo htmlspecialchars($name); ?>".</p>

    <?php elseif (!empty($results)): ?>
        <?php foreach ($results as $cafe): ?>
            <a href="cafeDetails.php?id=<?php echo $cafe['cafe_id']; ?>"
               class="listing-box">
                <div class="list-text">
                    <span class="cafe-listing-name"><?php echo htmlspecialchars($cafe['cafe_name']); ?></span>
                    <span class="cafe-listing-rating">
                        <i class="fa-solid fa-star"></i>
                        <?php echo $cafe['average_rating']
                            ? number_format($cafe['average_rating'], 1) . '/5'
                            : 'No ratings'; ?>
                    </span>
                </div>
                <span class="cafe-address"><?php echo htmlspecialchars($cafe['location']); ?></span>
            </a>
        <?php endforeach; ?>

    <?php else: ?>
        <p>Enter a cafe name to search.</p>
    <?php endif; ?>
</section>
</body>
</html>