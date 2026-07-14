function validateForm() {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;

    if (email === "" || password === "") {
        alert("Please fill out all fields.");
        return false; // Blocks form from submitting to PHP
    }

    if (!email.includes("@")) {
        alert("Please enter a valid email address.");
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