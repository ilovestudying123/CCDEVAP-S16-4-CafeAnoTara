<?php
require_once '../../../backend/controllers/user/cafeController.php';

$controller = new cafeController($conn);
$cafes = $controller->getTopCafes();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/user-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/js/user-dashboard.js"></script>
    <div id="header"></div>
    <script src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/js/script-header-user.js"></script>
</head>
<body>
<div class="body">
    <div class="search-filter-sort">
        <section class="search-section">
            <form method="GET" action="/CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/search.php">
                <div class="search">
                    <input id="search-box" type="search" name="name" placeholder="Search...">
                    <button id="search-button" type="submit">
                        <img id="search-icon" src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/magnifying-glass-solid.png">
                    </button>
                </div>
            </form>
        </section>
    </div>

    <section class="rec-cafes">
        <div class="rec-cafe">
            <div class="rec-cafes-header">
                <h2>Recommended Study Cafes</h2>
            </div>
            <div class="rec-cafes-list">
                <?php foreach ($cafes as $cafe): ?>
                    <a href="/CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/cafeDetails.php?id=<?php echo $cafe['cafe_id']; ?>"
                       class="cafe-card">
                        <img src="<?php echo !empty($cafe['main_image'])
                            ? '/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/' . htmlspecialchars($cafe['main_image'])
                            : '/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/cafe.jpg';
                        ?>" alt="<?php echo htmlspecialchars($cafe['cafe_name']); ?>">
                        <div class="cafe-text">
                            <h3><?php echo htmlspecialchars($cafe['cafe_name']); ?></h3>
                            <p>
                                <i class="fa-solid fa-star"></i>
                                <?php echo $cafe['average_rating']
                                    ? number_format($cafe['average_rating'], 1) . '/5'
                                    : 'No ratings yet'; ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>
</body>
</html>