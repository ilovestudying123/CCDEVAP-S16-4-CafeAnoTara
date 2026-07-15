<?php
require "../../../backend/config/connection.php";
require "../../../backend/models/admin/reviews-sql.php";

$reviewModel = new ReviewModel($conn);

$reportID = $_GET['id'];
$report = $reviewModel->getReviewReport($reportID);
$reportCodes = $reviewModel->getReportCodes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-reviews-update.css">
</head>

<body>
    <div id="header"></div>

    <div class="body-box">
        <div class="header-section">
            <h1>Update Review</h1>
        </div>

        <form action="../../../backend/controllers/admin/review-update.php" method="POST">
            <input type="hidden" name="reportID" value="<?= $report['report_id'] ?>">
            <input type="hidden" name="reviewID" value="<?= $report['review_id'] ?>">
            
            <a href="reviews.php" class="back-link">Go Back</a>

            <div class="field">
                <label for="review">Review</label>
                <input type="text" name="review" value="<?= htmlspecialchars($report['comment']) ?>">
            </div>

            <div class="field">
                <label for="dateCreated">Date Created</label>
                <input type="datetime-local" name="dateCreated" value="<?= date('Y-m-d\TH:i', strtotime($report['created_on'])) ?>">
            </div>

            <div class="row">
                <div class="field">
                    <label for="status">Status</label>
                    <select name="status" required>
                        <option value="ongoing" 
                            <?= $report['status']=="ongoing" ? "selected" : "" ?>
                            >Ongoing
                            </option>

                            <option
                                value="resolved"
                                <?= $report['status']=="resolved" ? "selected" : "" ?>>
                                Resolved
                            </option>
                    </select>
                </div>

                <div class="field">
                    <label for="reason">Reason</label>
                    <select name="reason">
                        <?php while($code = $reportCodes->fetch_assoc()): ?>

                        <option
                            value="<?= $code['report_code'] ?>"
                            <?= ($code['report_code'] == $report['report_code']) ? "selected" : "" ?>>
                            <?= htmlspecialchars($code['report']) ?>
                        </option>

                        <?php endwhile; ?>
                        </select>
                </div>
            </div>

            <input type="submit" value="Update Review">
        </form>
    </div>
</body>
</html>