<?php
require "../../../backend/controllers/user/reviewController.php";

$controller = new reviewController($conn);

$reports = $controller->getAllReportedReviews();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports & Content Moderation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-reviews.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../resources/js/admin-reviews.js"></script>
</head>

<body>
    <!-- header -->
    <?php require "../../includes/header-admin.php"; ?>

    <div class="body-box">

        <div class="header-section">
            <h1>Reports & Content Moderation</h1>
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
                <?php while ($row = $reports->fetch_assoc()) :?>
                <tr>
                    <td><?= htmlspecialchars($row['reported_by']) ?></td>
                    <td><?= htmlspecialchars($row['comment']) ?></td>
                    <td><?= htmlspecialchars($row['report']) ?></td>
                    <td><?= htmlspecialchars($row['created_on']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <div class="action-btn">
                            <img
                                id="action1" class="x-img" src="../../resources/imgs/check-mark.png" alt="Approve" onclick="approveReview(<?= $row['report_id'] ?>)">
                            <img
                                id="action1" class="x-img" src="../../resources/imgs/x-mark.png" 
                                    alt="Remove" onclick="removeReview(<?= $row['report_id'] ?>, <?= $row['review_id'] ?>)">
                             <a href="reviews-update.php?id=<?= $row['report_id'] ?>">
                                <img
                                    class="edit-btn"
                                    src="../../resources/imgs/edit-btn.png"
                                    alt="Edit">
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</body>