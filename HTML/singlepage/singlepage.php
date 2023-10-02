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
        $isDonate = $book['address'];

        // Now you can use these variables to display the book information in your HTML
    } else {
        echo ("failed to get book id");
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
                    <p><strong>Actual Price:</strong> Rs.<?php echo $actualPrice ?>/-</p>


                </div>


                <button id="addToFavorites">Add to Favorites</button>
            </div>
        </div>


        <div class="book-price-location">
            <div class="book-price">
            <?php
if (!$isDonate) {?>

                <span>Price: Rs.<?php echo $sellingPrice ?>/-</span>

    <?php
} else {?>

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
