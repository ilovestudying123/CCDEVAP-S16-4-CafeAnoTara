<?php
class cafeModel {

// Get cafe from cafe table, join rating from review table, get average raiting, and group by cafe id
public function getCafeId ($conn, $cafe_id) {
    $stmt = mysqli_prepare ($conn,
        "SELECT c.*, AVG(r.rating) AS average_rating
        FROM Cafes c
        LEFT JOIN Reviews r ON c.cafe_id=r.cafe_id
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
        LEFT JOIN Reviews r ON c.cafe_id = r.cafe_id
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
        LEFT JOIN Reviews r ON c.cafe_id = r.cafe_id
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
        FROM Reviews r
        JOIN Users u ON r.customer_id = u.user_id
        WHERE r.cafe_id = ?
        ORDER BY r.created_on DESC"
    );
    mysqli_stmt_bind_param($stmt, "i", $cafe_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}

public function getCafeByOwnerId($conn, $owner_id) {
    $stmt = mysqli_prepare($conn,
        "SELECT 
            c.cafe_id,
            c.cafe_name,
            c.location,
            c.description,
            c.wifi_speed,
            c.opening_time,
            c.closing_time,
            c.price,
            c.outlet_num,
            IFNULL(ROUND(AVG(r.rating), 1), 0.0) AS average_rating,
            COUNT(r.review_id) AS total_reviews
        FROM Cafes c
        LEFT JOIN Reviews r ON c.cafe_id = r.cafe_id
        WHERE c.owner_id = ?
        GROUP BY c.cafe_id"
    );
    mysqli_stmt_bind_param($stmt, "i", $owner_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

public function getCafeImagesOrdered($conn, $cafe_id) {
    $stmt = mysqli_prepare($conn, 
        "SELECT photo_url FROM CafeIMG WHERE cafe_id = ? ORDER BY photo_id ASC"
    );
    mysqli_stmt_bind_param($stmt, "i", $cafe_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

public function getCafeById ($conn, $cafe_id) {
    $stmt = mysqli_prepare ($conn,
        "SELECT
            c.*,
            u.firstname,
            u.lastname,
            AVG(r.rating) AS average_rating,
            MIN(ci.photo_url) AS main_image,
            GROUP_CONCAT(ci.photo_url) AS images
        FROM Cafes c
        LEFT JOIN Users u
            ON c.owner_id = u.user_id
        LEFT JOIN Reviews r 
            ON c.cafe_id = r.cafe_id
        LEFT JOIN CafeIMG ci 
            ON c.cafe_id = ci.cafe_id
        WHERE c.cafe_id = ?
        GROUP BY c.cafe_id"
    );
    mysqli_stmt_bind_param($stmt, "i", $cafe_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cafe = mysqli_fetch_assoc($result);
        if ($cafe['images']) {
            $cafe['images'] = explode(",", $cafe['images']);
        } else {
            $cafe['images'] = [];
        }

        return $cafe;
}   

// retrieves cafes based on search, verification status, and sort order
public function getPendingCafes($conn, $search, $status, $sort) {
    $search = "%" . $search . "%";
    $sort = ($sort === "ASC") ? "ASC" : "DESC";

    $stmt = mysqli_prepare($conn,
        "SELECT
            c.*,
            u.firstname,
            u.lastname,
            MIN(ci.photo_url) AS main_image
        FROM Cafes c
        LEFT JOIN Users u
            ON c.owner_id = u.user_id
        LEFT JOIN CafeIMG ci
            ON c.cafe_id = ci.cafe_id
        WHERE c.is_verified = ?
            AND c.cafe_name LIKE ?
        GROUP BY c.cafe_id
        ORDER BY c.created_on $sort"
    );

    mysqli_stmt_bind_param($stmt, "is", $status, $search);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// retrieves all users with the owner role
public function getOwners($conn)
{
    $stmt = mysqli_prepare(
        $conn,
        "SELECT user_id, firstname, lastname
         FROM Users
         WHERE role = 'owner'
         ORDER BY firstname, lastname"
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// creates a new cafe record
public function createCafe($conn, $data)
{
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO Cafes
        (
            owner_id,
            cafe_name,
            location,
            description,
            wifi_speed,
            noise_level,
            outlet_num,
            opening_time,
            closing_time,
            price,
            is_verified
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "isssssissi",
        $data['owner_id'],
        $data['cafe_name'],
        $data['location'],
        $data['description'],
        $data['wifi_speed'],
        $data['noise_level'],
        $data['outlet_num'],
        $data['opening_time'],
        $data['closing_time'],
        $data['price']
    );

    // return the newly created cafe ID
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($conn);
    }

    return false;
}

// adds an image URL for a cafe
public function addCafeImage($conn, $cafe_id, $photo_url)
{
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO CafeIMG
        (cafe_id, photo_url)
        VALUES (?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "is",
        $cafe_id,
        $photo_url
    );

    return mysqli_stmt_execute($stmt);
}

// approves a cafe submission
public function approveCafe($conn, $cafe_id)
{
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE Cafes
         SET is_verified = 1
         WHERE cafe_id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $cafe_id);

    return mysqli_stmt_execute($stmt);
}

// rejects a cafe submission by deleting it
public function rejectCafe($conn, $cafe_id)
{
    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM Cafes
         WHERE cafe_id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $cafe_id);

    return mysqli_stmt_execute($stmt);
}   

}
?>