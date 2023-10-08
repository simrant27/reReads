<?php
session_start();
include "../../References/connection.php";
include "../profile/deletebook.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../homepage/homepage.php");
    exit;
}

$book_id = null;
$button_label = 'Add to Favorites';

if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);

    $sql = "SELECT books.*, users.phoneNo, users.address
            FROM books
            INNER JOIN users ON books.user_id = users.user_id
            WHERE books.book_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        $book_id = $book["book_id"];
        $book_image = $book["images"];
        $booktitle = $book['book_name'];
        $author = $book['author'];
        $genre = $book['genre'];
        $publishedYear = $book['publishedYear'];
        $publisher = $book['publication'];
        $phoneNumber = $book['phoneNo'];
        $actualPrice = $book['actual_price'];
        $sellingPrice = $book['selling_price'];
        $address = $book['address'];
        $isDonate = $book['donate'];
    } else {
        echo "Failed to get book details";
    }

    // Check if the book is in the user's favorites
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $check_sql = "SELECT * FROM favourites WHERE user_id = ? AND book_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $user_id, $book_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $button_label = 'Remove from Favorites';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/singlePage/singlePage.css">
    <title>pagalbasti</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav>
    <?php include_once "../navbar/navbar.php"?>
</nav>

<div class="sale">
    <?php if ($isDonate) {?>
        <h3>Free</h3>
    <?php } else {?>
        <h3>Sale</h3>
    <?php }?>
</div>

<div class="photo">
    <h2 class="book-title"><?php echo $booktitle ?></h2>
    <div class="book-info">
        <div class="book-image">
            <img src="../../assets/uploads/<?php echo $book_image; ?>" alt="book photo" class="book_img"/>
        </div>

        <div class="book-details">
            <div class="book-description">
                <p><strong>Author:</strong><?php echo $author ?> </p>
                <p><strong>Genre:</strong> <?php echo $genre ?></p>
                <p><strong>Published:</strong> <?php echo $publishedYear ?></p>
                <p><strong>Publisher:</strong> <?php echo $publisher ?></p>
                <p><strong>Phone Number:</strong><?php echo $phoneNumber ?> </p>
                <?php if (!$isDonate) {?>
                    <p><strong>Price:</strong> <?php echo $actualPrice ?></p>
                <?php }?>
            </div>
            <?php
$email = $_SESSION['email'];
if ($email == "rereads3@gmail.com") {

    echo '<a href="../profile/deletebook.php?b_id=' . $book_id . '&source=singlepage class = "delete_button"">Delete';
} else {

    if (isset($_SESSION['email']) && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Check if the book is uploaded by the same user
        if ($user_id !== $book['user_id']) {
            // Only display the button if it's not the same user's book
            echo '<button id="addToFavorites" onclick="toggleFavorites(' . $book_id . ')">' . $button_label . '</button>';
        }
    }
}
?>



        </div>
    </div>

    <div class="book-price-location">
        <div class="book-price">
            <?php if (!$isDonate) {?>
                <span>Price: Rs.<?php echo $sellingPrice ?>/-</span>
            <?php }?>
        </div>

        <div class="book-location">
            <span>
                <a href="#"><i class="fa fa-map-marker"></i></a>
            </span>
            <span><?php echo $address ?></span>
        </div>
    </div>
</div>

<script src="/JS/Singlepage/single.js"></script>
<script>
    function toggleFavorites(bookId) {
        fetch('addToFavorites.php?book_id=' + bookId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const addToFavoritesButton = document.getElementById('addToFavorites');
                    if (data.message === 'Added to Favorites') {
                        addToFavoritesButton.textContent = 'Remove Favorites';
                    } else {
                        addToFavoritesButton.textContent = 'Add Favorites';
                    }
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>

</body>
</html>
