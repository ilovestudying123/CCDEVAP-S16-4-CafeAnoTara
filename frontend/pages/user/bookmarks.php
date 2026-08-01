<?php
require_once '../../../backend/controllers/user/bookmarkController.php';

$controller = new bookmarkController($conn);
$customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 4;
$bookmarks = $controller->getBookmarks($customer_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="../../resources/css/user-bookmark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div id="header"></div>
    <script src="../../resources/js/script-header-user.js"></script>
</head>
<body>
<section>
    <div class="bookmark-header">
        <h1>Your Bookmarked Cafes</h1>
    </div>

    <div class="bookmarked-cafes">
        <?php if (empty($bookmarks)): ?>
            <p>You have no bookmarked cafes yet.</p>
        <?php else: ?>
            <?php foreach ($bookmarks as $bookmark): ?>
            <div class="bookmark-card">
                <!-- button triggers modal, passes cafe_id via data attribute -->
                <button type="button" 
                        class="remove-bookmark"
                        data-bs-toggle="modal"
                        data-bs-target="#removeModal"
                        data-cafe-id="<?php echo $bookmark['cafe_id']; ?>">
                    <i class="fa-solid fa-bookmark fa-3x"></i>
                </button>

                <a href="cafeDetails.php?id=<?php echo $bookmark['cafe_id']; ?>"
                    class="cafe-details">
                        <div class="cafe-text">
                            <p class="cafe-name">
                                <?php echo htmlspecialchars($bookmark['cafe_name']); ?>
                                <i class="fa-solid fa-star"></i>
                                <?php echo $bookmark['average_rating']
                                    ? number_format($bookmark['average_rating'], 1) . '/5'
                                    : 'No ratings'; ?>
                            </p>
                            <p><?php echo htmlspecialchars($bookmark['location']); ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>

            <!-- modal -->
            <div class="modal fade" id="removeModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Remove Bookmark</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to remove this bookmark?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form method="POST" 
                                action="../../../backend/controllers/user/bookmarkController.php?action=remove">
                                <input type="hidden" name="cafe_id" id="modal-cafe-id" value="">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- fill cafe id when modal opens -->
<script>
    const removeModal = document.getElementById('removeModal');
    removeModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const cafeId = button.getAttribute('data-cafe-id');
        document.getElementById('modal-cafe-id').value = cafeId;
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>