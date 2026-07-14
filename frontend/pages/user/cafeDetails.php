<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/user-cafeDetails.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="../../resources/js/cafe-array.js"></script>
    <script src="../../resources/js/cafe-details.js"></script>

    <div id="header"></div>
    <script src="../../resources/js/script-header-user.js"></script>
</head>
<body>
<!-- <section class="firstPart">
    <section>
        <div class="cafe">

            <div class="name-bookmark">
                <div class="cafe-name">
                    <h3 id="cafe-name">Cafe W</h3>
                    <p id="cafe-address">123 Main Street, Bonifacio Global City, Taguig City</p>
                </div>
                <div class="cafe-bookmark">
                    <button id="bookmark-button" type="button" onclick="bookmarkCafe()"><img id="bookmark" src ="../../resources/imgs/bookmark.png"></button>
                </div>
            </div>

            <div class="cafe-details">
                <div class="cafe-mainImg">
                    <img id="cafe-mainImage" src="../../resources/imgs/cafe.jpg" alt="Cafe 1">
                </div>
                <div class="cafe-description">
                    <p>Wifi speed: <span id="cafe-wifi"> 100Mbps</span> No. of outlets: <span id="cafe-outlets">8</span></p>
                    <p>Price range: <span id="cafe-price">$-$$</span> Noise Level: <span id="cafe-noise">Moderate</span></p>
                    <p>Opening hours: <span id="cafe-hours">7:30 am - 10:00 pm</span></p>
                    <div class = "desc-box">
                        <p id="cafe-desc-text">Description</p>
                    </div>
                </div>
            </div>
            
            <p>Additional Images:</p>
            <div class = "cafe-images">
                <div class="images"> <img class="additional-images" src="../../resources/imgs/cafe.jpg" alt="Cafe 1"> </div>
                <div class="images"> <img class="additional-images" src="../../resources/imgs/cafe.jpg" alt="Cafe 1"> </div>
                <div class="images"> <img class="additional-images" src="../../resources/imgs/cafe.jpg" alt="Cafe 1"> </div>
                <div class="images"> <img class="additional-images" src="../../resources/imgs/cafe.jpg" alt="Cafe 1"> </div>
            </div>

            <div id="cafeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" id="carousel-inner">
                   
                    <div class="carousel-item active">
                        <img id="cafe-mainImage" src="../../resources/imgs/cafe.jpg" class="carousel-img" alt="Main Image">
                    </div>
                    
                    <div class="carousel-item">
                        <img class="additional-images carousel-img" src="../../resources/imgs/cafe.jpg" alt="Additional 1">
                    </div>
                    <div class="carousel-item">
                        <img class="additional-images carousel-img" src="../../resources/imgs/cafe.jpg" alt="Additional 2">
                    </div>
                    <div class="carousel-item">
                        <img class="additional-images carousel-img" src="../../resources/imgs/cafe.jpg" alt="Additional 3">
                    </div>
                    <div class="carousel-item">
                        <img class="additional-images carousel-img" src="../../resources/imgs/cafe.jpg" alt="Additional 4">
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#cafeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#cafeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>


            <div class="cafe-info">
                <div class="cafe-description">
                    <p>Wifi speed: <span id="cafe-wifi">100Mbps</span>  <span>No. of outlets: <span id="cafe-outlets">8</span></p>
                    <p>Price range: <span id="cafe-price">$-$$</span>  <span>Noise Level: <span id="cafe-noise">Moderate</span></p>
                    <p>Opening hours: <span id="cafe-hours">7:30 am - 10:00 pm</span></p>
                </div>
                <div class="desc-box">
                    <p id="cafe-desc-text">Description</p>
                </div>
            </div>
        </div>
    </section>

    <section class="review">
        <h3>Post a Review</h3>
        <div class="add-review">
            <form action="/submit-form" method="POST">
                <p>
                    <textarea id="review" name="userReview">Add a Review</textarea>
                </p>
            </form>
        </div>
        
        <div class="submit-review">
            <div class="star-rating">
                <img id="stars" src ="../../resources/imgs/5stars.png">
            </div>
            <button id="submit" type="button" onclick="submitReview()">Submit</button>
        </div>
    </section>
</section>

<br><br><br>

