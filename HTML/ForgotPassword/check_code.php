<?php
$email = $_POST['email'];
$code = $_POST['code'];

if(!$email){
    header("location:http://localhost/reReads/HTML/ForgotPassword/forgot.php");
    return;
}
if(!$code){
    header("location:http://localhost/reReads/HTML/ForgotPassword/recover.php?email=$email");
    return;
}
// Match email and Code
require_once "../../References/connection.php";
$sql = "select * from users";
$result = mysqli_query($conn, $sql);

$response = false;
if(mysqli_num_rows($result) > 0){
    while($rows = mysqli_fetch_assoc($result)){
        if($email == $rows['email'] && $code == $rows['code']){
            $response = true;
        }
    };
};

if (!$response){
    echo "Incorrect Code Entered";
    header("location:http://localhost/reReads/HTML/ForgotPassword/recover.php?email=$email");
    return;
} else {
    echo "Correct Code Entered";
    header("location:http://localhost/reReads/HTML/ForgotPassword/reset_password.php?email=$email");
}
?>