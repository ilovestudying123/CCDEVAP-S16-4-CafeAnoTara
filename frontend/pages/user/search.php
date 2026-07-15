<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/user-search.css">

    <div id="header"></div>
    <script src="../../resources/js/script-header-user.js"></script>
</head>
<body>
   <div class="search-filter-sort">
    <section class="search-section">
        <form method="GET" action="../../../backend/controllers/CafeController.php">
            <input type="hidden" name="action" value="search">
            <div class="search">
                <input type="search" name="name" 
                       placeholder="Search..." 
                       value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
                <button type="submit">
                    <img id="search-icon" src="../../resources/imgs/magnifying-glass-solid.png">
                </button>
            </div>
        </form>
    </section>
    </div>


        <section class="filter-section">
        <div class="filter">
            <div class="filter-button">
                <button id="filter-button" onclick="toggleFilter()"><img id="filter-icon" src="../../resources/imgs/sliders-solid.png">Filter</button>
                </div>
            <div id="filter-options">
                <!-- radio buttons for wifi speed -->
                <p>Wifi Speed:</p>
                <label><input type="radio" name="wifi" value=""> All Wifi Speeds</label> <br>
                <label><input type="radio" name="wifi" value="fast"> Fast Wifi</label> <br>
                <label><input type="radio" name="wifi" value="slow"> Slow Wifi</label>
                
                <!-- checkboxes for outlet availability -->
                <p>Outlet Availability:</p>
                <label><input type="checkbox" name="outlet" value="available"> Available</label> <br>
                <label><input type="checkbox" name="outlet" value="unavailable"> Unavailable</label>
                <br>
                <br>

                <!-- buttons for apply and clear filter -->
                <div class="filter-buttons">
                    <button type="button" onclick="applyFilter()">Apply</button>
                    <button type="button" onclick="clearFilter()">Clear</button>
                </div>
            </div>
        </div>
        </section>

        <!-- button for sort -->
        <section class="sort-section">
        <div class="sort-button">
            <button id="sort-button" type="button" onclick="toggleSort()"><img id="sort-icon" src="../../resources/imgs/sort-solid.png">Sort</button>
        </div>
    </div>
    </section>

    <section class="cafe-listings">
        <h2>Cafe Listings</h2>

        <?php if (empty($results) && isset($_GET['name'])): ?>
            <p>No cafes found matching "<?php echo htmlspecialchars($_GET['name']); ?>".</p>

        <?php elseif (!empty($results)): ?>
            <?php foreach ($results as $cafe): ?>
                <a href="../../../backend/controllers/CafeController.php?action=cafeDetails&id=<?php echo $cafe['cafe_id']; ?>"
                class="cafe-listing-item">
                    <div class="cafe-listing-info">
                        <span class="cafe-listing-name"><?php echo $cafe['cafe_name']; ?></span>
                        <span class="cafe-listing-rating">
                            <img class="star-icon" src="../../resources/imgs/star-shaded.png">
                            <?php echo $cafe['average_rating'] 
                                ? number_format($cafe['average_rating'], 1) . '/5' 
                                : 'No ratings'; ?>
                        </span>
                    </div>
                    <span class="cafe-listing-address"><?php echo $cafe['location']; ?></span>
                </a>
            <?php endforeach; ?>

        <?php else: ?>
            <p>Enter a cafe name to search.</p>
        <?php endif; ?>
    </section>

</body>
</html>