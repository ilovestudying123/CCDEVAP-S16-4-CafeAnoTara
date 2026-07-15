function toggleFilter() {
    const panel = document.getElementById('dropdown-filter-options');
    panel.style.display = (panel.style.display === 'block') ? 'none' : 'block';
}

function toggleSort() {
    const panel = document.getElementById('dropdown-sort-options');
    panel.style.display = (panel.style.display === 'block') ? 'none' : 'block';
}

function applyFilter() {
    const selectedRadio = document.querySelector('input[name="stars"]:checked');
    const urlParams = new URLSearchParams(window.location.search);
    if (selectedRadio) {
        urlParams.set('stars', selectedRadio.value);
    }
    window.location.search = urlParams.toString();
}

function clearFilter() {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.delete('stars');
    window.location.search = urlParams.toString();
}

function applySort() {
    const selectedRadio = document.querySelector('input[name="sort_by"]:checked');
    const urlParams = new URLSearchParams(window.location.search);
    if (selectedRadio) {
        urlParams.set('sort', selectedRadio.value);
    }
    window.location.search = urlParams.toString();
}

function clearSort() {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.delete('sort');
    window.location.search = urlParams.toString();
}

document.addEventListener("DOMContentLoaded", function() {
    const reportButtons = document.querySelectorAll(".report-btn");
    const modal = document.getElementById("report-modal");

    reportButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            const reviewId = this.getAttribute("data-review-id");
            const reporterId = this.getAttribute("data-reporter-id");

            document.getElementById("modal-review-id").value = reviewId;
            document.getElementById("modal-reporter-id").value = reporterId;
            
            modal.style.display = "flex";
        });
    });
});

function closeReportModal() {
    document.getElementById("report-modal").style.display = "none";
    document.getElementById("report-form").reset();
}