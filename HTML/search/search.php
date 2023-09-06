<?php
include "../../References/connection.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search data</title>
  <link rel="stylesheet" href="../../CSS/homepage/homepage.css" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
</head>
<body>

<nav class="navbar">
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


        <div class="profile">
          <!-- <i class="fa fa-user search-icon"></i> -->

          <img
        src="../../Assets/IMG_0523.jpeg"
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
                    <img src="../../Assets/IMG_0523.jpeg" alt="" />
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
              <a href="#" class="sub-menu-link">
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
          <li><a href="#home"> Home</a></li>
          <li><a href="#aboutus">About us</a></li>
          <li><a href="#addBooks">Add Books</a></li>
        </ul>
      </div>
    </nav>
  <div class="container">
    <?php

if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM `books` WHERE book_name like '%$search%' or author like '%$search%' or  genre like '%$search%'";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        $num = mysqli_num_rows($result);

        if ($num > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                ?>
            <div class="singlebook">
        <img src="../../assets/uploads/<?php echo $row['images']; ?>" alt="book photo" />


        <span class="bookname"><?php echo $row['book_name']; ?></span>
        <span class="bookprice">Rs.<?php echo $row['selling_price']; ?></span>
            </div>  <?php }
        }
    } else {
        echo "NO data found";
    }
} else {
    echo "Error in the SQL query: " . mysqli_error($conn);
}

?>
  </div>
        </div>
</body>
<script src="../../JS/homepage/open-menu.js"></script>
<script src="../../JS/homepage/redirectlogin.js"></script>

</html>
