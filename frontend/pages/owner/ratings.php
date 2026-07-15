<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/owner-ratings.css?v=4">
    <?php require "../../../backend/models/owner/ratings-sql.php"; ?>
    <title>Cafe Reviews</title>
</head>

<body>
    <div id="header"></div>
    <script src="../../resources/js/script-header-owner.js"></script>
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
                                
                                <button type="button" 
                                        class="report-btn"
                                        data-review-id="<?php echo $review['review_id']; ?>" 
                                        data-reporter-id="<?php echo $current_user_id; ?>">
                                    Report
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
                                    <form action="../../../backend/models/owner/save-reply.php" method="POST">
                                        <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                                        <textarea id="reply-text" name="owner_reply" placeholder="Add reply"></textarea>
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

    <div id="report-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h3>Report Review</h3>
            <p>Select the reason for reporting this review:</p>
            
            <form id="report-form" action="" method="POST">
                <input type="hidden" id="modal-review-id" name="review_id">
                <input type="hidden" id="modal-reporter-id" name="reporter_id">
                
                <div class="violation-options">
                    <?php
                    $code_sql = "SELECT report_code, report FROM ReportCode";
                    $code_result = $conn->query($code_sql);
                    if ($code_result && $code_result->num_rows > 0):
                        while($code = $code_result->fetch_assoc()):
                    ?>
                        <label class="modal-radio-label">
                            <input type="radio" name="report_code" value="<?php echo $code['report_code']; ?>" required>
                            <?php echo htmlspecialchars($code['report']); ?>
                        </label><br>
                    <?php 
                        endwhile;
                    endif; 
                    ?>
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