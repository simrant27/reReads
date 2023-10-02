
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
<div class="navbar upper-nav">
        <div class="logo">
          <span class="re">re</span> <span class="Reads">Reads</span>
        </div>
        <div class="search">
  <form action="../search/search.php" method="post">

      <input type="text" name="search" id="search" placeholder="search" />
      <button type="submit" class="btn" name="submit"><i class="fa fa-search search-icon"></i></button>

  </form>
</div>
<div class="notification">
        <?php include "../notification/notification.php";?>


</div>

        <div class="profile">
          <!-- <i class="fa fa-user search-icon"></i> -->


          <img
        src="../../assets/profile_picture/<?php echo $profile_image ?>"
        alt=""
        class="userpic"
        <?php if (isset($_SESSION['email']) && isset($_SESSION['user_id'])): ?>
            onclick="toggleMenu()"
        <?php else: ?>
            onclick="redirectToLogin()"
        <?php endif;?>
    />
          <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
            <?php if (isset($_SESSION['email']) && isset($_SESSION['user_id'])): ?>
                <div class="user-info">
                    <img src="../../assets/profile_picture/<?php echo $profile_image ?>" alt="" />
                    <h3><?php echo $user_name; ?></h3>

              </div>
              <hr />
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
              </a>
              <a href="?logout=true" class="sub-menu-link">
                <p>Logout</p>
                <span>></span>
              </a>
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
          <li><a href="../homepage/homepage.php"> Home</a></li>
          <li><a href="../AboutUs/aboutUs.php">About us</a></li>
          <li><a href="#addBooks">Add Books</a></li>
        </ul>
      </div>
</body>
</html>