<?php

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
//     $newImageName = $user_name . " - " . date("Y.m.d");

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
  <title>Document</title>

</head>
<body>
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
</body>
<script src="../../JS/homepage/open-menu.js"></script>
<script src="../../JS/profile.js"></script>

</html>
