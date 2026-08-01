document.addEventListener("DOMContentLoaded", () => {

    // Monthly Sign-ups Per Role (Multi-line Chart)
    const lineChart = document.getElementById("lineChart");

    const roleColors = {
        customer: "#4CAF50",
        owner: "#2196F3",
        admin: "#FFC107"
    };

    const lineDatasets = Object.keys(usersByRole).map(role => {
        const color = roleColors[role] || "#888888";
        return {
            label: role.charAt(0).toUpperCase() + role.slice(1),
            data: usersByRole[role],
            borderColor: color,
            backgroundColor: color,
            fill: false,
            tension: 0.3
        };
    });

    new Chart(lineChart, {
        type: "line",
        data: {
            labels: userMonths,
            datasets: lineDatasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: "top"
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Users per Role (Pie Chart)
    const pieChart = document.getElementById("pieChart");

    new Chart(pieChart, {
        type: "pie",
        data: {
            labels: roles,
            datasets: [{
                data: roleTotals,
                backgroundColor: [
                    "#4CAF50",
                    "#2196F3",
                    "#FFC107"
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Most Bookmarked Cafes (Bar Chart)
    const barGraph2 = document.getElementById("barGraph2");

    new Chart(barGraph2, {
        type: "bar",
        data: {
            labels: bookmarkCafe,
            datasets: [{
                label: "Bookmarks",
                data: bookmarkCount,
                backgroundColor: "#9C27B0"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

});

// Data Tables
document.addEventListener("DOMContentLoaded", () => {
    new DataTable("#rankedCafesTable", {
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 5
    });
});
