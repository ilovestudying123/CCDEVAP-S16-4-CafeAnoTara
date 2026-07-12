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

    if (status.textContent === "Active") {
        if (window.confirm("Are you sure you want to SUSPEND this user?")) {
            status.textContent = "Inactive";

            action.src = "../../resources/imgs/check-mark.png";
            action.alt = "Activate";
        }
    } else {
        if (window.confirm("Are you sure you want to ACTIVATE this user?")) {
            status.textContent = "Active";

            action.src = "../../resources/imgs/x-mark.png";
            action.alt = "Suspend";
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new DataTable("#usersTable", {
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 5
    });
});
