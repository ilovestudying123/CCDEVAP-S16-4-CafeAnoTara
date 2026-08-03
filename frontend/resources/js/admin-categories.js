let selectedCategory = null;

function openCreateModal() {
    document.getElementById("createModal").style.display = "flex";
}

function closeCreateModal() {
    document.getElementById("createModal").style.display = "none";
}

function openEditModal(reportCode, report) {
    selectedCategory = reportCode;
    document.getElementById("edit-report").value = report;
    document.getElementById("editModal").style.display = "flex";
}

function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}

window.openEditModal = openEditModal;
window.closeEditModal = closeEditModal;

async function createCategory() {
    const report = document.getElementById("create-report").value.trim();

    if (report === "") {
        alert("Please enter a category.");
        return;
    }
    const formData = new FormData();
    formData.append("report", report);
    const response = await fetch(
        "/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/reportController.php?action=create",
        {
            method: "POST",
            body: formData
        }
    );
    const result = await response.json();
    if (result.success) {
        alert("Category added successfully.");
        location.reload();
    }
    else {
        alert("Failed to add category.");
    }
}

async function updateCategory(){
    const report = document.getElementById("edit-report").value.trim();
    if(report === ""){
        alert("Please enter a category.");
        return;
    }
    const formData = new FormData();
    formData.append("report_code", selectedCategory);
    formData.append("report", report);
    const response = await fetch(
        "/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/reportController.php?action=update",
        {
            method:"POST",
            body:formData
        }
    );

    const result = await response.json();

    if(result.success){
        alert("Category updated successfully.");
        location.reload();
    }
    else{
        alert("Failed to update category.");
    }
}

async function deleteCategory(reportCode) {
    const proceed = confirm(
        "Are you sure you want to delete this category?"
    );

    if (!proceed) {
        return;
    }

    const formData = new FormData();
    formData.append(
        "report_code",
        reportCode
    );

    const response = await fetch(
        "/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/reportController.php?action=delete",
        {
            method: "POST",
            body: formData
        }
    );

    const result = await response.json();
    if (result.success) {
        alert("Category deleted successfully.");
        location.reload();
    } 
    else {
        alert("Cannot delete this category because it is already used in reports.");
    }
}
window.deleteCategory = deleteCategory;
window.updateCategory = updateCategory;