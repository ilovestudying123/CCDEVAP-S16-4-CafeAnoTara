function userStatus(statusID, actionID) {
    let status = document.getElementById(statusID);
    let action = document.getElementById(actionID);

    if (status.textContent === "Active") {
        if (window.confirm("Are you sure you want to SUSPEND this user?")) {
            status.textContent = "Inactive";

            action.src = "../../resources/imgs/check-mark.png";
            action.alt = "Activate";
        }
    } else {
        if (window.confirm("Are you sure you want to ACTIVATE this user?")) {
            status.textContent = "Active";

            action.src = "../../resources/imgs/x-mark.png";
            action.alt = "Suspend";
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new DataTable("#usersTable", {
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 5
    });
});
