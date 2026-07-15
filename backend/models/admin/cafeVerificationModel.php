<?php
class CafeVerificationModel {

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

    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($conn);
    }

    return false;
}

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