<?php
include_once "../../References/connection.php";

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../CSS/homepage/homepage.css" />
    <link
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
    />
  <title>navbar</title>
</head>
<body>
 <?php
if (!empty($profile_image) && file_exists('../../assets/profile_picture/' . $profile_image)) {
    // If $profile_image is not empty and the file exists, display the user's profile image
    $image_source = '../../assets/profile_picture/' . $profile_image;
} else {
    // If $profile_image is empty or the file does not exist, display the default image
    $image_source = '../../assets/profile_picture/default.png';
}
?>
<div class="navbar upper-nav">
        <div class="logo">
          <span class="re">re</span> <span class="Reads">Reads</span>
        </div>
        <div class="search">

  <form action="../navbar/search.php" method="post">

      <input type="textbox" name="search" id="search" placeholder="search books..." />

      <button type="submit" class="btn" name="submit"><i class="fa fa-search search-icon"></i></button>

  </form>
</div>
<div class="notification">
        <?php include "../notification/notification.php";?>


</div>

        <div class="profile">
          <!-- <i class="fa fa-user search-icon"></i> -->



<div class="user-image">

          <img
        src="<?php echo $image_source ?>"
        alt=""
        class="userpic"
        <?php if (isset($_SESSION['email']) && isset($_SESSION['user_id'])): ?>
            onclick="toggleMenu()"
        <?php else: ?>
            onclick="redirectToLogin()"
        <?php endif;?>
    />
</div>
          <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
            <?php if (isset($_SESSION['email']) && isset($_SESSION['user_id'])): ?>
                <div class="user-info">
                    <img src="<?php echo $image_source ?>" alt="" class="userpic"/>
                    <h3><?php echo $user_name; ?></h3>

              </div>
              <hr />
               <?php
$email = $_SESSION['email'];
if ($email != "rereads3@gmail.com"):
?>
              <a href="../profile/profile.php" class="sub-menu-link">
                <p>Your profile</p>
                <span>></span>
              </a>
              <a href="#" class="sub-menu-link">
                <p>Favourite</p>
                <span>></span>
              </a>
              <a href="../profile/profile.php" class="sub-menu-link">
                <p>Add books</p>
                <span>></span>
               <?php endif;?>

              </a>
              <a href="?logout=true" class="sub-menu-link">
                <p>Logout</p>
                <span>></span>
              </a>
              <?php
$email = $_SESSION['email'];
if ($email == "rereads3@gmail.com"):
?>
              <a href="../admin/users.php" class="sub-menu-link">
                <p>Users</p>
                <span>></span>
              </a>
               <?php endif;?>
              <?php else: ?>
                <!-- Show a link to the login page for non-logged-in users -->
                <a href="../loginSignup/login.php" class="sub-menu-link">
                    <p>Login</p>
                    <span>></span>
                </a>
            <?php endif;?>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar lower-nav">
        <ul class="lower-nav nav-list">
        <li><a href="../homepage/homepage.php">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
        </ul>
      </div>
</body>
<script src="../../JS/homepage/open-menu.js"></script>
  <script src="../../JS/homepage/redirectlogin.js"></script>
  <script src="../../JS/footer/footer.js"></script>

</html>