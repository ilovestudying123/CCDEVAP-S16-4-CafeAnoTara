<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/user-reviews.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


    <div id="header"></div>
    <script src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/js/script-header-user.js"></script>
</head>
<body>
    <section>
        <div class="reviews-header">
            <h1>My Reviews</h1>
    
            <!-- <div class="buttons">
                <div class="filter">
                <div class="filter-button">
                    <button id="filter-button" onclick="toggleFilter()"><img id="filter-icon" src="../../resources/imgs/sliders-solid.png">Filter</button>
                    </div>
                    <div id="filter-options">
                    radio buttons for wifi speed
                    <p>Wifi Speed:</p>
                    <label><input type="radio" name="wifi" value=""> All Wifi Speeds</label> <br>
                    <label><input type="radio" name="wifi" value="fast"> Fast Wifi</label> <br>
                    <label><input type="radio" name="wifi" value="slow"> Slow Wifi</label>
                    
                     checkboxes for outlet availability
                    <p>Outlet Availability:</p>
                    <label><input type="checkbox" name="outlet" value="available"> Available</label> <br>
                    <label><input type="checkbox" name="outlet" value="unavailable"> Unavailable</label>
                    <br>
                    <br>

                     buttons for apply and clear filter 
                    <div class="filter-buttons">
                        <button type="button" onclick="applyFilter()">Apply</button>
                        <button type="button" onclick="clearFilter()">Clear</button>
                    </div>
                </div>
                </div>

                <div class="sort-button">
                <button id="sort-button" type="button" onclick="toggleSort()"><img id="sort-icon" src="../../resources/imgs/sort-solid.png">Sort</button>
                </div>
                
            </div> -->
            
        </div>
    </section>

    <section>
        <div class="posted-reviews">
        <?php if (empty($reviews)): ?>
            <p>You haven't posted any reviews yet.</p>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-box">
                    <div class="review-image">
                        <img src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/<?php echo $review['main_image']; ?>">
                    </div>
                    <div class="review-text">
                        <p id="cafe-name">
                            <?php echo htmlspecialchars($review['cafe_name']); ?>
                        </p>
                        <p>
                            <i class="fa-solid fa-star" style="color:gold;"></i>
                            <?php echo $review['rating']; ?>/5
                        </p>
                        <p>
                            <?php echo htmlspecialchars($review['comment']); ?>
                        </p>
                    </div>
                    <div class="review-icon">                      
                        <button class="btn" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button
                                    class="dropdown-item edit-btn"
                                    data-review-id="<?php echo $review['review_id']; ?>"
                                    data-rating="<?php echo $review['rating']; ?>"
                                    data-comment="<?php echo htmlspecialchars($review['comment']); ?>">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <button
                                    class="dropdown-item text-danger delete-btn"
                                    data-review-id="<?php echo $review['review_id']; ?>">
                                    Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- model for edit and delete mdoal -->
            <div class="modal fade" id="editModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/reviewController.php?action=update">
                            <input type="hidden" name="review_id" id="edit-review-id">
                            
                            <div class="modal-header">
                                <h5>Edit Review</h5>
                            </div>

                            <div class="modal-body">
                                <label>Rating</label>
                                <input type="number" name="rating" id="edit-rating" min="1" max="5" class="form-control">
                                <label class="mt-3">Comment</label>
                                <textarea name="comment"  id="edit-comment" class="form-control"></textarea>

                            </div>

                            <div class="modal-footer">
                                <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/reviewController.php?action=delete">
                            <input type="hidden" name="review_id" id="delete-review-id">
                            <div class="modal-body">
                                Delete this review?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button class="btn btn-danger" type="submit">
                                    Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif; ?>
        </div>
    </section>

    <script src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/js/user-review.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>