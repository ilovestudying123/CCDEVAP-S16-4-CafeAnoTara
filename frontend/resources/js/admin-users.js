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
document.addEventListener('DOMContentLoaded', () => {
    // Status change confirmation
    document.querySelectorAll('.status-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // stop default submit

            Swal.fire({
                title: 'Change user status?',
                text: "You are about to change this user's status.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#725420', // optional, match your theme
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // actually submit if confirmed
                }
            });
        });
    });

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Delete this user?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});