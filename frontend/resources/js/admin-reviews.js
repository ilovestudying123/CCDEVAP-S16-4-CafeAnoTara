async function approveReview(reportID) {
    if (!confirm("Approve this review?")) {
        return;
    }

    const formData = new FormData();
    formData.append("report_id", reportID);

    const response = await fetch(
        "/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/reviewController.php?action=approveReview",
        {
            method: "POST",
            body: formData
        }
    );

    const result = await response.json();
    if(result.success){
        alert("Review approved.");
        location.reload();
    }
}

async function removeReview(reportID, reviewID){
    if(!confirm("Remove this review?")){
        return;
    }

    const formData = new FormData();

    formData.append("report_id", reportID);
    formData.append("review_id", reviewID);

    const response = await fetch(
        "/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/reviewController.php?action=removeReview",
        {
            method:"POST",
            body:formData
        }
    );

    const result = await response.json();

    if(result.success){
        alert("Review removed.");
        location.reload();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new DataTable("#reviewsTable", {
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 5
    });
});