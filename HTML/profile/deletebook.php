<?php

if (isset($_GET['b_id'])) {
    $book_id = intval($_GET['b_id']);
    $del_sql = "DELETE FROM books WHERE book_id = ?";
    $del_stmt = $conn->prepare($del_sql);
    $del_stmt->bind_param("i", $book_id);
    $del_stmt->execute();
    if ($del_stmt->execute()) {
        // Book deleted successfully
        // You can add a success message or redirect to a relevant page.
        header("Location: ./profile.php");
        exit;
    } else {
        // Handle the case where the deletion failed.
        echo "Error deleting book: " . $conn->error;
    }
    // if ($data) {
    //     echo "deleted";
    // } else {
    //     echo "not deleted";

    // }
}
