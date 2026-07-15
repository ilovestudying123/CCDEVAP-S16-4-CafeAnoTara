document.addEventListener("DOMContentLoaded", () => {
    fetch("/CCDEVAP-S16-4-CafeAnoTara/frontend/includes/header-user.php")
        .then(response => {
            if (!response.ok) throw new Error("Header file not found");
            return response.text();
        })
        .then(data => {
            document.getElementById("header").innerHTML = data;
        })
        .catch(error => console.error("Error loading header:", error));
});