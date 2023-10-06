<?php
session_start();

include "../../References/connection.php";
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

//edit and update database
if (isset($_POST['update_profile'])) {
    // echo "Name " . "<br>";

    $user_id = $_SESSION['user_id'];
    $name = $_POST['edit-name'];
    $number = $_POST['edit-number'];

    $address = $_POST['edit-address'];

    //profile pic
    if ($_FILES["edit-photo"]["error"] === 4) {
        echo
            "<script> alert('Image Does Not Exist'); </script>";
    } else {
        $fileName = $_FILES["edit-photo"]["name"];
        $fileSize = $_FILES["edit-photo"]["size"];
        $tmpName = $_FILES["edit-photo"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo
                "<script> alert('Invalid image extension'); </script>";
        } else if ($fileSize > 1000000) {
            echo
                "<script> alert('Image size is too large'); </script>";
        } else {
            $newImageName = uniqid();
            $newImageName = $name . " - " . date("Y.m.d");

            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, '../../assets/profile_picture/' . $newImageName);

// Perform the SQL update query
            $sql_update = "UPDATE users SET  fullName=?, address=?, phoneNo=?, user_img=? WHERE user_id=?";

            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssssi", $name, $address, $number, $newImageName, $user_id);

            if ($stmt_update->execute()) {
                // Update successful
                header("Location: profile.php"); // Redirect back to the profile page
                exit;
            } else {
                // Error occurred during the update
                // You can handle the error accordingly, for example:
                echo "Error updating user profile: " . $stmt_update->error;
            }

            // Close the statement for the UPDATE query
            $stmt_update->close();
        }}}

if (isset($_POST["upload_book"])) {

    $bookName = $_POST['book-name'];
    $authorName = $_POST['author-name'];
    $genre = $_POST['genre'];
    $publicationYear = $_POST['published-year'];
    $publication = $_POST['book-publication'];
    $actualPrice = $_POST['actual-price'];
    $sellingPrice = $_POST['selling-price'];
    $user_id = $_SESSION['user_id'];

// Check if the user selected "Donate" or "Sale"
    $donate = isset($_POST['price-type']) && $_POST['price-type'] === 'donate';

    if ($_FILES["book-photo"]["error"] === 4) {
        echo
            "<script> alert('Image Does Not Exist'); </script>";
    } else {
        $fileName = $_FILES["book-photo"]["name"];
        $fileSize = $_FILES["book-photo"]["size"];
        $tmpName = $_FILES["book-photo"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if (!in_array($imageExtension, $validImageExtension)) {
            echo
                "<script> alert('Invalid image extension'); </script>";
        } else if ($fileSize > 1000000) {
            echo
                "<script> alert('Image size is too large'); </script>";
        } else {
            $newImageName = uniqid();
//     $newImageName = $user_name . " - " . date("Y.m.d");

            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, '../../assets/uploads/' . $newImageName);

            $sql = "INSERT INTO books (images,book_name, author, genre, publishedYear, publication,donate,actual_price, selling_price,user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $stmt = $conn->prepare($sql);
            // Convert boolean $donate to string representation '1' or ''
            $donateString = $donate ? '1' : '0';
            $stmt->bind_param("sssssssddi", $newImageName, $bookName, $authorName, $genre, $publicationYear, $publication, $donateString, $actualPrice, $sellingPrice, $user_id);
            if ($stmt->execute()) {
                // Book upload successful
                header("Location: ./profile.php"); // Redirect to a success page
                exit;
            } else {
                // Error occurred during book upload
                echo "Error uploading book: " . $stmt->error;
            }
        }

    }
}

if (!empty($profile_image) && file_exists('../../assets/profile_picture/' . $profile_image)) {
    // If $profile_image is not empty and the file exists, display the user's profile image
    $image_source = '../../assets/profile_picture/' . $profile_image;
} else {
    // If $profile_image is empty or the file does not exist, display the default image
    $image_source = '../../assets/profile_picture/default.png';
}
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
    <a href="../homepage/homepage.php">Back to Home</a>
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

    <div class="uploads" class="uploads">
        <?php
include "./uploadbook/uploadbook.php";
?>


</div>


    <div id="edit-profile-popup" class="popup" >
      <div class="popup-content">
        <h2>Edit Profile</h2>
        <form id="edit-form"  method="post" action="./profile.php" enctype="multipart/form-data">
          <label for="edit-photo">Profile picture</label>
        <input type="file" id="edit-photo" name="edit-photo" accept=".jpg, .jpeg, .png" >

          <label for="edit-name">Name:</label>
          <input type="text" id="edit-name" name="edit-name">
          <label for="edit-number">Phone Number:</label>
          <input type="text" id="edit-number" name="edit-number" placeholder="Phone Number">

          <label for="edit-address"> Address:</label>
          <input type="text" id="edit-address" name="edit-address" placeholder=" Address" value="<?php echo $address ?>">
          <button type="submit" name="update_profile">Save Changes</button>
          <button type="button" onclick="closeEditProfilePopup()">Cancel</button>

        </form>
      </div>

    </div>
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
      <!-- <a href="../singlepage/singlepage.php?book_id=' . $row1['book_id'] . '">'; -->
        <a href="../singlepage/singlepage.php"></a>
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
