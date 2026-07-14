<?php
require "../../../backend/config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_id = intval($_POST['review_id']);
    $owner_reply = trim($_POST['owner_reply']);

    $update_sql = "UPDATE Reviews SET owner_reply = ? WHERE review_id = ?";
    
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $owner_reply, $review_id);
    
    if ($stmt->execute()) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error saving your reply: " . $conn->error;
    }
}
?>