<section>
    <div class="cafe-ratings">
        <h3>Ratings & Review</h3>
        <div class="star-buttons">
            <p><img id="star-big" src ="../../resources/imgs/star-shaded.png"> <span id="cafe-rating">3.6/5</span></p>

            <div class="buttons">
                <div class="filter">
                <div class="filter-button">
                    <button id="filter-button" onclick="toggleFilter()"><img id="filter-icon" src="../../resources/imgs/sliders-solid.png">Filter</button>
                    </div>
                    <div id="filter-options">
                    
                    <p>Wifi Speed:</p>
                    <label><input type="radio" name="wifi" value=""> All Wifi Speeds</label> <br>
                    <label><input type="radio" name="wifi" value="fast"> Fast Wifi</label> <br>
                    <label><input type="radio" name="wifi" value="slow"> Slow Wifi</label>
                    
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
                
            </div>
        </div>

        <div class="reviews-scroll">
            <div class="user-reviews">
                <div class="userName">
                    <p>CoffeeNomad21</p>
                </div>
                <div class="review-box">
                    <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.8/5 Fast WiFi, plenty of outlets, and great coffee. Perfect spot for remote work sessions.</p>
                </div>
            </div>

            <div class="user-reviews">
                <div class="userName">
                    <p>BrewLoverPH</p>
                </div>
                <div class="review-box">
                    <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.5/5 Cozy atmosphere and friendly staff. The cappuccino was excellent and reasonably priced.</p>
                </div>
            </div>

            <div class="user-reviews">
                <div class="userName">
                    <p>StudyBuddy88</p>
                </div>
                <div class="review-box">
                    <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.2/5 Quiet during the afternoon and ideal for studying. Wish there were a few more seats available.</p>
                </div>
            </div>

            <div class="user-reviews">
                <div class="userName">
                    <p>LatteExplorer</p>
                </div>
                <div class="review-box">
                    <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.7/5 The baristas really know their coffee. Tried their signature latte and loved every sip.</p>
                </div>
            </div>

            <div class="user-reviews">
                <div class="userName">
                    <p>PixelFreelancer</p>
                </div>
                <div class="review-box">
                    <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.0/5 Reliable internet and comfortable seating. It can get a bit noisy during peak hours.</p>
                </div>
            </div>

            <div class="user-reviews">
                <div class="userName">
                    <p>CaffeineHunter</p>
                </div>
                <div class="review-box">
                    <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.9/5 One of the best cafes I've visited. Great coffee quality, clean environment, and excellent service.</p>
                </div>
            </div>

            <div class="user-reviews">
                <div class="userName">
                    <p>NightOwl</p>
                </div>
                <div class="review-box">
                    <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.4/5 Stayed here for several hours working on a project. The staff never made me feel rushed.</p>
                </div>
            </div>

        </div>


    </div>
</section> -->

