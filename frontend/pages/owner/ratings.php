<?php
    require '../../../backend/config/connection.php';   
    require_once __DIR__ . "/../../../backend/controllers/user/reviewController.php";

    $controller = new reviewController($conn);

    $current_user_id = $_SESSION['user_id'] ?? 2;
    $cafe_id = 1; // change to SESSION

    $selected_star = $_GET['stars'] ?? '';
    $selected_sort = $_GET['sort']  ?? ($_GET['sort_by'] ?? '');

    $ratingsData = $controller->getCafeRatingsData($cafe_id, $selected_star, $selected_sort);

    $cafe_name      = $ratingsData['cafe_name'];
    $report_codes   = $ratingsData['report_codes'];
    $reviews_result = $ratingsData['reviews_result'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Models extension -->
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/owner-ratings.css?v=4">
    <title>Cafe Reviews</title>
</head>

<body>
    <!-- header -->
    <?php require "../../includes/header-owner.php"; ?>
    
    <script src="../../resources/js/owner-ratings.js" defer></script>

    <div class="body-box">
        <h1 class="cafe-name"><?php echo htmlspecialchars($cafe_name); ?></h1>

        <div class="grid-btn">
            <div class="dropdown">
                <button id="filter-btn" class="filter-btn" onclick="toggleFilter()">
                    <img src="../../resources/imgs/sliders-solid.png" class="filter-img" alt="filter"> Filter
                </button>
                <div id="dropdown-filter-options">
                    <p>Cafe Rating:</p>
                    <label><input type="radio" name="stars" value="five" <?php if($selected_star == 'five') echo 'checked'; ?>>5 Stars</label> <br>
                    <label><input type="radio" name="stars" value="four" <?php if($selected_star == 'four') echo 'checked'; ?>>4 Stars & Up</label> <br>
                    <label><input type="radio" name="stars" value="three" <?php if($selected_star == 'three') echo 'checked'; ?>>3 Stars & Up</label> <br>
                    <label><input type="radio" name="stars" value="two" <?php if($selected_star == 'two') echo 'checked'; ?>>2 Stars & Up</label> <br>
                    <label><input type="radio" name="stars" value="one" <?php if($selected_star == 'one') echo 'checked'; ?>>1 Stars & Up</label> <br><br>
                    <div class="filter-buttons">
                        <button type="button" onclick="applyFilter()">Apply</button>
                        <button type="button" onclick="clearFilter()">Clear</button>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <button id="sort-btn" class="sort-btn" onclick="toggleSort()">
                    <img src="../../resources/imgs/sort-solid.png" class="sort-img" alt="sort"> Sort
                </button>
                <div id="dropdown-sort-options">
                    <p>Cafe Rating:</p>
                    <label><input type="radio" name="sort_by" value="new" <?php if($selected_sort == 'new' || $selected_sort == '') echo 'checked'; ?>>Newest To Oldest</label> <br>
                    <label><input type="radio" name="sort_by" value="old" <?php if($selected_sort == 'old') echo 'checked'; ?>>Oldest To Newest</label> <br> <br>
                    <div class="filter-buttons">
                        <button type="button" onclick="applySort()">Apply</button>
                        <button type="button" onclick="clearSort()">Clear</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="reviews-list">
            <?php 
            if ($reviews_result && $reviews_result->num_rows > 0): 
                while($review = $reviews_result->fetch_assoc()): 
            ?>
                <section class="rating-box">
                    <div class="review-card">
                        <div class="review-img">
                            <img src="../../resources/imgs/cafe.jpg" alt="User Avatar">
                        </div>
                        
                        <div class="review-text">
                            <div class="review-header">
                                <p class="review-title"><b><?php echo htmlspecialchars($review['firstname'] . ' ' . $review['lastname']); ?></b></p>
                                
                                <!-- Checks the status of the report to change text-->
                                <?php
                                    $text = "Report";
                                    $disabled = "";

                                    if (!empty($review['report_id'])) {

                                        if ($review['status'] == "ongoing") {
                                            $text = "Pending Report";
                                            $disabled = "disabled";
                                        }
                                        elseif ($review['status'] == "approved") {
                                            $text = "Approved";
                                            $disabled = "disabled";
                                        }
                                        elseif ($review['status'] == "rejected") {
                                            $text = "Rejected";
                                            $disabled = "disabled";
                                        }
                                    }
                                ?>

                                <!-- Changes the button text and disables button -->
                                <button
                                    type="button"
                                    class="report-btn"
                                    <?= $disabled ?>
                                        data-review-id="<?= $review['review_id']; ?>"
                                        data-reporter-id="<?= $current_user_id; ?>">
                                    <?= $text ?>
                                </button>
                            </div>
                            
                            <p class="rating"><span class="star">★</span> <?php echo number_format($review['rating'], 1); ?>/5</p>
                            <p class="review-body"><?php echo htmlspecialchars($review['comment']); ?></p>
                            
                            <div class="review-reply">
                                <?php if (!empty($review['owner_reply'])): ?>
                                    <div class="saved-reply-box">
                                        <p class="reply-label"><b>Your Response:</b></p>
                                        <p class="reply-content"><?php echo htmlspecialchars($review['owner_reply']); ?></p>
                                    </div>
                                <?php else: ?>
                                    <!-- Submit Reply direct to the Controller file -->
                                    <form action="../../../backend/controllers/user/reviewController.php" method="POST">
                                        <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                                        <textarea id="reply-text" name="owner_reply" placeholder="Add reply" required></textarea>
                                        <button type="submit" id="submit-btn">Submit</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
                <br>
            <?php 
                endwhile; 
            else: 
            ?>
                <p class="no-reviews" style="text-align: center; font-weight: bold; padding: 20px;">No reviews found</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Report Modal -->
    <div id="report-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h3>Report Review</h3>
            <p>Select the reason for reporting this review:</p>
            
            <form id="report-form" action="../../../backend/controllers/user/reviewController.php" method="POST">
                <input type="hidden" id="modal-review-id" name="review_id">
                <input type="hidden" id="modal-reporter-id" name="reporter_id">
                
                <div class="violation-options">
                    <?php if (!empty($report_codes)): ?>
                        <?php foreach($report_codes as $code): ?>
                            <label class="modal-radio-label">
                                <input type="radio" name="report_code" value="<?php echo $code['report_code']; ?>" required>
                                <?php echo htmlspecialchars($code['report']); ?>
                            </label><br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeReportModal()">Cancel</button>
                    <button type="submit" name="submit_report" class="btn-submit">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>