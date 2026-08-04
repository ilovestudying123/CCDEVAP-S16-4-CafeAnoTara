async function approveReview(reportID) {
    // Show a confirmation dialog using SweetAlert2
     const result = await Swal.fire({
        title: "Approve this review?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, approve",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#725420"
    });

    if (!result.isConfirmed) {
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

    const data = await response.json();
    if (data.success) {
        await Swal.fire("Approved!", "Review approved.", "success");
        location.reload();
    } 
}

async function removeReview(reportID, reviewID){
    const result = await Swal.fire({
        title: "Remove this review?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, remove",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d33"
    });

    if (!result.isConfirmed) {
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

    const data = await response.json();

    if(data.success){
        await Swal.fire("Removed!", "Review removed.", "success");
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