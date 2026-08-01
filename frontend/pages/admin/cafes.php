<?php
// database connection and cafe controller
require_once "../../../backend/config/connection.php";
require_once "../../../backend/controllers/admin/cafe-verification.php";

// retrieve search, filter, and sort values from the URL
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? 0;
$sort = $_GET['sort'] ?? 'DESC';

// load cafe records and owner list
$cafeController = new CafeVerificationController($conn);
$pendingCafes = $cafeController->getPendingCafes($search, $status, $sort);

$owners = $cafeController->getOwners();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cafe Verification</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/admin-cafes.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css"/>
    <script src="../../resources/js/cafe-verification.js"></script>
</head>

<body>
    <!-- header -->
    <?php require "../../includes/header-admin.php"; ?>

    <div class="body-box">
        <div class="search-section">
            <h1>Cafe Verification</h1>
                <form method="GET" class="search-box">
                    <div class="search-input">
                        <img src="../../resources/imgs/magnifying-glass-solid.png" alt="search icon">
                        <input type="search" id="search-input" name="search" placeholder="Enter cafe" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>

                    <button type="submit">Search</button>

                    <div class="filter">
                        <button type="button" id="filter-button" onclick="toggleFilter()">
                        <img src="../../resources/imgs/sliders-solid.png" class="sort-icon">Filter</button>

                        <div id="filter-options">
                            <p>Status:</p>
                            <label>
                                <input type="radio" name="status" value="0" <?= (($_GET['status'] ?? '0') == '0') ? 'checked' : '' ?>>Pending
                            </label>

                            <label>
                                <input type="radio" name="status" value="1" <?= (($_GET['status'] ?? '') == '1') ? 'checked' : '' ?>>Approved
                            </label>
                            <div class="filter-buttons">
                                <button type="submit">Apply</button>
                                <button type="button" onclick="window.location='cafes.php'">Clear</button>
                            </div>
                        </div>
                    </div>

                    <div class="sort">
                        <button type="button" id="sort-button" onclick="toggleSort()">
                            <img src="../../resources/imgs/sort-solid.png" class="sort-icon">Sort</button>

                        <div id="sort-options">
                            <p>Sort by:</p>
                            <label><input type="radio" name="sort" value="DESC" <?= (($_GET['sort'] ?? 'DESC') == 'DESC') ? 'checked' : '' ?>>Newest To Oldest</label><br>
                            <label><input type="radio" name="sort" value="ASC" <?= (($_GET['sort'] ?? '') == 'ASC') ? 'checked' : '' ?>>Oldest To Newest</label>

                            <div class="filter-buttons">
                                <button type="submit">Apply</button>
                                <button type="button" onclick="window.location='cafes.php'">Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            <button class="add-btn" onclick="openCreateModal()">Add Cafe</button>
        </div>

        <div class="card-holder">
            <?php 
            if ($pendingCafes) {
            foreach ($pendingCafes as $cafe): ?>
                <section id="cafe-<?= $cafe['cafe_id'] ?>" class="cafe-card">
                    <div class="cafe-info">
                        <img src="<?= htmlspecialchars($cafe['main_image']) ?>" alt="<?= htmlspecialchars($cafe['cafe_name']) ?>">

                        <div class="cafe-details">
                            <h1><?= htmlspecialchars($cafe['cafe_name']) ?></h1>
                            <p><?= htmlspecialchars($cafe['firstname'] . ' ' . $cafe['lastname']) ?></p>
                            <p><br></p>
                            <p><?= htmlspecialchars($cafe['location']) ?></p>
                        </div>
                    </div>

                    <!-- determine the status badge style and text -->
                    <?php $statusClass = ($cafe['is_verified'] == 1) ? "approved" : "pending";
                          $statusText = ($cafe['is_verified'] == 1) ? "Approved" : "Pending";?>

                    <div>
                        <span
                            id="status-<?= $cafe['cafe_id'] ?>"
                            class="status <?= $statusClass ?>">
                            <?= $statusText ?>
                        </span>
                    </div>

                    <div class="button-holder">
                            <button class="reject-btn" onclick="rejectCafe(<?= $cafe['cafe_id'] ?>)">Reject</button>
                        <?php if ($cafe['is_verified'] == 0): ?>
                            <button class="approve-btn" onclick="approveCafe(<?= $cafe['cafe_id'] ?>)">Approve</button>
                        <?php endif; ?>
                            <button class="view-btn"onclick="openCafe(<?= $cafe['cafe_id'] ?>)">View</button>
                    </div>
                </section>
            <?php endforeach; }
            else { ?>
                <div class="no-record">
                    <p>No cafes to verify</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-body">
                <!-- Left Column -->
                <div class="info-box">
                    <h1 id="cafe-name" class="cafe-name"></h1>
                    <p id="cafe-owner" class="desc-text"></p><br>
                    <p id="cafe-address" class="desc-text"></p>
                    <p id="cafe-desc-text" class="desc-text"></p>
                    <div class="info-column">
                        <div>
                            <p class="header-text">WiFi Speed</p>
                            <p id="cafe-wifi" class="desc-text"></p>
                        </div>

                        <div>
                            <p class="header-text">Operating Hours</p>
                            <p id="cafe-hours" class="desc-text"></p>
                        </div>

                        <div>
                            <p class="header-text">Price Range</p>
                            <p id="cafe-price" class="desc-text"></p>
                        </div>

                        <div>
                            <p class="header-text">Power Outlets</p>
                            <p id="cafe-outlets" class="desc-text"></p>
                        </div>

                        <div>
                            <p class="header-text">Noise Level</p>
                            <p id="cafe-noise" class="desc-text"></p>
                        </div>

                        <div>
                            <p class="header-text">Rating</p>
                            <p id="cafe-rating" class="desc-text"></p>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="image-section">
                    <!-- Large image -->
                    <img id="cafe-mainImage" class="main-image" alt="Cafe Image">
                    <!-- Thumbnails -->
                    <div class="thumbnail-container">
                        <img class="gallery-thumbnail">
                        <img class="gallery-thumbnail">
                        <img class="gallery-thumbnail">
                        <img class="gallery-thumbnail">
                        <img class="gallery-thumbnail">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createModal" class="modal">
        <div class="create-modal-content">
            <span class="close" onclick="closeCreateModal()">&times;</span>
            <h2>Add Cafe</h2>
            <form class="create-form" action="../../../backend/controllers/admin/cafe-create.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="field">
                        <label for="create-name">Cafe Name</label>
                        <input type="text" id="create-name" name="cafe_name" placeholder="Cafe Name" required>
                    </div>

                    <div class="field">
                        <label>Owner</label>
                        <select name="owner_id" required>
                            <option value="">Select Owner</option>
                            <?php foreach($owners as $owner): ?>
                                <option value="<?= $owner['user_id'] ?>"><?= htmlspecialchars($owner['firstname'] . ' ' . $owner['lastname']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div><br>

                <div class="field">
                    <label for="create-address">Address</label>
                    <input type="text" id="create-address" name="location" placeholder="Address" required>
                </div><br>

                <div class="field">
                    <label for="create-description">Description</label>
                    <textarea id="create-description" name="description" rows="3" placeholder="Description"></textarea>
                </div><br>

                <div class="row">
                    <div class="field">
                        <label for="create-wifi">WiFi Speed</label>
                        <input type="text" id="create-wifi" name="wifi_speed" placeholder="100 Mbps">
                    </div>

                    <div class="field">
                        <label for="create-opening">Opening Time</label>
                        <input type="time" id="create-opening" name="opening_time">
                    </div>

                    <div class="field">
                        <label for="create-closing">Closing Time</label>
                        <input type="time" id="create-closing" name="closing_time">
                    </div>
                </div><br>

                <div class="row">
                    <div class="field">
                        <label for="create-price">Average Price</label>
                        <input type="number" id="create-price" name="price" placeholder="Average Price">
                    </div>

                    <div class="field">
                        <label for="create-outlets">Power Outlets</label>
                        <input type="number" id="create-outlets" name="outlet_num" placeholder="10">
                    </div>
  
                    <div class="field">
                        <label for="create-noise">Noise Level</label>
                        <select id="create-noise" name="noise_level">
                            <option value="">Select</option>
                            <option>Quiet</option>
                            <option>Moderate</option>
                            <option>Loud</option>
                        </select>
                    </div>
                </div><br>

                <!-- <div class="field">
                    <label for="create-image">Cafe Image</label>
                    <input type="file" id="create-image" name="cafe_images[]" accept="image/*" multiple>
                </div> -->

                <div class="row">
                    <div class="field">
                        <label>Image URL 1</label>
                        <input type="url" name="cafe_images[]" placeholder="Image Link">
                    </div>

                    <div class="field">
                        <label>Image URL 2</label>
                        <input type="url" name="cafe_images[]" placeholder="Image Link">
                    </div>
                </div><br>

                <div class="row">
                    <div class="field">
                        <label>Image URL 3</label>
                        <input type="url" name="cafe_images[]" placeholder="Image Link">
                    </div>

                    <div class="field">
                        <label>Image URL 4</label>
                        <input type="url" name="cafe_images[]" placeholder="Image Link">
                    </div>

                    <div class="field">
                        <label>Image URL 5</label>
                        <input type="url" name="cafe_images[]" placeholder="Image Link">    
                    </div>
                </div>

                <div class="button-container">
                    <button type="submit" class="submit-btn">Submit</button>
                </div>
            </form>
        </div>  
    </div>
</body>