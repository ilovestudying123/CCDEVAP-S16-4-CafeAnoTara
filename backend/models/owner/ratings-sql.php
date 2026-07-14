<?php
    require "../../../backend/config/connection.php";

    $cafe_id = 1; 
    $current_user_id = 2; 

    $cafe_sql = "SELECT cafe_name FROM Cafes WHERE cafe_id = '$cafe_id'";
    $cafe_result = $conn->query($cafe_sql);
    $cafe_row = $cafe_result->fetch_assoc();
    $cafe_name = $cafe_row ? $cafe_row['cafe_name'] : "Unknown Cafe";

    $filter_condition = "";
    $selected_star = isset($_GET['stars']) ? $_GET['stars'] : '';

    if (!empty($selected_star)) {
        if ($selected_star === "five") {
            $filter_condition = " AND r.rating = 5 ";
        } elseif ($selected_star === "four") {
            $filter_condition = " AND r.rating >= 4 ";
        } elseif ($selected_star === "three") {
            $filter_condition = " AND r.rating >= 3 ";
        } elseif ($selected_star === "two") {
            $filter_condition = " AND r.rating >= 2 ";
        } elseif ($selected_star === "one") {
            $filter_condition = " AND r.rating >= 1 ";
        }
    }

    $sort_order = " r.created_on DESC "; // Default sorting
    $selected_sort = isset($_GET['sort']) ? $_GET['sort'] : '';

    if (!empty($selected_sort)) {
        if ($selected_sort === "old") {
            $sort_order = " r.created_on ASC ";
        } else {
            $sort_order = " r.created_on DESC ";
        }
    }

    // Dynamic SQL Query using conditions
    $reviews_sql = "SELECT 
                        r.review_id,
                        r.rating,
                        r.comment,
                        r.owner_reply,
                        u.firstname,
                        u.lastname
                    FROM 
                        Reviews r
                    INNER JOIN 
                        Users u ON r.customer_id = u.user_id
                    WHERE 
                        r.cafe_id = '$cafe_id' 
                        $filter_condition
                    ORDER BY 
                        $sort_order"; 

    $reviews_result = $conn->query($reviews_sql);
?>

