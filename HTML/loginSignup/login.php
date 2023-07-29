
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
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
    />
    <link rel="stylesheet" href="../../CSS/loginSignup/login_signup.css" />
  </head>
 <body
    id="bg-img"
    style="background-image: url('../../assets/backgroundImage/download5.jpeg')"
  >    
    
 <div class="wrapper">
    <div class="container main">
      <div class="row">
        <div class="col-md-6 side-image">
          <!-- Image -->
          <!-- <img src="" alt="Image1" id="Imagecontainer" /> -->
          <div class="text">
            <p>Join the community of developers <i>- ludiflex</i></p>
          </div>
        </div>

        <div class="col-md-6 right">
          <!-- Form -->
          <form class="input-box" action="/submit" method="post">
            <div class="logo">
              <span class="re">re</span> <span class="Reads">Reads</span>
            </div>  
            <div class="input-field">
              <input type="text" class="input" id="email" required="" 
              />
             
              <label for="email">Email</label>
            </div>
            <div class="input-field">
              <input type="password" class="input" id="password" required="" />
              <label for="password">Password</label>
               <i
              class="far fa-eye left"
              id="togglePassword"
              style="margin-left: 280px; margin-top:-45px; cursor: pointer"
              ></i>
            </div>
            <br>
            <span>           
              <a href="../ForgotPassword/forgot.html" class="left">Forgot Password?</a>
            </span>
            <br>
            <div class="input-field">
              <input type="submit" class="submit" value=" Log In" />
            </div>
            <div class="signin">
              <span>Not a Member?  <a href="../loginSignup/signup.php">Sign Up Here</a></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

        <script src="../../JS/loginSignup/eyeicon.js"></script>
        <script src="../../JS/Background/background.js"></script>
        <script src="../../JS/loginSignup/validation.js"></script>
  </body>
  </html>
