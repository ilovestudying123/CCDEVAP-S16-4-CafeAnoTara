<?php
    require "../../../backend/config/connection.php";

    $cafe_id = 1; 
    $current_user_id = 2; 

    $cafe_sql = "SELECT cafe_name FROM Cafes WHERE cafe_id = '$cafe_id'";
    $cafe_result = $conn->query($cafe_sql);
    $cafe_row = $cafe_result->fetch_assoc();
    $cafe_name = $cafe_row ? $cafe_row['cafe_name'] : "Unknown Cafe";

    $filter_condition = "";
    $selected_star = isset($_GET['stars']) ? $_GET['stars'] : '';

    if (!empty($selected_star)) {
        if ($selected_star === "five") {
            $filter_condition = " AND r.rating = 5 ";
        } elseif ($selected_star === "four") {
            $filter_condition = " AND r.rating >= 4 ";
        } elseif ($selected_star === "three") {
            $filter_condition = " AND r.rating >= 3 ";
        } elseif ($selected_star === "two") {
            $filter_condition = " AND r.rating >= 2 ";
        } elseif ($selected_star === "one") {
            $filter_condition = " AND r.rating >= 1 ";
        }
    }

    $sort_order = " r.created_on DESC "; // Default sorting
    $selected_sort = isset($_GET['sort']) ? $_GET['sort'] : '';

    if (!empty($selected_sort)) {
        if ($selected_sort === "old") {
            $sort_order = " r.created_on ASC ";
        } else {
            $sort_order = " r.created_on DESC ";
        }
    }

    // Dynamic SQL Query using conditions
    $reviews_sql = "SELECT 
                        r.review_id,
                        r.rating,
                        r.comment,
                        r.owner_reply,
                        u.firstname,
                        u.lastname
                    FROM 
                        Reviews r
                    INNER JOIN 
                        Users u ON r.customer_id = u.user_id
                    WHERE 
                        r.cafe_id = '$cafe_id' 
                        $filter_condition
                    ORDER BY 
                        $sort_order"; 

    $reviews_result = $conn->query($reviews_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($cafe_name); ?> - Ratings</title>
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/owner-ratings.css?v=4">

    <div id="header"></div>
    <script src="../../resources/js/script-header-owner.js"></script>
    <script src="../../resources/js/owner-ratings.js" defer></script>
</head>

<body>
    <div class="body-box">
        <h1 class="cafe-name"><?php echo htmlspecialchars($cafe_name); ?></h1>

        <div class="grid-btn">
            <!-- Filter Dropdown -->
            <div class="dropdown">
                <button id="filter-btn" class="filter-btn" onclick="toggleFilter()">
                    <img src="../../resources/imgs/sliders-solid.png" class="filter-img"> Filter
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

            <!-- Sort Dropdown -->
            <div class="dropdown">
                <button id="sort-btn" class="sort-btn" onclick="toggleSort()">
                    <img src="../../resources/imgs/sort-solid.png" class="sort-img"> Sort
                </button>
                <div id="dropdown-sort-options">
                    <p>Cafe Rating:</p>
                    <!-- Fixed radio button input mismatching name fields -->
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
                                        id="report-btn"
                                        data-review-id="<?php echo $review['review_id']; ?>" 
                                        data-reporter-id="<?php echo $current_user_id; ?>">
                                    Report
                                </button>
                            </div>
                            
                            <p class="rating"><span class="star">★</span> <?php echo number_format($review['rating'], 1); ?>/5</p>
                            <p class="review-body"><?php echo htmlspecialchars($review['comment']); ?></p>
                            
                            <!-- Reply Section -->
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
                <p class="no-reviews" style="text-align: center; font-weight: bold; padding: 20px;">No reviews found matching that criteria.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>