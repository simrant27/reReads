<?php
include "../main/connection.php";
//connect to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "rereads";

//creating connection
$conn = mysqli_connect($servername, $username, $password, $database);

$user_id = 1;
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
  <title>Profile Page</title>
  <link rel="stylesheet" href="../../CSS/profile/profile.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
  <div class="container">
    <div class="profile">
      <div class="profile-image">
        <img src="../../assets/simran.jpg" alt="Profile Photo" id="profile-photo">
        <label for="profile-photo-input" class="edit-icon">
          <input type="file" id="profile-photo-input" accept="image/*" onchange="handleProfilePhotoChange(event)">
          <i class="fas fa-camera"></i>
        </label>
      </div>
      <div class="profile-details">
        <!-- <h2 id="profile-name"><?php echo $user_name ?></h2>

        <p id="profile-number"><?php echo $phoneNo ?></p>
        <p id="profile-email"> <?php echo $email ?> </p>
        <p id="profile-address"><?php echo $address ?> </p> -->
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
        <button id="upload-book-button" onclick="openUploadBookForm()">Upload Book</button>
      </div>
    </div>

    <div id="upload-book-popup" class="popup">
      <div class="popup-content">
        <h2>Upload Book</h2>
        <form id="upload-book-form" onsubmit="handleUploadBook(event)">
          <input type="file" id="book-photo" name="book-photo" accept="image/*" required>
          <input type="text" id="book-name" name="book-name" placeholder="Book Name" required>
          <input type="text" id="author-name" name="author-name" placeholder="Author Name" required>
          <input type="text" id="book-language" name="book-language" placeholder="Language" required>
          <input type="number" id="published-year" name="published-year" min="1900" max="2099" placeholder="Publication Year" >
          <input type="text" id="book-publisher" name="book-publication" placeholder="book-publication" >
          <input type="radio" id="donate-radio" name="price-type" value="donate" onclick="togglePriceFields(false)" required>
          <label for="donate-radio">Donate</label>
          <input type="radio" id="sale-radio" name="price-type" value="sale" onclick="togglePriceFields(true)" required>
          <label for="sale-radio">Sale</label>
          <div class="price-fields">
            <input type="number" id="actual-price" name="actual-price" placeholder="Actual Price" required>
            <input type="number" id="selling-price" name="selling-price" placeholder="Selling Price" required>
          </div>
          <button type="submit" onclick="closeUploadBookPopup()">Upload</button>
          <button type="button" onclick="closeUploadBookPopup()">Cancel</button>
        </form>
      </div>
    </div>

    <div class="edit-form-container" id="edit-form-container">
      <form id="edit-form" class="edit-form" onsubmit="saveProfileChanges(event)" action="">

        <label for="edit-name">Name:</label>
        <input type="text" id="edit-name" name="edit-name">
        <label for="edit-number">Phone Number:</label>
        <input type="tel" id="edit-number" name="edit-number">
        <label for="edit-email">Email:</label>
         <input type="email" id="edit-email" name="edit-email">
        <label for="edit-address">Address:</label>
        <textarea id="edit-address" name="edit-address"></textarea>
        <button type="submit" name = "update">Save Changes</button>
        <button type="button" onclick="cancelEditForm()">Cancel</button>
      </form>

<?php

include "../main/connection.php";

if (isset($_POST['update'])) {
    $name = $_POST['edit-name'];
    $number = $_POST['edit-number'];
    $email = $_POST['edit-email'];
    $address = $_POST['edit-address'];

    $sql = "  UPDATE users SET ,fullName='$name',email='$email',address='$address',phoneNo='$number' WHERE user_id = 1";
    $query_rum = mysqli_query($conn, $sql);

}
?>
    </div>
  </div>

  <script src="../../JS/profile.js"></script>

</body>

</html>
