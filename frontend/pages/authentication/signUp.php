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
    <title>Sign Up Page</title>

    <link rel="stylesheet" href="../../resources/css/signUp.css">
    <script src="../../resources/js/signUp.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<?php
if (isset($_SESSION['error'])) {
    echo "<script>alert('" . addslashes($_SESSION['error']) . "');</script>";
    unset($_SESSION['error']);
}
?>

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
            <p class="subtitle">Become a member today!</p>
        </div>

        <div class="signUp">

            <form action="../../../backend/controllers/authentication/signUpController.php"
                  method="POST"
                  id="signUpForm">

                <label for="username">Username</label>
                <input type="text"
                       id="username"
                       name="username"
                       required>

                <label for="email">Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       required>

                <div class="name-row">

                    <div>
                        <label for="firstName">First Name</label>
                        <input type="text"
                               id="firstName"
                               name="firstName"
                               required>
                    </div>

                    <div>
                        <label for="lastName">Last Name</label>
                        <input type="text"
                               id="lastName"
                               name="lastName"
                               required>
                    </div>

                </div>

                <div class="password-row">

                    <div>
                        <label for="password">Password</label>

                        <div class="password-container">

                            <input type="password"
                                   id="password"
                                   name="password"
                                   required>

                            <button type="button"
                                    class="toggle-password"
                                    onclick="togglePassword()">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                        </div>
                    </div>

                    <div>

                        <label for="confirmPassword">Confirm Password</label>

                        <div class="password-container">

                            <input type="password"
                                   id="confirmPassword"
                                   name="confirmPassword"
                                   required>

                            <button type="button"
                                    class="toggle-passwordconf"
                                    onclick="togglePasswordconf()">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                        </div>

                    </div>

                </div>

                <div class="user-type">

                    <label>User Type</label>

                    <div class="radio-row">

                        <div class="radio-group">
                            <input type="radio"
                                   id="ownerType"
                                   name="userType"
                                   value="owner"
                                   required>
                            <label for="ownerType">Owner</label>
                        </div>

                        <div class="radio-group">
                            <input type="radio"
                                   id="customerType"
                                   name="userType"
                                   value="customer"
                                   required>
                            <label for="customerType">Customer</label>
                        </div>

                    </div>

                </div>

                <button type="submit" class="create-btn">
                    Create Account
                </button>

                <p class="signup">
                    Already have an account?
                    <a href="index.php">Sign In</a>
                </p>

            </form>

        </div>

    </div>

</div>

</body>
</html>