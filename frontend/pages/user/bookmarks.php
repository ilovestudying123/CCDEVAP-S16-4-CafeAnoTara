<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/user-bookmark.css">

    <div id="header"></div>
    <script src="../../resources/js/script-header-user.js"></script>
</head>
<body>
    <section>
        <div class="bookmark-header">
            <h1>Your Bookmarked Cafes</h1>
            <div class="buttons">
                <div class="filter">
                    <div class="filter-button">
                        <button id="filter-button" onclick="toggleFilter()">
                            <img id="filter-icon" src="../../resources/imgs/sliders-solid.png">Filter
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
                        <img id="sort-icon" src="../../resources/imgs/sort-solid.png">Sort
                    </button>
                </div>
            </div>
        </div>

        <div class="bookmarked-cafes">
            <?php if (empty($bookmarks)): ?>
                <p>You have no bookmarked cafes yet.</p>

            <?php else: ?>
                <?php foreach ($bookmarks as $bookmark): ?>
                    <div class="bookmark-card">
                        <img class="bookmark-icon" src="../../resources/imgs/bookmark.png">

                        <a href="../../../backend/controllers/CafeController.php?action=cafeDetails&id=<?php echo $bookmark['cafe_id']; ?>"
                        class="cafe-details">
                            <div class="cafe-text">
                                <p class="cafe-name">
                                    <?php echo $bookmark['cafe_name']; ?>
                                    <img class="stars" src="../../resources/imgs/5stars.png">
                                </p>
                                <p><?php echo $bookmark['location']; ?></p>
                            </div>
                            <div class="circle"></div>
                        </a>

                        <!-- remove bookmark button -->
                        <form method="POST" 
                            action="../../../backend/controllers/BookmarkController.php?action=remove">
                            <input type="hidden" name="cafe_id" 
                                value="<?php echo $bookmark['cafe_id']; ?>">
                            <button type="submit" class="remove-bookmark">✕</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</body>
</html>