function approveReview(link) {
    if (!confirm("Are you sure you want to APPROVE this review?")) return;

    let row = link.closest("tr");

    row.querySelector(".status").textContent = "Approved";

    row.querySelector("td:last-child").innerHTML =
        '<span class="resolved-text">No Action</span>';
}

function removeReview(link) {
    if (!confirm("Are you sure you want to REMOVE this review?")) return;

    let row = link.closest("tr");

    row.querySelector(".status").textContent = "Removed";

    row.querySelector("td:last-child").innerHTML =
        '<span class="resolved-text">No Action</span>';
}