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
    <title>Login Page</title>
    <link rel="stylesheet" href="../../resources/css/forgotPassword.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="../../resources/js/forgotPassword.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php if (isset($_SESSION['success'])): ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        title: "Success!",
        text: <?= json_encode($_SESSION['success']) ?>,
        icon: "success",
        confirmButtonText: "OK",
        confirmButtonColor: "#725420"
    });
});
</script>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>
<div class="container">

    <div class="left-panel">
        <img src="../../resources/imgs/login.jpg" alt="Background Image">
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
            <p class="subtitle">Forgot your password?</p>
        </div>

        <div class="resetPass">

            <h2>Reset Password</h2>

            <form action="../../../backend/controllers/userController.php?action=forgotPassword"
                id="loginForm"
                method="POST"
                onsubmit="return validateForm()">

                <p>Enter your email to reset your password.</p>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="newpassword">New Password</label>
                <div class="password-container">
                    <input type="password" id="newpassword" name="newpassword" required>
                    <button type="button" class="toggle-passwordnew" onclick="togglePasswordnew()">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <label for="confnewpassword">Confirm New Password</label>
                <div class="password-container">
                    <input type="password" id="confnewpassword" name="confnewpassword" required>
                    <button type="button" class="toggle-passwordconf" onclick="togglePasswordconf()">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <p class="forgot-error">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </p>
                    <?php unset($_SESSION['error']); ?>
                <?php else: ?>
                    <p class="forgot-error" id="forgotError"></p>
                <?php endif; ?>

                <button type="submit" class="submit-btn">Submit</button>

                <p class="signup">Don't have an account? <a href="../authentication/signUp.php">Sign up</a></p>

            </form>

        </div>

    </div>

</div>

</body>
</html>