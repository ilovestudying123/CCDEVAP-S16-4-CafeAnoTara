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
        Swal.fire("Missing info", "Please enter a category.", "warning");
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
        await Swal.fire("Added!", "Category added successfully.", "success");
        location.reload();
    }
    else {
        Swal.fire("Failed", "Failed to add category.", "error");
    }
}

async function updateCategory(){
    const report = document.getElementById("edit-report").value.trim();
    if(report === ""){
        Swal.fire("Missing info", "Please enter a category.", "warning");
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
        await Swal.fire("Updated!", "Category updated successfully.", "success");
        location.reload();
    }
    else{
        Swal.fire("Failed", "Failed to update category.", "error");
    }
}

async function deleteCategory(reportCode) {
    const proceed = await Swal.fire({
        title: "Delete this category?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    });

    if (!proceed.isConfirmed) {
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
        await Swal.fire("Deleted!", "Category deleted successfully.", "success");
        location.reload();
    } 
    else {
        Swal.fire("Failed", "Cannot delete this category because it is already used in reports.", "error");
    }
}
window.deleteCategory = deleteCategory;
window.updateCategory = updateCategory;