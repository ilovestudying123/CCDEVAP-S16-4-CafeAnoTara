<?php
require_once '../../../backend/controllers/user/cafeController.php';
require_once '../../../backend/controllers/user/bookmarkController.php';

$cafeCtrl = new cafeController($conn);
$cafe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($cafe_id === 0) {
    header('Location: dashboard.php');
    exit;
}

$data = $cafeCtrl->getCafeDetails($cafe_id);
$cafe = $data['cafe'];
$images = $data['images'];
$reviews = $data['reviews'];

if (!$cafe) {
    echo "Cafe not found.";
    exit;
}

$bookmarkCtrl = new bookmarkController($conn);
$customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 4;
$isBookmarked = $bookmarkCtrl->isBookmarked($customer_id, $cafe_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/user-cafeDetails.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <div id="header"></div>
    <script src="../../resources/js/script-header-user.js"></script>
</head>
<body>

<section class="firstPart">
    <section class="cafe-section">
        <div class="cafe">
            <div class="name-bookmark">
                <div class="cafe-name">
                    <h3><?php echo htmlspecialchars($cafe['cafe_name']); ?></h3>
                    <p><?php echo htmlspecialchars($cafe['location']); ?></p>
                </div>
                <div class="cafe-bookmark">
                    <form method="POST"
                          action="../../../backend/controllers/user/bookmarkController.php?action=<?php echo $isBookmarked ? 'remove' : 'add'; ?>"
                          onsubmit="return confirm('<?php echo $isBookmarked ? 'Remove bookmark?' : 'Bookmark this cafe?'; ?>');">
                        <input type="hidden" name="cafe_id" value="<?php echo $cafe['cafe_id']; ?>">
                        <button id="bookmark-button" type="submit">
                            <i class="fa-<?php echo $isBookmarked ? 'solid' : 'regular'; ?> fa-bookmark fa-2x"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Carousel -->
            <div id="cafeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php if (empty($images)): ?>
                        <div class="carousel-item active">
                            <img src="../../resources/imgs/cafe.jpg"
                                 class="carousel-img" alt="Cafe">
                        </div>
                    <?php else: ?>
                        <?php foreach ($images as $index => $img): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo htmlspecialchars($img['photo_url']); ?>"
                                     class="carousel-img" alt="Cafe Image">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button class="carousel-control-prev" type="button"
                        data-bs-target="#cafeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button"
                        data-bs-target="#cafeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

            <div class="cafe-info">
                <div class="cafe-description">
                    <p>Wifi speed: <span><?php echo htmlspecialchars($cafe['wifi_speed']); ?></span>
                       &nbsp; No. of outlets: <span><?php echo $cafe['outlet_num']; ?></span></p>
                    <p>Price range: <span><?php echo htmlspecialchars($cafe['price']); ?></span>
                       &nbsp; Noise Level: <span><?php echo htmlspecialchars($cafe['noise_level']); ?></span></p>
                    <p>Opening hours:
                       <span><?php echo $cafe['opening_time'] . ' - ' . $cafe['closing_time']; ?></span>
                    </p>
                </div>
                <div class="desc-box">
                    <p><?php echo htmlspecialchars($cafe['description']); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="right-section">
        <div class="review">
            <h3>Post a Review</h3>

            <?php if (isset($_SESSION['review_error'])): ?>
                <p style="color:red;"><?php echo $_SESSION['review_error']; unset($_SESSION['review_error']); ?></p>
            <?php endif; ?>

            <?php if (isset($_SESSION['bookmark_error'])): ?>
                <p style="color:red;"><?php echo $_SESSION['bookmark_error']; unset($_SESSION['bookmark_error']); ?></p>
            <?php endif; ?>

            <form method="POST"
                  action="../../../backend/controllers/user/reviewController.php?action=add">
                <input type="hidden" name="cafe_id" value="<?php echo $cafe['cafe_id']; ?>">
                <input type="hidden" name="rating" id="rating-value" value="0">
                <textarea name="comment" placeholder="Add a Review"></textarea>
                <div class="submit-review">
                    <div class="star-rating" id="star-rating">
                        <i class="fa-regular fa-star" data-value="1"></i>
                        <i class="fa-regular fa-star" data-value="2"></i>
                        <i class="fa-regular fa-star" data-value="3"></i>
                        <i class="fa-regular fa-star" data-value="4"></i>
                        <i class="fa-regular fa-star" data-value="5"></i>
                    </div>
                    <button id="submit" type="submit">Submit</button>
                </div>
            </form>
        </div>

        <div class="cafe-ratings">
            <h3>Ratings & Review</h3>
            <div class="star-buttons">
                <p>
                    <img id="star-big" src="../../resources/imgs/star-shaded.png">
                    <span><?php echo $cafe['average_rating']
                        ? number_format($cafe['average_rating'], 1) . '/5'
                        : 'No ratings yet'; ?></span>
                </p>
            </div>

            <div class="reviews-scroll">
                <?php if (empty($reviews)): ?>
                    <p>No reviews yet. Be the first to review!</p>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="user-reviews">
                            <div class="userName">
                                <p><?php echo htmlspecialchars($review['username']); ?></p>
                            </div>
                            <div class="review-box">
                                <p>
                                    <i class="fa-solid fa-star"></i>
                                    <?php echo $review['rating']; ?>/5
                                    <?php echo htmlspecialchars($review['comment']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../resources/js/cafe-details.js"></script>
</body>
</html>