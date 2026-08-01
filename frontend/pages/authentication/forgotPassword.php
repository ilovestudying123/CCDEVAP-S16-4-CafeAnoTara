<?php
session_start();
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
                <div class="photo-group">
                    <img src="../../resources/imgs/yardstick.jpg" alt="Top 1">
                    <div class="cafe-info">
                        <h4>Yardstick Coffee</h4>
                    </div>
                </div>

                <div class="photo-group">
                    <img src="../../resources/imgs/starbucks.jpg" alt="Top 2">
                    <div class="cafe-info">
                        <h4>Starbucks</h4>
                    </div>
                </div>

                <div class="photo-group">
                    <img src="../../resources/imgs/cbtl.jpg" alt="Top 3">
                    <div class="cafe-info">
                        <h4>Coffee Bean & Tea Leaf</h4>
                    </div>
                </div>
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

            <form action="../../../backend/controllers/authentication/forgetPassController.php" id="loginForm" method="POST" onsubmit="return validateForm()">

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

                <button type="submit" class="submit-btn">Submit</button>

                <p class="signup">Don't have an account? <a href="../authentication/signUp.php">Sign up</a></p>

            </form>

        </div>

    </div>

</div>

</body>
</html>