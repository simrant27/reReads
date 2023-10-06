<?php
session_start();

include "../../References/connection.php";

$response = array();

if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        $response['error'] = 'User not logged in';
    } else {
        $user_id = $_SESSION['user_id'];

        // Check if the book is already in the user's favorites
        $check_sql = "SELECT * FROM favourites WHERE user_id = ? AND book_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $user_id, $book_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows === 0) {
            // Check if the book is uploaded by the user
            $check_uploaded_sql = "SELECT * FROM books WHERE user_id = ? AND book_id = ?";
            $check_uploaded_stmt = $conn->prepare($check_uploaded_sql);
            $check_uploaded_stmt->bind_param("ii", $user_id, $book_id);
            $check_uploaded_stmt->execute();
            $check_uploaded_result = $check_uploaded_stmt->get_result();

            if ($check_uploaded_result->num_rows === 0) {
                // Book is not uploaded by the user, so insert it into favorites
                $insert_sql = "INSERT INTO favourites (user_id, book_id) VALUES (?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("ii", $user_id, $book_id);
                if ($insert_stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Added to Favorites';
                } else {
                    $response['error'] = 'Failed to add to Favorites';
                }
            } else {
                $response['error'] = 'Cannot add your own book to Favorites';
            }
        } else {
            // Book is in favorites, so remove it
            $delete_sql = "DELETE FROM favourites WHERE user_id = ? AND book_id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("ii", $user_id, $book_id);
            if ($delete_stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Removed from Favorites';
            } else {
                $response['error'] = 'Failed to remove from Favorites';
            }
        }
    }
} else {
    $response['error'] = 'Invalid request';
}

header('Content-Type: application/json');
echo json_encode($response);
