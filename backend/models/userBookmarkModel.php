<?php
class bookmarkModel {

public function getUserBookmarks ($conn, $customer_id) {
    $stmt = mysqli_prepare ($conn, 
        "SELECT b.created_on, c.cafe_id, c.cafe_name, c.location, AVG(r.rating) as average_rating,
            MIN(ci.photo_url) as main_image
        FROM Bookmarks b
        JOIN Cafes c ON b.cafe_id = c.cafe_id
        LEFT JOIN Reviews r ON c.cafe_id = r.cafe_id
        LEFT JOIN CafeIMG ci ON c.cafe_id = ci.cafe_id
        WHERE b.customer_id = ?
        GROUP BY c.cafe_id"
    );
    mysqli_stmt_bind_param($stmt, "i", $customer_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

public function addBookmark ($conn, $customer_id, $cafe_id) {
    $stmt = mysqli_prepare ($conn, 
        "INSERT INTO Bookmarks (customer_id, cafe_id) VALUES (?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "ii", $customer_id, $cafe_id);
    return mysqli_stmt_execute($stmt);
}

public function removeBookmark ($conn, $customer_id, $cafe_id) {
    $stmt = mysqli_prepare ($conn, 
        "DELETE FROM Bookmarks WHERE customer_id = ? AND cafe_id = ?"
    );
    mysqli_stmt_bind_param($stmt, "ii", $customer_id, $cafe_id);
    return mysqli_stmt_execute($stmt);
}

}