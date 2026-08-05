<?php
require '../../../backend/config/connection.php';
require_once '../authentication/auth.php';
require_once '../../../backend/controllers/cafeController.php';

$controller = new cafeController($conn);
$cafes = $controller->getTopCafes();
$customer_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/user-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="../../resources/js/user-dashboard.js"></script>
    
</head>
<body>

<!-- header -->
    <?php require "../../includes/header-user.php"; ?>
<div class="body">
    <div class="search-filter-sort">
        <section class="search-section">
            <form method="GET" action="search.php">
                <div class="search">
                    <input id="search-box" type="search" name="name" placeholder="Search...">
                    <button id="search-button" type="submit">
                        <img id="search-icon" src="../../resources/imgs/magnifying-glass-solid.png">
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
                    <a href="cafeDetails.php?id=<?php echo $cafe['cafe_id']; ?>"
                       class="cafe-card">
                        <img src="<?php echo !empty($cafe['main_image'])
                            ? htmlspecialchars($cafe['main_image'])
                            : '../../resources/imgs/cafe.jpg'; ?>"
                             alt="<?php echo htmlspecialchars($cafe['cafe_name']); ?>">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION['success'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: "success",
        title: "Success!",
        text: <?= json_encode($_SESSION['success']) ?>,
        confirmButtonColor: "#725420"
    });
});
</script>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>
</body>
</html>