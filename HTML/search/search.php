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
<div class="search">
  <form action="" method="post">
          <input type="text" name="search" id="search" placeholder="search" />

  <button class="btn" name="submit"><i class="fa fa-search search-icon"></i></button>
  </form>
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
    } else {?>
        <h2> No results found.</h2>
        <?php
}
} else {
    echo "Error in the SQL query: " . mysqli_error($conn);
}

?>
  </div>
        </div>
</body>
</html>
