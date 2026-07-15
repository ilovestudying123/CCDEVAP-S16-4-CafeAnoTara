<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/user-cafeDetails.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/js/cafe-array.js"></script>
    <script src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/js/cafe-details.js"></script>

    <div id="header"></div>
    <script src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/js/script-header-user.js"></script>
</head>
<body>

<section class="firstPart">

    <section class="cafe-section">
        <div class="cafe">
            <div class="name-bookmark">
                <div class="cafe-name">
                    <h3><?php echo $cafe['cafe_name']; ?></h3>
                    <p><?php echo $cafe['location']; ?></p>
                </div>
                <div class="cafe-bookmark">
                    <!-- bookmark form -->
                    <form method="POST" 
                          action="../../../backend/controllers/user/bookmarkController.php?action=add"
                          onsubmit="return confirm('Are you sure you want to bookmark this cafe?');">
                        <input type="hidden" name="cafe_id" 
                               value="<?php echo $cafe['cafe_id']; ?>">
                        <button id="bookmark-button" type="submit">
                            <i class="fa-solid fa-bookmark fa-2x"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Carousel -->
            <div id="cafeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php if (empty($images)): ?>
                        <div class="carousel-item active">
                            <img src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/cafe.jpg" 
                                 class="carousel-img" alt="Cafe">
                        </div>
                    <?php else: ?>
                        <?php foreach ($images as $index => $img): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/<?php echo $img['photo_url']; ?>" 
                                     class="carousel-img" 
                                     alt="Cafe Image">
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
                    <p>Wifi speed: <span><?php echo $cafe['wifi_speed']; ?></span>
                       &nbsp; No. of outlets: <span><?php echo $cafe['outlet_num']; ?></span></p>
                    <p>Price range: <span><?php echo $cafe['price']; ?></span>
                       &nbsp; Noise Level: <span><?php echo $cafe['noise_level']; ?></span></p>
                    <p>Opening hours: 
                       <span><?php echo $cafe['opening_time'] . ' - ' . $cafe['closing_time']; ?></span>
                    </p>
                </div>
                <div class="desc-box">
                    <p><?php echo $cafe['description']; ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="right-section">

        <!-- Post a Review -->
        <div class="review">
            <h3>Post a Review</h3>
                <textarea name="comment" placeholder="Add a Review"></textarea>
                <div class="submit-review">
                    <div class="star-rating" id="star-rating">
                        <i class="fa-regular fa-star" data-value="1"></i>
                        <i class="fa-regular fa-star" data-value="2"></i>
                        <i class="fa-regular fa-star" data-value="3"></i>
                        <i class="fa-regular fa-star" data-value="4"></i>
                        <i class="fa-regular fa-star" data-value="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="rating-value" value="0">
                    <button id="submit" type="submit">Submit</button>
                </div>
        </div>

        <!-- Ratings and Reviews -->
        <div class="cafe-ratings">
            <h3>Ratings & Review</h3>
            <div class="star-buttons">
                <p>
                    <img id="star-big" src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/star-shaded.png">
                    <span><?php echo $cafe['average_rating'] 
                        ? number_format($cafe['average_rating'], 1) . '/5' 
                        : 'No ratings yet'; ?></span>
                </p>
                <!-- <div class="buttons">
                    <div class="filter">
                        <div class="filter-button">
                            <button id="filter-button" onclick="toggleFilter()">
                                <img id="filter-icon" src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/sliders-solid.png">
                                Filter
                            </button>
                        </div>
                        <div id="filter-options">
                            <p>Wifi Speed:</p>
                            <label><input type="radio" name="wifi" value=""> All</label><br>
                            <label><input type="radio" name="wifi" value="fast"> Fast</label><br>
                            <label><input type="radio" name="wifi" value="slow"> Slow</label>
                            <p>Outlet Availability:</p>
                            <label><input type="checkbox" name="outlet" value="available"> Available</label><br>
                            <label><input type="checkbox" name="outlet" value="unavailable"> Unavailable</label>
                            <br><br>
                            <div class="filter-buttons">
                                <button type="button" onclick="applyFilter()">Apply</button>
                                <button type="button" onclick="clearFilter()">Clear</button>
                            </div>
                        </div>
                    </div>
                    <div class="sort-button">
                        <button id="sort-button" type="button" onclick="toggleSort()">
                            <img id="sort-icon" src="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/imgs/sort-solid.png">Sort
                        </button>
                    </div>
                </div> -->
            </div>

            <div class="reviews-scroll">
                <?php if (empty($reviews)): ?>
                    <p>No reviews yet. Be the first to review!</p>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="user-reviews">
                            <div class="userName">
                                <p><?php echo $review['username']; ?></p>
                            </div>
                            <div class="review-box">
                                <p>
                                      <i class="fa-solid fa-star"></i>
                                    <?php echo $review['rating']; ?>/5 
                                    <?php echo $review['comment']; ?>
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
</body>
</html>