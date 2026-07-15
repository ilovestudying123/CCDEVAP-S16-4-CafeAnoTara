<?php
    require "../../../backend/config/connection.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_report'])) {
        $review_id = isset($_POST['review_id']) ? intval($_POST['review_id']) : 0;
        $reporter_id = isset($_POST['reporter_id']) ? intval($_POST['reporter_id']) : 0;
        $report_code = isset($_POST['report_code']) ? intval($_POST['report_code']) : 0;

        if ($review_id > 0 && $reporter_id > 0 && $report_code > 0) {
            $lookup_sql = "SELECT customer_id, cafe_id FROM Reviews WHERE review_id = ?";
            $stmt = $conn->prepare($lookup_sql);
            $stmt->bind_param("i", $review_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $review_data = $result->fetch_assoc();
            $stmt->close();

            if ($review_data) {
                $reported_user_id = $review_data['customer_id'];
                $reported_cafe_id = $review_data['cafe_id'];

                $insert_sql = "INSERT INTO Reports (reporter_id, reported_user_id, reported_cafe_id, reported_review_id, report_code) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("iiiii", $reporter_id, $reported_user_id, $reported_cafe_id, $review_id, $report_code);
                
                if ($insert_stmt->execute()) {
                    echo "<script>alert('Review reported successfully.'); window.location.href = window.location.pathname;</script>";
                    exit;
                } else {
                    echo "<script>alert('Database Error: Failed to log report.');</script>";
                }
                $insert_stmt->close();
            } else {
                echo "<script>alert('Error: Target review not found.');</script>";
            }
        } else {
            echo "<script>alert('Error: Missing required form fields.');</script>";
        }
    }

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

    $sort_order = " r.created_on DESC "; 
    $selected_sort = isset($_GET['sort']) ? $_GET['sort'] : '';

    if (!empty($selected_sort)) {
        if ($selected_sort === "old") {
            $sort_order = " r.created_on ASC ";
        } else {
            $sort_order = " r.created_on DESC ";
        }
    }

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