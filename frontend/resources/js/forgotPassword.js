function showError(message) {
    document.getElementById("forgotError").textContent = message;
}

function validateForm() {

    document.getElementById("forgotError").textContent = "";

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("newpassword").value;
    const confirmPassword = document.getElementById("confnewpassword").value;

    if (email === "" || password === "" || confirmPassword === "") {
        showError("Please fill out all fields.");
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        showError("Please enter a valid email address.");
        return false;
    }

    const passwordPattern = /^(?=.*\d).{8,}$/;

    if (!passwordPattern.test(password)) {
        showError("Password must be at least 8 characters long and contain at least 1 number.");
        return false;
    }

    if (password !== confirmPassword) {
        showError("Passwords do not match.");
        return false;
    }

    return true;
}

function togglePasswordnew() {
    const password = document.getElementById("newpassword");
    const icon = document.querySelector(".toggle-passwordnew i");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}

function togglePasswordconf() {
    const password = document.getElementById("confnewpassword");
    const icon = document.querySelector(".toggle-passwordconf i");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}