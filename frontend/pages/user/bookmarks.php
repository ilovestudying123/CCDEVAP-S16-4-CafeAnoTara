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
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/header-style.css?v=2">
    <link rel="stylesheet" href="/CCDEVAP-S16-4-CafeAnoTara/frontend/resources/css/user-bookmark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<!-- header -->
<?php require "../../includes/header-user.php"; ?>

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
                    <form method="POST"
                          action="/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/bookmarkController.php?action=remove"
                          onsubmit="return confirm('Remove this bookmark?');">
                        <input type="hidden" name="cafe_id" value="<?php echo $bookmark['cafe_id']; ?>">
                        <button type="submit" class="remove-bookmark" id="bookmark-button">
                            <i class="fa-solid fa-bookmark fa-3x"></i>
                        </button>
                    </form>

                    <a href="/CCDEVAP-S16-4-CafeAnoTara/frontend/pages/user/cafeDetails.php?id=<?php echo $bookmark['cafe_id']; ?>"
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
        <?php endif; ?>
    </div>
</section>
</body>
</html>