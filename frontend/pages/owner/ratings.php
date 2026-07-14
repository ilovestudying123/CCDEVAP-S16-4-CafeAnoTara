<?php
    require "../../../backend/config/connection.php";

    $cafe_id = 1; 
    $current_user_id = 2; // Kept for your reporting logic

    // Fetch the cafe name dynamically
    $cafe_sql = "SELECT cafe_name FROM Cafes WHERE cafe_id = '$cafe_id'";
    $cafe_result = $conn->query($cafe_sql);
    $cafe_row = $cafe_result->fetch_assoc();
    $cafe_name = $cafe_row ? $cafe_row['cafe_name'] : "Unknown Cafe";

    // Fetch all reviews for this specific cafe
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
                    ORDER BY 
                        r.created_on DESC"; 

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
                    <label><input type="radio" name="stars" value="five">5 Stars</label> <br>
                    <label><input type="radio" name="stars" value="four">4 Stars & Up</label> <br>
                    <label><input type="radio" name="stars" value="three">3 Stars & Up</label> <br>
                    <label><input type="radio" name="stars" value="two">2 Stars & Up</label> <br>
                    <label><input type="radio" name="stars" value="one">1 Stars & Up</label> <br><br>
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
                    <label><input type="radio" name="newestOldest" value="new">Newest To Oldest</label> <br>
                    <label><input type="radio" name="oldestNewest" value="old">Oldest To Newest</label> <br> <br>
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
                                    <!-- 1. IF A REPLY EXISTS: Display using your external .saved-reply-box styles -->
                                    <div class="saved-reply-box">
                                        <p class="reply-label"><b>Your Response:</b></p>
                                        <p class="reply-content"><?php echo htmlspecialchars($review['owner_reply']); ?></p>
                                    </div>
                                <?php else: ?>
                                    <!-- 2. IF NO REPLY EXISTS: Form elements mapped via external CSS rules -->
                                    <form action="save_reply.php" method="POST">
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
                <p class="no-reviews">No reviews yet for this cafe.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>