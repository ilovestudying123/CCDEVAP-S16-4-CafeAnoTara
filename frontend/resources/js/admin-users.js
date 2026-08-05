// Data Tables
document.addEventListener("DOMContentLoaded", () => {
    new DataTable("#usersTable", {
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 5
    });
});

// SweetAlert2 for confirmation dialogs
document.addEventListener("submit", function (e) {

    // Status form
    if (e.target.matches(".status-form")) {
        e.preventDefault();

        const form = e.target;

        Swal.fire({
            title: "Change user status?",
            text: "You are about to change this user's status.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, continue",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#725420"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    // Delete form
    if (e.target.matches(".delete-form")) {
        e.preventDefault();

        const form = e.target;

        Swal.fire({
            title: "Delete this user?",
            text: "This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#d33"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

});