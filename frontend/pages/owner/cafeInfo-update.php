<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css">
    <link rel="stylesheet" href="../../resources/css/cafeInfo-update.css?v=4">
    <?php require "../../../backend/models/owner/cafeInfo-update-sql.php"; ?>
    <title>Update Cafe Info</title>

    <div id="header"></div>
    <script src="../../resources/js/script-header-owner.js"></script>
</head>

<body>
    <form action="cafeInfo-update.php" method="POST">
        <div class="body-box">
            <h1 class="cafe-name"><?php echo htmlspecialchars($row['cafe_name']);?></h1>

            <button type="submit" id="save-btn" class="update-btn">Update</button>

            <section class="info-box">
                <div class="pic-column">
                    <img id="cafe-cover-preview" src="<?php echo htmlspecialchars($cover_photo); ?>" alt="Cafe Cover Photo">
                    
                    <input type="hidden" name="cover_photo_url" id="cover-photo-input" value="<?php echo $has_existing_cover ? htmlspecialchars($all_photos[0]['photo_url']) : ''; ?>">

                    <button type="button" id="change-cover-btn" class="form-btn cover-btn">Change Cover Photo</button>
                </div>

                <div class="info-column">
                    <button type="button" id="edit-photos-btn" class="form-btn edit-btn">Edit Photos</button>
                    
                    <?php for($i = 0; $i < 4; $i++): ?>
                        <input type="hidden" name="extra_photos[<?php echo $i; ?>]" id="extra-photo-<?php echo $i; ?>" value="<?php echo isset($extra_photos[$i]) ? htmlspecialchars($extra_photos[$i]['photo_url']) : ''; ?>">
                    <?php endfor; ?>

                    <div class="info-text">
                        <label class="header-text" for="wifi-speed">Wifi Speed:</label>
                        <input type="text" name="wifi_speed" id="input-wifi" class="form-btn" value="<?php echo htmlspecialchars($row['wifi_speed']); ?>">
                        <label class="header-text" for="outlet">Outlet Number:</label>
                        <input type="text" name="outlet_num" id="input-outlets" class="form-btn" value="<?php echo htmlspecialchars($row['outlet_num']); ?>">
                    </div>

                    <label class="header-text" for="operating-hrs">Operating Hours:</label>
                    <input type="text" name="operating_hours" id="input-hours" class="form-btn" value="<?php echo date('H:i', strtotime($row['opening_time'])) . ' - ' . date('H:i', strtotime($row['closing_time']));?>">
                    <label class="header-text" for="price">Price Range:</label>
                    <input type="text" name="price" id="input-price" class="form-btn" value="<?php echo htmlspecialchars($row['price']); ?>">
                </div>
            </section>
        </div>
    </form>

    <!-- IMG Modals -->
    <div id="coverModal" class="modal">
        <div class="modal-content">
            <h3>Edit Cover Photo</h3>
            <label>Cover Photo Link:</label>
            <input type="text" id="modal-cover-img">
            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="closeCoverModal">Cancel</button>
                <button type="button" class="btn-confirm" id="saveCoverModal">Done</button>
            </div>
        </div>
    </div>

    <div id="photoModal" class="modal">
        <div class="modal-content">
            <h3>Edit Cafe Photos</h3>
            <label>Photo Link 1:</label>
            <input type="text" id="modal-img-0">
            <label>Photo Link 2:</label>
            <input type="text" id="modal-img-1">
            <label>Photo Link 3:</label>
            <input type="text" id="modal-img-2">
            <label>Photo Link 4:</label>
            <input type="text" id="modal-img-3">
            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="closePhotoModal">Cancel</button>
                <button type="button" class="btn-confirm" id="savePhotoModal">Done</button>
            </div>
        </div>
    </div>
    
    <script src="../../resources/js/cafe-info.js"></script>
</body>
</html>