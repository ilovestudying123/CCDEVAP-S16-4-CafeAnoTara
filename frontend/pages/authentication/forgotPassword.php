<?php
    require "../../../backend/config/connection.php";
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
<div class="whole">    
    <div class="header">
    <h1 class="title">Cafe Tayo, Ano Tara?</h1>
    </div>
    <div class="content">
        <section class="trending">
            <h3 class="trend">Trending Cafes:</h3>

            <div class="photo-row">
                <div class="photo-group">
                    <img src="../../resources/imgs/yardstick.jpg" alt="Top 1" width="100" height="100"/>
                    <h5>Yardstick Coffee</h5>
                </div>
                <div class="photo-group">                    
                    <img src="../../resources/imgs/starbucks.jpg" alt="Top 2" width="100" height="100"/>
                    <h5>Starbucks</h5>
                </div>    
                <div class="photo-group">   
                    <img src="../../resources/imgs/cbtl.jpg" alt="Top 3" width="100" height="150"/>
                    <h5>Coffee Bean & Tea Leaf</h5>
                </div>
            </div>
        
        </section>

        <aside class="resetPass">    
            <h3>Forgot Password</h3>
            <form id="loginForm">
                <p>Enter your email to reset your password.</p>
                <label for="username">Email </label>
                <input type="text" id="username" name="username" required>
                <label for="newpassword">New Password</label>

                <div class="password-container">
                    <input type="password" id="newpasword" name="newpasword" required>

                    <button type="button" class="toggle-passwordnew" onclick="togglePasswordnew()">
                        <i class="fa-solid fa-eye"></i>
                    </button>

                </div>

                <label for="newpassword">Confirm New Password</label>

                <div class="password-container">
                    <input type="password" id="confnewpasword" name="confnewpasword" required>

                    <button type="button" class="toggle-passwordconf" onclick="togglePasswordconf() ">
                        <i class="fa-solid fa-eye"></i>
                    </button>

                </div>
                
                <button type="button" class="submit-btn" onclick="checkPass();">Submit</button>
                <p>Don't have an account? <a href="../authentication/signUp.html">Sign up</a></p>
            </form>
        </aside>  
    </div>   
</div>     
</body>
</html>