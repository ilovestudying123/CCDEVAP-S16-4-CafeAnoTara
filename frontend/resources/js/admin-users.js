// TO FIX: Function to handle user status change (active/suspended) along with image.

function userStatus(userID, statusID, actionID) {

    console.log("statusID:", statusID);
    console.log(document.getElementById(statusID));

    let status = document.getElementById(statusID);
    let action = document.getElementById(actionID);

    let newStatus;

    if (status.textContent.trim() === "active") {

        if (window.confirm("Are you sure you want to SUSPEND this user?")) {
            newStatus = "suspended";

        } else {
            return;
        }

    } else {

        if (window.confirm("Are you sure you want to ACTIVATE this user?")) {
            newStatus = "active";

        } else {
            return;
        }
    }

    // Send update to PHP controller
    let form = document.createElement("form");
    form.method = "POST";
    form.action = "../../../backend/controllers/admin/update-status.php";

    let idInput = document.createElement("input");
    idInput.type = "hidden";
    idInput.name = "user_id";
    idInput.value = userID;

    let statusInput = document.createElement("input");
    statusInput.type = "hidden";
    statusInput.name = "status";
    statusInput.value = newStatus;

    form.appendChild(idInput);
    form.appendChild(statusInput);

    document.body.appendChild(form);
    form.submit();
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
