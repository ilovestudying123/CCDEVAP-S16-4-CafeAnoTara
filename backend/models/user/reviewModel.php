<?php
class reviewModel {

    // add a new review
    public function addReview($conn, $customer_id, $cafe_id, $rating, $comment) {
        $stmt = mysqli_prepare($conn,
            "INSERT INTO Reviews (customer_id, cafe_id, rating, comment)
             VALUES (?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "iiis", $customer_id, $cafe_id, $rating, $comment);
        return mysqli_stmt_execute($stmt);
    }

    // check if user already reviewed this cafe
    public function hasReviewed($conn, $customer_id, $cafe_id) {
        $stmt = mysqli_prepare($conn,
            "SELECT review_id FROM Reviews
             WHERE customer_id = ? AND cafe_id = ?"
        );
        mysqli_stmt_bind_param($stmt, "ii", $customer_id, $cafe_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    // get all reviews by a specific user
    public function getUserReviews($conn, $customer_id) {
        $stmt = mysqli_prepare($conn,
            "SELECT r.*, c.cafe_name, c.location,
                    MIN(ci.photo_url) as main_image
             FROM Reviews r
             JOIN Cafes c ON r.cafe_id = c.cafe_id
             LEFT JOIN CafeIMG ci ON c.cafe_id = ci.cafe_id
             WHERE r.customer_id = ?
             GROUP BY r.review_id
             ORDER BY r.created_on DESC"
        );
        mysqli_stmt_bind_param($stmt, "i", $customer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // delete a review
    public function deleteReview($conn, $review_id, $customer_id) {
        // customer_id check ensures users can only delete their own reviews
        $stmt = mysqli_prepare($conn,
            "DELETE FROM Reviews
             WHERE review_id = ? AND customer_id = ?"
        );
        mysqli_stmt_bind_param($stmt, "ii", $review_id, $customer_id);
        return mysqli_stmt_execute($stmt);
    }

    // edit a review
    public function editReview($conn, $review_id, $customer_id, $rating, $comment) {
        $stmt = mysqli_prepare($conn,
            "UPDATE Reviews
             SET rating = ?, comment = ?
             WHERE review_id = ? AND customer_id = ?"
        );
        mysqli_stmt_bind_param($stmt, "isii", $rating, $comment, $review_id, $customer_id);
        return mysqli_stmt_execute($stmt);
    }

    //get a specific review by its ID
    public function getReviewById($conn, $review_id) {
    $stmt = mysqli_prepare($conn,
        "SELECT * FROM Reviews
         WHERE review_id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $review_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}
}
?>