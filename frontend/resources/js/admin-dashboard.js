document.addEventListener("DOMContentLoaded", () => {

    const barChart1 = document.getElementById("barChart1");

    new Chart(barChart1, {
        type: "bar",
        data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [{
                label: "# of New Signups",
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1,
                backgroundColor: "#0482ff"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const barChart2 = document.getElementById("barChart2");

    new Chart(barChart2, {
        type: "bar",
        data: {
            labels: ["Below 18", "18-25", "26-39", "40-59", "60+"],
            datasets: [
                {
                    label: "Satisfied",
                    data: [32, 84, 65, 48, 20],
                    backgroundColor: "#4CAF50"
                },
                {
                    label: "Unsatisfied",
                    data: [8, 2, 5, 19, 30],
                    backgroundColor: "#F44336"
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const lineChart = document.getElementById("lineChart");

    new Chart(lineChart, {
        type: "line",
        data: {
            labels: ["6 AM", "8 AM", "10 AM", "12 PM", "2 PM", "4 PM", "6 PM", "8 PM", "10 PM"],
            datasets: [{
                label: "Visitors",
                data: [8, 20, 42, 65, 32, 23, 78, 50, 20],
                borderColor: "#70a83c",
                backgroundColor: "rgba(165, 216, 122, 0.2)",
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });


    const doughnutChart = document.getElementById("doughnutChart");

    new Chart(doughnutChart, {
        type: "doughnut",
        data: {
            labels: [
                "Fast Wi-Fi",
                "Quiet Environment",
                "Power Outlets",
                "Long Operating Hours",
                "Affordable"
            ],
            datasets: [{
                data: [35, 28, 18, 12, 7],
                backgroundColor: [
                    "#4CAF50",
                    "#2196F3",
                    "#FFC107",
                    "#FF9800",
                    "#9C27B0"
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

});