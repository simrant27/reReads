<?php
session_start();
include_once "../../References/connection.php";

// Function to fetch books for a specific user
function fetchBooksForUser($conn, $userId)
{
    $books = array();
    // Query to fetch books for the user
    $query = "SELECT
                books.images AS image_book,
                books.book_name AS book_name,
                books.book_id AS book_id
            FROM
                books
            WHERE
                books.user_id = $userId
            ORDER BY
                 books.book_id DESC;
            ";

    $result = $conn->query($query);

    if ($result) {
        $count = $result->num_rows; // Count the number of books
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    return array($books, $count);
}

// Check if the user_id parameter is set in the URL
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    // Fetch books for the specified user
    list($books, $count) = fetchBooksForUser($conn, $userId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../CSS/admin/users.css">
  <title>Books</title>
</head>
<body>
    <div class="popup-content">
    <?php foreach ($books as $book): ?>
        <!-- Book details container -->
       <div class="book-details-container" id="book-details-<?php echo $user['user_id']; ?>">

        <ul>
            <li>
                <div class="book-user">
                    <img src="../../assets/uploads/<?php echo $book['image_book']; ?>" alt="<?php echo $book['book_name']; ?>">
                </div>
                <div class="book-details">
                    <a href="../singlepage/singlepage.php?book_id=<?php echo $book['book_id']; ?>">
                        <span class="book-name"><?php echo $book['book_name']; ?></span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <?php endforeach; ?>
    </div>
</body>
</html>
