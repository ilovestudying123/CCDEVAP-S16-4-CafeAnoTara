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