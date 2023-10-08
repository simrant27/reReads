<?php

if (isset($_POST['update_profile'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['edit-name'];
    $number = $_POST['edit-number'];
    $address = $_POST['edit-address'];

    // Initialize $newImageName to the current user image
    $newImageName = $_SESSION['user_img'];

    // Check if a new photo is uploaded
    if ($_FILES["edit-photo"]["error"] !== 4) {
        $fileName = $_FILES["edit-photo"]["name"];
        $fileSize = $_FILES["edit-photo"]["size"];
        $tmpName = $_FILES["edit-photo"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script> alert('Invalid image extension'); </script>";
        } else if ($fileSize > 1000000) {
            echo "<script> alert('Image size is too large'); </script>";
        } else {
            $newImageName = uniqid();
            $newImageName = $name . " - " . date("Y.m.d");
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, '../../assets/profile_picture/' . $newImageName);
        }
    }

    // Perform the SQL update query
    $sql_update = "UPDATE users SET fullName=?, address=?, phoneNo=?, user_img=? WHERE user_id=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $name, $address, $number, $newImageName, $user_id);

    if ($stmt_update->execute()) {
        // Update successful
        // Update the user image in the session
        $_SESSION['user_img'] = $newImageName;
        header("Location: profile.php"); // Redirect back to the profile page
        exit;
    } else {
        // Error occurred during the update
        echo "Error updating user profile: " . $stmt_update->error;
    }

    // Close the statement for the UPDATE query
    $stmt_update->close();
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
  <title>Document</title>

</head>
<body>   <div class="popup-content">
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

          <label for="change-password"> Change Password:</label>
          <input type="text" id="old-password" name="old-password" placeholder=" old password" value="">
          <input type="text" id="new-password" name="new-password" placeholder=" new password" value="">

          <button type="submit" name="update_profile">Save Changes</button>
          <button type="button" onclick="closeEditProfilePopup()">Cancel</button>

        </form>
      </div>

    </div>
</body>
<script src="../../JS/homepage/open-menu.js"></script>
<script src="../../JS/profile.js"></script>

</html>
