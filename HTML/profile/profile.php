<?php
session_start();

include "../../References/connection.php";

include "./deletebook.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: ../homepage/homepage.php");
    exit;
}

//connect to database

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
// Edit and update database

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="../../CSS/profile/profile.css">
  <link rel="stylesheet" href="../../CSS/homepage/homepage.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
<nav>
<div class="logo ">
          <span class="re logo-profile">re</span> <span class="Reads logo-profile">Reads</span>
        </div>
<div class="navbar ">
        <ul class="lower-nav nav-list">
          <li><a href="../homepage/homepage.php"> Home</a></li>
          <li><a href="#">About us</a></li>
          <li><a href="#addBooks">Add Books</a></li>
        </ul>
      </div>
  </nav>
  <div class="profile-container">

  <?php
$row = $result->fetch_assoc();
$user_name = $row['fullName'];
$email = $row['email'];
$profile_image = $row['user_img'];
$phoneNo = $row['phoneNo'];
$address = $row['address'];

if (!empty($profile_image) && file_exists('../../assets/profile_picture/' . $profile_image)) {
    // If $profile_image is not empty and the file exists, display the user's profile image
    $image_source = '../../assets/profile_picture/' . $profile_image;
} else {
    // If $profile_image is empty or the file does not exist, display the default image
    $image_source = '../../assets/profile_picture/default.png';
}
?>
    <div class="profile">


      <form action="" class="upload-profile-picture" id="upload-profile-picture" enctype="multipart/form-data" method="post">
      <div class="profile-image">
        <img src="<?php echo $image_source ?>" alt="">

      </div>

      </form>
      <script type="text/javascript">
        document.getElementById("user-image").onchange = function(){
          document.getElementById('upload-profile-picture').submit();
        }
      </script>

    </div>
    

      <div class="profile-details" id="profile-details">

        <span>Name: </span>
      <span id="profile-name"><?php echo $user_name ?></span>
      <br>
      <span>Phone number: </span>
      <span id="profile-number"><?php echo $phoneNo ?></span>
      <br>
      <span>Email: </span>
      <span id="profile-email"><?php echo $email ?></span>
      <br>
 <span>Address: </span>
      <span id="profile-address"><?php echo $address ?></span>
<br>
        <button id="edit-button" onclick="openEditForm()">Edit Profile</button>
      </div>
    </div>

    <div class="uploads" id="addBooks"> 
        <?php
include "./uploadbook.php";
?>


</div>


    <div id="edit-profile-popup" class="popup" >
    <?php
include "./editprofile.php";
?>

  </div>
  <h3>Uploads</h3>
  <section class="booklist">
    <?php
//fetching the uploaded books

$upload_sql = "SELECT * FROM books WHERE user_id = ? ORDER BY book_id DESC";
$stmt_upload = $conn->prepare($upload_sql);
$stmt_upload->bind_param("i", $user_id);
$stmt_upload->execute();
$upload_result = $stmt_upload->get_result();

while ($row = $upload_result->fetch_assoc()) {?>



      <div class="singlebook">

        <img src="../../assets/uploads/<?php echo $row['images']; ?>" alt="book photo" class="book_img"/>


        <span class="bookname"><?php echo $row['book_name']; ?></span>
<span>
<?php

    echo '<a href="./profile.php?b_id=' . $row['book_id'] . '"class="delete-button">Delete';

    ?>
    </span>

      </div>

<?php }?>

      </div>
    </section>

<!-- for displaying favourites -->
<h3>Favourites</h3>
    <section class="booklist">
    <?php
//fetching the favourites books

$favourite_sql = "SELECT book_id FROM favourites WHERE user_id = ?  ";
$favourite_stmt = $conn->prepare($favourite_sql);
$favourite_stmt->bind_param("i", $user_id);
$favourite_stmt->execute();
$favourite_result = $favourite_stmt->get_result();

while ($row = $favourite_result->fetch_assoc()) {
    $book_id = $row['book_id'];
    $book_sql = "SELECT * from books where book_id = ?";
    $book_stmt = $conn->prepare($book_sql);
    $book_stmt->bind_param("i", $book_id);
    $book_stmt->execute();
    $book_stmt_result = $book_stmt->get_result();

    while ($row1 = $book_stmt_result->fetch_assoc()) {?>


      <div class="singlebook">
      <a href="../singlepage/singlepage.php?book_id=<?php $row1['book_id'];?>">
        <img src="../../assets/uploads/<?php echo $row1['images']; ?>" alt="book photo" class="book_img"/>
    </a>

        <span class="bookname"><?php echo $row1['book_name']; ?></span>




      </div>

<?php }}?>


      </div>
    </section>
  <script src="../../JS/profile.js"></script>



</body>
<!-- <script src="../../JS/homepage/open-menu.js"></script> -->

</html>
