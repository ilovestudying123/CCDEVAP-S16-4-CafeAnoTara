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

function validateForm() {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("newpassword").value;
    const confirmPassword = document.getElementById("confnewpassword").value;

    if (email === "" || password === "" || confirmPassword === "") {
        alert("Please fill out all fields.");
        return false;
    }

    if (!email.includes("@")) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}