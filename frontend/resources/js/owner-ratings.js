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
    const reportButtons = document.querySelectorAll(".report-btn-class");
    
    reportButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            const reviewId = this.getAttribute("data-review-id");
            const userConfirmed = window.confirm("Proceed with the REPORT for review ID " + reviewId + "?");
            
            if (userConfirmed) {
                window.alert("REVIEW REPORTED");

            }
        });
    });
});