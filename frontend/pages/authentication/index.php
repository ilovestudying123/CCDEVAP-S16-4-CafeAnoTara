<?php
session_start();
require '../../../backend/config/connection.php';
require '../../../backend/models/cafeModel.php';

$cafeModel = new cafeModel();
$trendingCafes = $cafeModel->getTopCafes($conn, 3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../../resources/css/login.css">
    <script src="../../resources/js/login.js" defer></script>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<?php
if(isset($_SESSION['error'])){
    echo "<script>alert('" . addslashes($_SESSION['error']) . "');</script>";
    unset($_SESSION['error']);
}
?>

<div class="container">
    <!-- LEFT PANEL -->
    <div class="left-panel">
        <!-- bg image -->
        <img src="../../resources/imgs/login.jpg" alt="Cafe">

        <div class="image-overlay"></div>
        <div class="trending-overlay">
            <h2>Trending Cafés</h2>
        
            <div class="photo-row">
            <?php foreach($trendingCafes as $cafe): ?>
                <div class="photo-group">
                    <img src="<?= htmlspecialchars($cafe['main_image']) ?>"
                        alt="<?= htmlspecialchars($cafe['cafe_name']) ?>">

                    <div class="cafe-info">
                        <h4><?= htmlspecialchars($cafe['cafe_name']) ?></h4>
                        <p>
                            ⭐ <?= number_format($cafe['average_rating'],1) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="right-panel">

        <div class="header">
            <h1 class="title">Cafe Tayo, Ano Tara?</h1>

            <p class="subtitle">
                Discover the perfect study café near you.
            </p>

        </div>

        <aside class="login-card">

            <h2>Welcome Back!</h2>

            <form
                action="../../../backend/controllers/authentication/loginController.php"
                method="POST"
                id="loginCntrlr"
                onsubmit="return validateForm()">

                <label>Email</label>

                <input type="email" name="email" id="email" placeholder="Enter your email" required>

                <label>Password</label>

                <div class="password-container">
                    <input type="password" id="password"  name="password" placeholder="Enter your password" required>

                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <div class="forgot">
                    <a href="forgotPassword.php">Forgot Password?</a>
                </div>

                <button type="submit" class="login-btn">Sign In</button>

                <p class="signup"> Don't have an account?
                    <a href="signUp.php">Sign Up</a>
                </p>

            </form>
        </aside>
    </div>
</div>

</body>
</html>