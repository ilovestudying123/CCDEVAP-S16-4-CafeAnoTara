<?php
class cafeModel {

// Get cafe from cafe table, join rating from review table, get average raiting, and group by cafe id
public function getCafeId ($conn, $cafe_id) {
    $stmt = mysqli_prepare ($conn,
        "SELECT c.*, AVG(r.rating) AS average_rating
        FROM Cafes c
        LEFT JOIN Review r ON c.cafe_id=r.cafe_id
        WHERE c.cafe_id = ?
        GROUP BY c.cafe_id"
    );
    mysqli_stmt_bind_param($stmt, "i", $cafe_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// get cafe images from cafeimg table
public function getCafeImages ($conn, $cafe_id) {
    $stmt = mysqli_prepare ($conn, 
        "SELECT photo_url FROM CafeIMG WHERE cafe_id = ?"
    );
    mysqli_stmt_bind_param($stmt, "i", $cafe_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

public function getTopCafes ($conn, $limit = 4) {
    $stmt = mysqli_prepare ($conn, 
        "SELECT c.*, AVG(r.rating) as average_rating,
            MIN(ci.photo_url) as main_image
        FROM Cafes c
        LEFT JOIN Review r ON c.cafe_id = r.cafe_id
        LEFT JOIN CafeIMG ci ON c.cafe_id = ci.cafe_id
        WHERE c.is_verified = TRUE
        GROUP BY c.cafe_id
        ORDER BY average_rating DESC
        LIMIT ?"
    );
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

public function searchCafe ($conn, $name) {
    $stmt = mysqli_prepare ($conn, 
        "SELECT c.*, AVG(r.rating) as average_rating,
            MIN(ci.photo_url) as main_image
        FROM Cafes c
        LEFT JOIN Review r ON c.cafe_id = r.cafe_id
        LEFT JOIN CafeIMG ci ON c.cafe_id = ci.cafe_id
        WHERE c.cafe_name = ? AND c.is_verified = TRUE
        GROUP BY c.cafe_id"
    );
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

public function getCafeReviews ($conn, $cafe_id) {
    $stmt = mysqli_prepare ($conn, 
        "SELECT r.*, u.username
        FROM Review r
        JOIN Users u ON r.user_id = u.user_id
        WHERE r.cafe_id = ?
        ORDER BY r.created_on DESC"
    );
    mysqli_stmt_bind_param($stmt, "i", $cafe_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}
?>