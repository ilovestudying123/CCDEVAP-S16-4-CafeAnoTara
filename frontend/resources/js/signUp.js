document.getElementById("signUpForm").addEventListener("submit", function(event) {

    let isValid =
        checkUsername() &&
        checkEmail() &&
        checkPassword() &&
        checkConfirmPassword();

    if (!isValid) {
        event.preventDefault();
    }

});

function checkUsername() {
    let username = document.getElementById("username").value.trim();

    if (username.length === 0) {
        alert("Username is required.");
        return false;
    }

    if (username.length < 5 || username.length > 30) {
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

    if (password.length === 0) {
        alert("Password is required.");
        return false;
    }

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

function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.querySelector(".toggle-password i");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}

function togglePasswordconf() {
    const password = document.getElementById("confirmPassword");
    const icon = document.querySelector(".toggle-passwordconf i");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}