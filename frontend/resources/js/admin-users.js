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
