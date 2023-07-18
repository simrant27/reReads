<?php
session_start();

include "../main/connection.php";
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

//edit and update database
if (isset($_POST['update_profile'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['edit-name'];
    $number = $_POST['edit-number'];
    $email = $_POST['edit-email'];
    $address = $_POST['edit-address'];

    // Perform the SQL update query
    $sql = "UPDATE users SET fullName=?, email=?, address=?, phoneNo=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $address, $number, $user_id);

    if ($stmt->execute()) {
        // Update successful
        header("Location: profile.php"); // Redirect back to the profile page
        exit;
    } else {
        // Error occurred during the update
        // You can handle the error accordingly, for example:
        echo "Error updating user profile: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();

}

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
          <button type="submit" name="upload_book" onclick="closeUploadBookPopup()">Upload</button>
          <button type="button" onclick="closeUploadBookPopup()">Cancel</button>
        </form>
      </div>
    </div>

    <div id="edit-profile-popup" class="popup">
      <div class="popup-content">
        <h2>Edit Profile</h2>
        <form id="edit-form" onsubmit="saveProfileChanges(event)">
          <label for="edit-name">Name:</label>
          <input type="text" id="edit-name" name="edit-name">
          <label for="edit-number">Phone Number:</label>
          <input type="text" id="edit-number" name="edit-number" placeholder="Phone Number">
          <label for="edit-email">Email:</label>
          <input type="email" id="edit-email" name="edit-email">
          <label for="edit-address">Address:</label>
          <textarea id="edit-address" name="edit-address"></textarea>
          <button type="submit">Save Changes</button>
          <button type="button" onclick="closeEditProfilePopup()">Cancel</button>
        </form>
      </div>
    </div>
  </div>

  <script src="../../JS/profile.js"></script>

</body>

</html>
