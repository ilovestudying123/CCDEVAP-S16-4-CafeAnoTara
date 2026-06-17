
function checkUser() {   
    if (document.getElementById("username").value === "customer@gmail.com" && document.getElementById("password").value === "customer123") {
        window.location.href = "../user/dashboard.html";
    } else if (document.getElementById("username").value === "owner@gmail.com" && document.getElementById("password").value === "owner123") {
        window.location.href = "../owner/dashboard.html";
    } else if (document.getElementById("username").value === "admin@gmail.com" && document.getElementById("password").value === "admin123") {
        window.location.href = "../admin/dashboard.html";
    } else {
        alert("Sorry this account doesn't exist. Please try again.");
    }
}

