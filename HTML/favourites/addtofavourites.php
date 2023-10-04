<?php
session_start();
include "../../References/connection.php";

if (isset($_GET['book_id']) && isset($_SESSION['user_id'])) {
    $bookId = intval($_GET['book_id']);
    $userId = $_SESSION['user_id'];

    // Check if the book already exists in favorites to avoid duplicates
    $checkSql = "SELECT * FROM favorites WHERE user_id = ? AND book_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $userId, $bookId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows == 0) {
        // Book doesn't exist in favorites, insert it
        $insertSql = "INSERT INTO favorites (user_id, book_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ii", $userId, $bookId);

        if ($insertStmt->execute()) {
            // Redirect back to the page where the user clicked the button
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Failed to add book to favorites.";
        }
    } else {
        echo "Book already in favorites.";
    }
} else {
    echo "Unauthorized access.";
}