<section class="firstPart">

    <section class="cafe-section">
        <div class="cafe">
            <div class="name-bookmark">
                <div class="cafe-name">
                    <h3 id="cafe-name">Cafe W</h3>
                    <p id="cafe-address">123 Main Street, BGC, Taguig</p>
                </div>
                <div class="cafe-bookmark">
                    <button id="bookmark-button" type="button" onclick="bookmarkCafe()">
                        <img id="bookmark" src="../../resources/imgs/bookmark.png">
                    </button>
                </div>
            </div>

            <div id="cafeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img id="cafe-mainImage" src="../../resources/imgs/cafe.jpg" class="carousel-img" alt="Main">
                    </div>
                    <div class="carousel-item">
                        <img class="additional-images carousel-img" src="../../resources/imgs/cafe.jpg" alt="1">
                    </div>
                    <div class="carousel-item">
                        <img class="additional-images carousel-img" src="../../resources/imgs/cafe.jpg" alt="2">
                    </div>
                    <div class="carousel-item">
                        <img class="additional-images carousel-img" src="../../resources/imgs/cafe.jpg" alt="3">
                    </div>
                    <div class="carousel-item">
                        <img class="additional-images carousel-img" src="../../resources/imgs/cafe.jpg" alt="4">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#cafeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#cafeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

            <div class="cafe-info">
                <div class="cafe-description">
                    <p>Wifi speed: <span id="cafe-wifi">100Mbps</span> &nbsp; No. of outlets: <span id="cafe-outlets">8</span></p>
                    <p>Price range: <span id="cafe-price">$-$$</span> &nbsp; Noise Level: <span id="cafe-noise">Moderate</span></p>
                    <p>Opening hours: <span id="cafe-hours">7:30 am - 10:00 pm</span></p>
                </div>
                <div class="desc-box">
                    <p id="cafe-desc-text">Description</p>
                </div>
            </div>
        </div>
    </section>

    <section class="right-section">

        <div class="review">
            <h3>Post a Review</h3>
            <div class="add-review">
                <textarea id="review" name="userReview" placeholder="Add a Review"></textarea>
            </div>
            <div class="submit-review">
                <div class="star-rating" id="star-rating">
                    <i class="fa-regular fa-star" data-value="1"></i>
                    <i class="fa-regular fa-star" data-value="2"></i>
                    <i class="fa-regular fa-star" data-value="3"></i>
                    <i class="fa-regular fa-star" data-value="4"></i>
                    <i class="fa-regular fa-star" data-value="5"></i>
                </div>
                <button id="submit" type="button" onclick="submitReview()">Submit</button>
            </div>
        </div>

        <div class="cafe-ratings">
            <h3>Ratings & Review</h3>
            <div class="star-buttons">
                <p>
                    <img id="star-big" src="../../resources/imgs/star-shaded.png">
                    <span id="cafe-rating">3.6/5</span>
                </p>
                <div class="buttons">
                    <div class="filter">
                        <div class="filter-button">
                            <button id="filter-button" onclick="toggleFilter()">
                                <img id="filter-icon" src="../../resources/imgs/sliders-solid.png">Filter
                            </button>
                        </div>
                        <div id="filter-options">
                            <p>Wifi Speed:</p>
                            <label><input type="radio" name="wifi" value=""> All Wifi Speeds</label><br>
                            <label><input type="radio" name="wifi" value="fast"> Fast Wifi</label><br>
                            <label><input type="radio" name="wifi" value="slow"> Slow Wifi</label>
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
                            <img id="sort-icon" src="../../resources/imgs/sort-solid.png">Sort
                        </button>
                    </div>
                </div>
            </div>

            <div class="reviews-scroll">
                <div class="user-reviews">
                    <div class="userName">
                        <p>CoffeeNomad21</p>
                    </div>
                    <div class="review-box">
                        <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.8/5 Fast WiFi, plenty of outlets, and great coffee. Perfect spot for remote work sessions.</p>
                    </div>
                </div>

                <div class="user-reviews">
                    <div class="userName">
                        <p>BrewLoverPH</p>
                    </div>
                    <div class="review-box">
                        <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.5/5 Cozy atmosphere and friendly staff. The cappuccino was excellent and reasonably priced.</p>
                    </div>
                </div>

                <div class="user-reviews">
                    <div class="userName">
                        <p>StudyBuddy88</p>
                    </div>
                    <div class="review-box">
                        <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.2/5 Quiet during the afternoon and ideal for studying. Wish there were a few more seats available.</p>
                    </div>
                </div>

                <div class="user-reviews">
                    <div class="userName">
                        <p>LatteExplorer</p>
                    </div>
                    <div class="review-box">
                        <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.7/5 The baristas really know their coffee. Tried their signature latte and loved every sip.</p>
                    </div>
                </div>

                <div class="user-reviews">
                    <div class="userName">
                        <p>PixelFreelancer</p>
                    </div>
                    <div class="review-box">
                        <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.0/5 Reliable internet and comfortable seating. It can get a bit noisy during peak hours.</p>
                    </div>
                </div>

                <div class="user-reviews">
                    <div class="userName">
                        <p>CaffeineHunter</p>
                    </div>
                    <div class="review-box">
                        <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.9/5 One of the best cafes I've visited. Great coffee quality, clean environment, and excellent service.</p>
                    </div>
                </div>

                <div class="user-reviews">
                    <div class="userName">
                        <p>NightOwl</p>
                    </div>
                    <div class="review-box">
                        <p><img id="star-icon" src ="../../resources/imgs/star-shaded.png">4.4/5 Stayed here for several hours working on a project. The staff never made me feel rushed.</p>
                    </div>
                </div>

            </div>
        </div>

    </section>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>