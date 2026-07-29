<?php
require_once '../../../backend/controllers/user/cafeController.php';

$controller = new cafeController($conn);
$name = isset($_GET['name']) ? trim($_GET['name']) : '';
$results = $controller->getSearchResults($name);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/user-search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <div id="header"></div>
    <script src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/js/script-header-user.js"></script>
</head>
<body>
<div class="search-filter-sort">
    <section class="search-section">
        <form method="GET" action="/CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/search.php">
            <div class="search">
                <input type="search" name="name"
                       placeholder="Search..."
                       value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
                <button type="submit">
                    <img id="search-icon" src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/magnifying-glass-solid.png">
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
            <a href="/CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/cafeDetails.php?id=<?php echo $cafe['cafe_id']; ?>"
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