function toggleFilter() {
    const panel = document.getElementById('dropdown-filter-options');
    
    if (panel.style.display === 'block') {
        panel.style.display = 'none';
    } else {
        panel.style.display = 'block';
    }
}

function toggleSort() {
    const panel = document.getElementById('dropdown-sort-options');
    
    if (panel.style.display === 'block') {
        panel.style.display = 'none';
    } else {
        panel.style.display = 'block';
    }
}

const reportBtn = document.getElementById("report-btn");

if (reportBtn) {
    reportBtn.onclick = () => {
        const userConfirmed = window.confirm("Proceed with the REPORT?");
        
        if (userConfirmed) {
            window.alert("REVIEW REPORTED");
        }
    };
}