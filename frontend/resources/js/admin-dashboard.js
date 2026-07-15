document.addEventListener("DOMContentLoaded", () => {

    // Monthly Sign-ups (Line Chart)
    const lineChart = document.getElementById("lineChart");

    new Chart(lineChart, {
        type: "line",
        data: {
            labels: userMonths,
            datasets: [{
                label: "New User Sign-ups",
                data: userTotals,
                borderColor: "#0482ff",
                backgroundColor: "rgba(4,130,255,0.2)",
                fill: true,
                tension: 0.3
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

    // Highest Rated Cafes (Horizontal Bar Chart)
    const barGraph1 = document.getElementById("barGraph1");

    new Chart(barGraph1, {
        type: "bar",
        data: {
            labels: cafeNames,
            datasets: [{
                label: "Average Rating",
                data: ratings,
                backgroundColor: "#70a83c"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: "y",
            scales: {
                x: {
                    beginAtZero: true,
                    max: 5
                }
            }
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