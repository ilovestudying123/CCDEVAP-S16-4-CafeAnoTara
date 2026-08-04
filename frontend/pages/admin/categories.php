<?php
require_once "../../../backend/config/connection.php";
require_once "../../../backend/controllers/user/reportController.php";

$categoriesController = new reportController($conn);
$categories = $categoriesController->getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Report Categories</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../resources/css/admin-categories.css">
</head>

<body>
    <!-- header -->
    <?php require "../../includes/header-admin.php"; ?>

    <div class="body-box">
        <div class="search-section">
            <h1>Report Categories</h1>
            <button class="add-btn" onclick="openCreateModal()">
                Add Category
            </button>
        </div>

        <div class="table-wrapper">
            <table id="categoriesTable">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category['report']) ?></td>
                        <td>
                            <div class="action-btn">
                                <button class="hidden-btn" onclick="openEditModal(<?= $category['report_code'] ?>,
                                    '<?= htmlspecialchars($category['report'], ENT_QUOTES) ?>')">
                                    <img src="../../resources/imgs/edit-btn.png"></button>
                                <button class="hidden-btn" onclick="deleteCategory(<?= $category['report_code'] ?>)">
                                    <img src="../../resources/imgs/delete.png"></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="createModal" class="modal">
            <div class="create-modal-content">
                <span class="close" onclick="closeCreateModal()">&times;</span>
                <h2>Add Report Category</h2>
                <form id="createCategoryForm">
                    <div class="field">
                        <label>Category Name</label>
                        <input type="text" id="create-report" placeholder="Enter category" required>
                    </div>

                    <div class="button-container">
                        <button type="button" class="add-btn" onclick="createCategory()">Save</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div id="editModal" class="modal">
            <div class="create-modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>

                <h2>Edit Report Category</h2>

                <form id="editCategoryForm">
                    <div class="field">
                        <label>Category Name</label>
                        <input type="text" id="edit-report" required>
                    </div>

                    <div class="button-container">
                        <button  type="button" class="add-btn" onclick="updateCategory()"> Save </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../resources/js/admin-categories.js"></script>
</body>
</html>