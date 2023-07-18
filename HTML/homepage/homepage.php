<?php
session_start();
include "../../References/connection.php";
// $user_name = "Guest"; // Default name for non-logged in users

// Check if the user is logged in
if (isset($_SESSION['email']) && isset($_SESSION['user_id'])) {
    // Get the user's name from the database based on the user_id
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT fullName FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $user_name = $row['fullName'];
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
// $address = "SELECT address from user where user_id = $user_id";
// $address_result = $conn->query($address);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../CSS/homepage/homepage.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <title>HomePage</title>
  </head>
  <body>
    <nav class="navbar">
      <div class="navbar upper-nav">
        <div class="logo">
          <span class="re">re</span> <span class="Reads">Reads</span>
        </div>
        <div class="search">
          <input type="text" name="search" id="search" placeholder="search" />
          <a href="#"><i class="fa fa-search search-icon"></i></a>
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
    <section class="booklist">
      <?php while ($row = $sell_result->fetch_assoc()) {?>


      <div class="singlebook">

        <img src="../../assets/uploads/<?php echo $row['images']; ?>" alt="book photo" />

        <span class="bookname"><?php echo $row['book_name']; ?></span>
        <span class="bookprice"><?php echo $row['selling_price']; ?></span>
        <span class="location">
          <a href="#"><i class="fa fa-map-marker"></i></a>
          <?php
// echo $address_result;
    ?>
        </span>
      </div>
<?php }?>

      </div>
    </section>
    <h2 class="free">Free</h2>
    <section class="freebooks booklist">
      <div class="singlebook">
        <img src="../../Assets/Pagal-basti.jpg" alt="book photo" />

        <span class="bookname">Pagal basti</span>

        <span class="location">
          <a href="#"><i class="fa fa-map-marker"></i></a>
          Pokhara,Bagar
        </span>
      </div>

      <div class="singlebook">
        <img src="../../Assets/Pagal-basti.jpg" alt="book photo" />

        <span class="bookname">Pagal basti</span>

        <span class="location">
          <a href="#"><i class="fa fa-map-marker"></i></a>
          Pokhara,Bagar
        </span>
      </div>
      <div class="singlebook">
        <img src="../../Assets/Pagal-basti.jpg" alt="book photo" />

        <span class="bookname">Pagal basti</span>

        <span class="location">
          <a href="#"><i class="fa fa-map-marker"></i></a>
          Pokhara,Bagar
        </span>
      </div>
    </section>
  </body>
  <script src="../../JS/homepage/open-menu.js"></script>
  <script>
  function redirectToLogin() {
    window.location.href = "../../HTML/loginSignup/login.php";
  }
</script>
</html>
