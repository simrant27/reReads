<?php
session_start();

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
<?php
include "../navbar/navbar.php";
?>
    </nav>
  <div class="container">
    <?php

if (isset($_POST['submit'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    if (!empty($search)) { // Check if the search input is not empty
        $sql = "SELECT * FROM `books` WHERE book_name like '%$search%' or author like '%$search%' or  genre like '%$search%'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $book_id = $row['book_id'];
                ?>
                <div class="singlebook search_content">
                    <?php

                // if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                //     // If logged in, link to singlepage.php
                // } else {
                //     // If not logged in, link to the login page
                //     echo '<a href="../loginSignup/login.php">';
                // }
                //
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {?>
                    <a href="../singlepage/singlepage.php?book_id=<?php echo $row['book_id']; ?>">
                        <?php } else {

                    echo '<a href="../loginSignup/login.php">';
                }
                ?>
                        <img src="../../assets/uploads/<?php echo $row['images']; ?>" alt="book photo" class="book_img"/>
</a>
                    <div class="bookname"><?php echo $row['book_name']; ?></div>

                    <div class="bookprice">Rs.<?php echo $row['selling_price']; ?></div>

                </div>
                <?php
}
        } else {
            echo "No data found";
        }
    }
}

?>
  </div>
        </div>
</body>
<script src="../../JS/homepage/open-menu.js"></script>
<script src="../../JS/homepage/redirectlogin.js"></script>

</html>
