
<?php

include "../main/connection.php";
'<script>console.log("i am in");</script';
if (isset($_POST['update'])) {
    $name = $_POST['edit-name'];
    $number = $_POST['edit-number'];
    $email = $_POST['edit-email'];
    $address = $_POST['edit-address'];

    $sql = "  UPDATE `users` SET ,`fullName`='$name',`email`='$email',`address`='$address',`phoneNo`='$number' WHERE 1";
    $query_rum = mysqli_query($conn, $sql);

}