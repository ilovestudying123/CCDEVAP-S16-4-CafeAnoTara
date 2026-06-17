document.addEventListener("DOMContentLoaded", () => {
    fetch("../../includes/header-admin.html")
        .then(response => {
            if (!response.ok) throw new Error("Header file not found");
            return response.text();
        })
        .then(data => {
            document.getElementById("header").innerHTML = data;
        })
        .catch(error => console.error("Error loading header:", error));
});

function toggleFilter() {
    const panel = document.getElementById('filter-options');
    if (panel.style.display === 'block') {
        panel.style.display = 'none';
    } else {
        panel.style.display = 'block';
    }
}

function toggleSort() {
    const panel = document.getElementById('sort-options');
    
    if (panel.style.display === 'block') {
        panel.style.display = 'none';
    } else {
        panel.style.display = 'block';
    }
}

function userStatus(statusID, actionID) {
    let status = document.getElementById(statusID);
    let action = document.getElementById(actionID);
    let userConfirm = false;

    if (status.textContent === "Active") {
        userConfirm = window.confirm("Are you sure you want to SUSPEND this user?");

        if (userConfirm) {
            status.textContent = "Inactive";
            action.textContent = "[Activate]";
            action.style.color = "green";
        }
    } else {
        userConfirm = window.confirm("Are you sure you want to ACTIVATE this user?");

        if (userConfirm) {
            status.textContent = "Active";
            action.textContent = "[Suspend]";
            action.style.color = "red";
        }
    }
}
