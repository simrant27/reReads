<?php
session_start();

include "../../References/connection.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: ../homepage/homepage.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

// Fetch the user's information
$row = $result->fetch_assoc();
$user_name = $row['fullName'];
$email = $row['email'];
$profile_image = $row['user_img'];
$phoneNo = $row['phoneNo'];
$address = $row['address'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/singlePage/singlePage.css">
    <title>pagalbasti</title>

</head>
<body>
    <div class="container">

    </div>


    <div class="sale">
        <h3>Sale</h3>
    </div>

    <div class="photo">
        <h2 class="book-title">pagalbasti</h2>
        <div class="book-info">

            <div class="book-image">
                <img src="/assets/Pagal-basti.jpg" alt="pagalbasti">
            </div>


            <div class="book-details">

                <div class="book-description">
                    <p><strong>Author:</strong> Saru Bhakta</p>
                    <p><strong>Genre:</strong> Contemporary Fiction</p>
                    <p><strong>Language:</strong> Nepali</p>
                    <p><strong>Published:</strong> 2014</p>
                    <p><strong>Publisher:</strong> Sajha Prakashan</p>
                    <p><strong>Phone Number:</strong> 982-444-4456</p>
                    <p><strong>Actual Price:</strong> Rs.350/-</p>
                </div>


                <button id="addToFavorites">Add to Favorites</button>
            </div>
        </div>


        <div class="book-price-location">
            <div class="book-price">
                <span>Price: Rs.150/-</span>
            </div>

            <div class="book-location">
                <img src="/assets/Location_icon_from_Noun_Project.png" alt="location" class="location-icon">
                <span>Pokhara, Bagar</span>
            </div>
        </div>
    </div>

    <script src="/JS/Singlepage/single.js"></script>
</body>
</html>
