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

// Fetch the user's information
$row = $result->fetch_assoc();
$user_name = $row['fullName'];
$email = $row['email'];
$profile_image = $row['user_img'];
$phoneNo = $row['phoneNo'];
$address = $row['address'];

//fetching the uploaded books

$upload_sql = "SELECT * FROM books WHERE user_id = ? ORDER BY book_id DESC";
$stmt_upload = $conn->prepare($upload_sql);
$stmt_upload->bind_param("i", $user_id);
$stmt_upload->execute();
$upload_result = $stmt_upload->get_result();

//edit and update database
if (isset($_POST['update_profile'])) {
    echo "Name " . "<br>";

    $user_id = $_SESSION['user_id'];
    $name = $_POST['edit-name'];
    $number = $_POST['edit-number'];
    $email = $_POST['edit-email'];
    $address = $_POST['edit-address'];

// Perform the SQL update query
    $sql_update = "UPDATE users SET fullName=?, email=?, address=?, phoneNo=? WHERE user_id=?";

    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $name, $email, $address, $number, $user_id);

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
}

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
  <div class="container">
    <div class="profile">
      <div class="profile-image">
      <img src="<?php echo $user_photo ?>" alt="Profile Photo" id="profile-photo">
        <!-- <label for="profile-photo-input" class="edit-icon">
          <input type="file" id="profile-photo-input" accept="image/*" onchange="handleProfilePhotoChange(event)">
          <i class="fas fa-camera"></i>
        </label> -->
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
    <div id="uploads" class="uploads">
      <button id="upload-book-button" onclick="openUploadBookForm()">Upload Book</button>

    </div>

    <div id="upload-book-popup" class="popup">
      <div class="popup-content">
        <h2>Upload Book</h2>
        <form id="upload-book-form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
          <input type="file" id="book-photo" name="book-photo" accept=".jpg, .jpeg, .png" required>
          <input type="text" id="book-name" name="book-name" placeholder="Book Name" required>
          <input type="text" id="author-name" name="author-name" placeholder="Author Name" required>
          <input type="text" id="genre" name="genre" placeholder="genre" >
          <input type="number" id="published-year" name="published-year" min="1900" max="2099" placeholder="Publication Year" >
          <input type="text" id="book-publisher" name="book-publication" placeholder="publication" required>
          <input type="radio" id="donate-radio" name="price-type" value="donate" onclick="togglePriceFields(false)" required>
          <label for="donate-radio">Donate</label>
          <input type="radio" id="sale-radio" name="price-type" value="sale" onclick="togglePriceFields(true)" required>
          <label for="sale-radio">Sale</label>
          <div class="price-fields">
            <input type="number" id="actual-price" name="actual-price" placeholder="Actual Price" required>
            <input type="number" id="selling-price" name="selling-price" placeholder="Selling Price" required>
          </div>
          <button type="submit" name="upload_book"">Upload</button>
          <button type="button" id="cancel-button" onclick="closeUploadBookPopup()" ">Cancel</button>
        </form>
      </div>
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
  <section class="booklist">

<div class="your_uploads">
  <h3>Uploads</h3>
  <?php while ($row = $upload_result->fetch_assoc()) {?>

  <div class="singlebook">

<img src="../../assets/uploads/<?php echo $row['images']; ?>" alt="book photo" />


<span class="bookname"><?php echo $row['book_name']; ?></span>
<span class="bookprice">Rs.<?php echo $row['selling_price']; ?></span>
  </div>
  <?php }?>


</div>
  </section>
  <script src="../../JS/profile.js"></script>

</body>
<script src="../../JS/homepage/open-menu.js"></script>

</html>
