<?php
session_start();
include "../../References/connection.php";

// Check if the user is logged in
if (isset($_SESSION['email']) && isset($_SESSION['user_id'])) {
    // Get the user's name from the database based on the user_id
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT fullName,user_img FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $user_name = $row['fullName'];
        $profile_image = $row['user_img'];

    }
}

// Logout process
if (isset($_GET['logout'])) {
    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: ../../HTML/loginSignup/login.php");
    exit;
}

//fetching data from the table books
$sell_sql = "SELECT * FROM books WHERE donate =0 ORDER BY book_id DESC ";
$sell_result = $conn->query($sell_sql);

$donate_sql = "SELECT * FROM books WHERE donate =1 ORDER BY book_id DESC ";
$donate_result = $conn->query($donate_sql);

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../CSS/homepage/homepage.css" />
    <!-- <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    /> -->
    <title>HomePage</title>
  </head>
  <body>
    <nav class="navbar">
      <?php
include "../navbar/navbar.php";
?>
    </nav>
    <section class="booklist">
      <?php while ($row = $sell_result->fetch_assoc()) {?>


      <div class="singlebook">

        <img src="../../assets/uploads/<?php echo $row['images']; ?>" alt="book photo" />


        <span class="bookname"><?php echo $row['book_name']; ?></span>
        <span class="bookprice">Rs.<?php echo $row['selling_price']; ?></span>
        <span class="location">
          <a href="#"><i class="fa fa-map-marker"></i></a>
          <?php
$user_id = $row['user_id'];
    $user_address_query = "SELECT address FROM users WHERE user_id = ?";
    $stmt_address = $conn->prepare($user_address_query);
    $stmt_address->bind_param("i", $user_id);
    $stmt_address->execute();
    $address_result = $stmt_address->get_result();

    // Check if the address is fetched successfully
    if ($address_result->num_rows === 1) {
        $address_row = $address_result->fetch_assoc();
        $user_address = $address_row['address'];
    } else {
        // If the user's address is not found or there's an error, display a default message or handle the error as desired
        $user_address = "Address not available";
    }

    // Display the user's address in the location span
    echo $user_address;
    ?>
        </span>
      </div>

<?php }?>

      </div>
    </section>
    <h2 class="free">Free</h2>
    <section class="freebooks booklist">
      <?php

while ($row = $donate_result->fetch_assoc()) {?>
      <div class="singlebook">

      <img src="../../assets/uploads/<?php echo $row['images']; ?>" alt="book photo" />


        <span class="bookname"><?php echo $row['book_name']; ?></span>

        <span class="location">
          <a href="#"><i class="fa fa-map-marker"></i></a>
<?php
$user_id = $row['user_id'];
    $user_address_query = "SELECT address FROM users WHERE user_id = ?";
    $stmt_address = $conn->prepare($user_address_query);
    $stmt_address->bind_param("i", $user_id);
    $stmt_address->execute();
    $address_result = $stmt_address->get_result();
    if ($address_result->num_rows === 1) {
        $address_row = $address_result->fetch_assoc();
        $user_address = $address_row['address'];
    } else {
        // If the user's address is not found or there's an error, display a default message or handle the error as desired
        $user_address = "Address not available";
    }
    echo $user_address;

    ?>
        </span>
        </div>
        <?php }?>


    </section>

  </body>
  <script src="../../JS/homepage/open-menu.js"></script>
  <script src="../../JS/homepage/redirectlogin.js"></script>

</html>
