<?php
session_start();

include "../../References/connection.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: ../homepage/homepage.php");
    exit;
}

?>

<?php
// Check if the book_id parameter is set in the URL
if (isset($_GET['book_id'])) {
    // Sanitize and store the book ID
    $book_id = intval($_GET['book_id']); // Convert to integer for security
    // echo $book_id;

    $sql = "SELECT books.*, users.phoneNo,users.address
    FROM books
    INNER JOIN users ON books.user_id = users.user_id
    WHERE books.book_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();

        // Extract book details
        $book_image = $book["images"];
        $booktitle = $book['book_name'];
        $author = $book['author'];
        $genre = $book['genre'];
        // $language = $book['language'];
        $publishedYear = $book['publishedYear'];
        $publisher = $book['publication'];
        $phoneNumber = $book['phoneNo'];
        $actualPrice = $book['actual_price'];
        $sellingPrice = $book['selling_price'];
        $address = $book['address'];
        $isDonate = $book['donate'];

        // Now you can use these variables to display the book information in your HTML
    } else {
        echo ("failed to get book id");
    }

}

if (isset($_POST['addToFavorites'])) {
    // Check if the user is logged in

    // Get the book ID from the form submission
    $book_id = $_POST['book_id'];

    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Check if the book is already in the user's favorites
    $check_sql = "SELECT * FROM favourites WHERE user_id = ? AND book_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $book_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        // Book is not in favorites, so insert it
        $insert_sql = "INSERT INTO favourites (user_id, book_id) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $user_id, $book_id);
        $insert_stmt->execute();

    } else {
        $delete_sql = "DELETE FROM favourites WHERE user_id = ? AND book_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("ii", $user_id, $book_id);
        $delete_stmt->execute();

    }

} else {
    // Handle the case where the form was not submitted
    // echo "Form not submitted.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/singlePage/singlePage.css">
    <title>pagalbasti</title>


    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
</head>
<body>



    <div class="sale">
        <?php
if ($isDonate) {?>

    <h3>Free</h3>
    <?php
} else {?>
    <h3>Sale</h3>
    <?php

}
?>

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
                    <!-- <p><strong>Language:</strong></p> -->
                    <p><strong>Published:</strong> <?php echo $publishedYear ?></p>
                    <p><strong>Publisher:</strong> <?php echo $publisher ?></p>
                    <p><strong>Phone Number:</strong><?php echo $phoneNumber ?> </p>
                    <?php
if ($isDonate) {?>


<?php
} else {?>
                    <p><strong>Price:</strong> <?php echo $actualPrice ?></p>


    <?php
}
?>

                </div>
                            <form action="" method="post">
<input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
    <button id="addToFavorites" type="submit" name="addToFavorites">
    <?php if ($check_result->num_rows === 0): ?>

        Remove favourites
        <?php else: ?>
            Add to Favorites

        <?php endif;?>


    </button>


<!-- <?php echo $book_id ?> -->
            </div>
        </div>


        <div class="book-price-location">
            <div class="book-price">
                <?php
if ($isDonate) {?>


<?php
} else {?>
    <span>Price: Rs.<?php echo $sellingPrice ?>/-</span>

    <?php

}
?>
            </div>

            <div class="book-location">
                <span>
                <a href="#"><i class="fa fa-map-marker"></i></a>

                </span>
                <span>  <?php echo $address ?></span>
            </div>
        </div>
    </div>

    <script src="/JS/Singlepage/single.js"></script>
</body>
</html>
