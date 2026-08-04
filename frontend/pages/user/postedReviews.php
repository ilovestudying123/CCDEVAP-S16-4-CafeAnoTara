<?php
require '../../../backend/config/connection.php';
require_once '../authentication/auth.php';
require_once '../../../backend/controllers/reviewController.php';

$controller = new reviewController($conn);
$customer_id = $_SESSION['user_id'];
$reviews = $controller->getUserReviews($customer_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/user-reviews.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
   
</head>
<body>
    <!-- header -->
    <?php require "../../includes/header-user.php"; ?>
<section>
    <div class="reviews-header">
        <h1>My Reviews</h1>
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
                        <img src="<?php echo htmlspecialchars($review['main_image'] ?? '../../resources/imgs/cafe.jpg'); ?>">
                    </div>
                    <div class="review-text">
                        <p id="cafe-name"><?php echo htmlspecialchars($review['cafe_name']); ?></p>
                        <p>
                            <i class="fa-solid fa-star" style="color:gold;"></i>
                            <?php echo $review['rating']; ?>/5
                        </p>
                        <p><?php echo htmlspecialchars($review['comment']); ?></p>
                    </div>
                    <div class="review-icon">
                        <button class="btn" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button class="dropdown-item edit-btn"
                                        data-review-id="<?php echo $review['review_id']; ?>"
                                        data-rating="<?php echo $review['rating']; ?>"
                                        data-comment="<?php echo htmlspecialchars($review['comment']); ?>">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item text-danger delete-btn"
                                        data-review-id="<?php echo $review['review_id']; ?>">
                                    Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST"
                              action="postedReviews.php?action=update">
                            <input type="hidden" name="review_id" id="edit-review-id">
                            <div class="modal-header">
                                <h5>Edit Review</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <label>Rating</label>
                                <input type="number" name="rating" id="edit-rating" min="1" max="5" class="form-control">
                                <label class="mt-3">Comment</label>
                                <textarea name="comment" id="edit-comment" class="form-control"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST"
                              action="postedReviews.php?action=delete">
                            <input type="hidden" name="review_id" id="delete-review-id">
                            <div class="modal-body">Are you sure you want to delete this review?</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="../../resources/js/user-review.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>