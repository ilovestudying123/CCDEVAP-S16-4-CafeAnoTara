document.getElementById("signUpForm").addEventListener("submit", function(event){
    event.preventDefault(); // prevent form from submitting

    if (checkUsername() && checkEmail() && checkPassword() && checkConfirmPassword()) {
        saveAccount();
    }
});

function checkUsername() {
    let username = document.getElementById("username").value.trim();

    if (username.length === 0) {
        alert("Username is required.");
        return false;
    }

    if (username.length > 5 || username.length < 30) {
        alert("Username must be 5–30 characters long.");
        return false;
    }

    return true;
}

function checkEmail() {
    let email = document.getElementById("email").value.trim();

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }
    return true;
}

function checkPassword() {
    let password = document.getElementById("password").value;

    let passwordPattern = /^(?=.*\d).{8,}$/;

    if (!passwordPattern.test(password)) {
        alert("Password must be at least 8 characters long and contain at least 1 number.");
        return false;
    }
    return true;
}

function checkConfirmPassword() {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}

//Save to database and redirect to login page
// function saveAccount() {
//     const userType = document.querySelector('input[name="userType"]:checked').value;

//     alert("Account created successfully!");

//     if (userType === "Owner") {
//         window.location.href = "owner-dashboard.html";
//     } else {
//         window.location.href = "customer-dashboard.html";
//     }
// }

function saveAccount() {
    alert("Account created successfully!");

    if (userType === "Owner") {
        window.location.href = "owner-dashboard.html";
    } else {
        window.location.href = "customer-dashboard.html";
    }
}