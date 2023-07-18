
<?php
//This script will handle login
session_start();

// check if the user is already logged in
if (isset($_SESSION['email'])) {
    header("location:../homepage/homepage.php");
    exit;
}
require_once "../../References/connection.php";

$email = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['email'])) || empty(trim($_POST['password']))) {
        $err = "Please enter email + password";
    } else {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
    }

    if (empty($err)) {
        $sql = "SELECT user_id, email, password FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;

        // Try to execute this statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $user_id, $email, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        // this means the password is corrct. Allow user to login
                        session_start();
                        $_SESSION["email"] = $email;
                        $_SESSION["user_id"] = $user_id;
                        $_SESSION["loggedin"] = true;

                        //Redirect user to welcome page
                        header("location:http://localhost/reReads/HTML/homepage/homepage.php");

                    }
                }

            }

        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
    />
    <link rel="stylesheet" href="../../CSS/loginSignup/login.css" />
  </head>
  <body>
    <section class="container forms"id="login-form">
    <main id="mainAll">
      <aside class="right">
        <div class="Image">
          <div class="mySlides" class="right">
            <img src="../../assets/flower-purple-lical-blosso.jpeg" alt="Image1"id="Imagecontainer" />
        </div>
      </aside>
      <section id="SectionSignUp" >
<div class="logo">
          <span class="re">re</span> <span class="Reads">Reads</span>
        </div>        <br /><br />
        <div class="login">
          <form id="myForm" method="post" action="">
            <input
            class="left"
              type="text"
              name="email"
              id="email"
              required=""
              placeholder="Enter your Email"
            />
            <br /><br />
            <br /><br />
            <div class="password-container">
              <input
              class="left"
                type="password"
                name="password"
                placeholder="Password"
                required=""
                id="password"
              />
              <i
                class="far fa-eye left"
                id="togglePassword"
                style="margin-left: -30px; cursor: pointer"
              ></i>
            </div>
            <br /><br />
            <br>

            <a href="#" class="left">Forgot Password?</a>
            <br /><br />
            <button type="submit"  id="log" > Log In </button>
            <br /><br />
            <br /><br />
            <div class="left">
              Not a Member? <a href="../loginSignup/signup.php">Sign Up</a>
            </div>
          </form>
        </div>
      </section>
    </main>
    </section>
  </body>
  <!-- <script src="../../JS/loginSignup/validation.js"></script> -->
<script src="../../JS/loginSignup/eyeicon.js"></script>
  <script src="../../JS/loginSignup/imageProcessing.js"></script></html>
