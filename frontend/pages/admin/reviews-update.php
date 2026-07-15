<?php
    // require_once "../../../backend/config/connection.php";
    // require "../../../backend/models/admin/users-sql.php";

    // $userModel = new UserModel($conn);
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

        <form>
            <a href="reviews.php" class="back-link">Go Back</a>

            <div class="field">
                <label for="name">Reported By</label>
                <input type="text" name="reportedBy" placeholder="First name last name" required>
            </div>

            <div class="field">
                <label for="review">Review</label>
                <input type="text" name="review" placeholder="Exising review here" required>
            </div>

            <div class="field">
                <label for="dateCreated">Date Created</label>
                <input type="datetime-local" id="dateCreated" name="dateCreated">
            </div>

            <div class="row">
                <div class="field">
                    <label for="status">Status</label>
                    <select name="status" required>
                        <option value="ongoing">ongoing</option>
                        <option value="resolved">resolved</option>
                    </select>
                </div>

                <div class="field">
                    <label for="reason">Reason</label>
                    <select name="reason" required>
                        <option value="harassment">Harassment</option>
                        <option value="hateSpeech">Hate Speech</option>
                        <option value="falseInformation">False Information</option>
                    </select>
                </div>
            </div>

            <input type="submit" value="Update Review">
        </form>
    </div>
</body>
</html>