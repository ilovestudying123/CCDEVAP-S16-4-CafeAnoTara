<?php
    require "../../../backend/config/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-reviews.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
    <script src="../../resources/js/admin-reviews.js"></script>
</head>

<body>
    <div id="header">
        <?php require "../../includes/header-admin.php"; ?>
    </div>

    <div class="body-box">

        <div class="header-section">
            <h1>Reviews & Content Moderation</h1>
        </div>

        <div class="table-wrapper">
            <table id="reviewsTable" class="display">
                
                <thead>
                <tr>
                    <th>Reported By</th>
                    <th>Review</th>
                    <th>Reason</th>
                    <th>Date Created</th>
                    <th>Status</th> 
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>Ramona Gray</td>
                    <td>"Anyone who likes this café is stupid."</td>
                    <td>Inappropriate Language</td>
                    <td>2-16-2026</td>
                    <td class="status">Pending</td>
                    <td>
                        <div class="action-btn">
                            <img
                                id="action1" class="x-img" src="../../resources/imgs/check-mark.png" alt="Approve" onclick="approveReview(this)">
                            <img
                                id="action1" class="x-img" src="../../resources/imgs/x-mark.png" alt="Remove" onclick="removeReview(this)">
                             <a href="reviews-update.php">
                                <img
                                id="action1" class="edit-btn" src="../../resources/imgs/edit-btn.png" alt="Edit" onclick=""></a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</body>