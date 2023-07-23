<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../References/connection.php";

$name = $address = $email = $phoneNumber = $password = $confirmPassword = "";
$name_err = $address_err = $email_err = $phoneNumber_err = $password_err = $confirmPassword_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if name is empty
    if (empty(trim($_POST["name"]))) {
        $name_err = "Name cannot be blank";
    } else {
        $name = trim($_POST['name']);
    }

    // Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } else if (strlen(trim($_POST['password'])) < 8) {
        $password_err = "Password cannot be less than 8 characters";
    } else {
        $password = trim($_POST['password']);
    }

    // Check for confirm password field
    if (empty(trim($_POST['confirm_Password']))) {
        $confirmPassword_err = "Confirm password cannot be blank";
    } else {
        $confirmPassword = trim($_POST['confirm_Password']);
        if ($password !== $confirmPassword) {
            $confirmPassword_err = "Passwords do not match";
        }
    }

    // Check for email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Email cannot be blank";
    } else {
        $sql = "SELECT user_id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST['email']);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken";
                } else {
                    $email = trim($_POST['email']);
                }
            } else {
                echo "Something went wrong";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Check for Address
    if (empty(trim($_POST['Address']))) {
        $address_err = "Address cannot be blank";
    } else if (strlen(trim($_POST['Address'])) < 5) {
        $address_err = "Address cannot be less than 5 characters";
    } else {
        $address = trim($_POST['Address']);
    }

    // Check for Phone Number
    if (empty(trim($_POST['PhoneNumber']))) {
        $phoneNumber_err = "Phone number cannot be blank";
    } else if (!preg_match('/^[0-9]{10}$/', $_POST['PhoneNumber'])) {
        $phoneNumber_err = "Invalid phone number format. Please enter a 10-digit numeric phone number without spaces or special characters.";
    } else {
        $phoneNumber = trim($_POST['PhoneNumber']);
    }

    // If there were no errors, go ahead and insert into the database
    if (empty($name_err) && empty($password_err) && empty($confirmPassword_err) && empty($email_err) && empty($address_err) && empty($phoneNumber_err)) {
        $sql = "INSERT INTO users (fullName, email, address, password, phoneNo) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_email, $param_address, $param_password, $param_phoneNumber);
            $param_name = $name;
            $param_address = $address;
            $param_email = $email;
            $param_phoneNumber = $phoneNumber;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)) {
                echo "Registration successful!";
                header("location: http://localhost/reReads/HTML/loginSignup/login.php");
                exit; // Always include an exit after the header redirect to prevent further execution of the script.
            } else {
                echo "Something went wrong... cannot redirect!";
            }
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($conn);
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
    <link rel="stylesheet" href="../../CSS/loginSignup/signup.css" />


  </head>
  <body>
    <main id="mainAll">
       <aside class="right">
        <div class="Image">
          <div class="mySlides right" >
            <img src="../../assets/backgroundImage/download3.jpeg" alt="Image1"id="Imagecontainer" />
        </div>
      </aside>
      <section id="SectionSignUp">
<div class="logo">
          <span class="re">re</span> <span class="Reads">Reads</span>
        </div>        <br /><br />
        <br>
        <div class="signup">
<form id="myForm" method="post" name="myForm"  enctype="multipart/form-data" action="signup.php" onsubmit="return validateInputs()">
            <div class="input-control">
              <input
                type="text"
                name="name"
                required=""
                id="name"
                placeholder="Enter your Full Name"
              />
              <div class="error"></div>
            </div>
<br>
            <div class="input-control">
              <input
                type="text"
                name="Address"
                id="Address"
                required=""
                placeholder="Address"
              />
              <div class="error"></div>
            </div>
<br>

            <div class="input-control">
              <input
                type="text"
                required=""
                name="email"
                id="email"
                placeholder="Email"
              /> 
              <div class="error"></div>
            </div>
<br>

            <div class="input-control">
              <input
                type="text"
                name="PhoneNumber"
                required=""
                id="PhoneNumber"
                placeholder="Phone Number"
              /> 
              <div class="error"></div>
            </div>
<br>

            <div class="input-control">
                <div class="password-container">
                  <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required=""
                    id="password"
                  />
                  <i
                    class="far fa-eye"
                    id="togglePassword"
                    style="margin-left: -30px; cursor: pointer"
                  ></i>
                </div> 
                <div class="error"></div>
            </div>
<br>

            <div class="input-control">
              <div class="password-container">
                <input
                  type="password"
                  name="confirm_Password"
                  placeholder="Confirm Password"
                  required=""
                  id="Cpassword"
                />
                <i
                  class="far fa-eye"
                  id="CtogglePassword"
                  style="margin-left: -30px; cursor: pointer"
                ></i>
              </div>
               <div class="error"></div>
               
               <br /><br />
              </div>
              <button type="submit" id="signup">Sign Up </button>
              
              <br /><br />
              <div class="left">
                Already Sign In? <a href="../loginSignup/login.php">Log In</a>
              </div>
              <br /><br />
            </form>
          </div>
        </section>
      </main>
        <script src="../../JS/loginSignup/eyeicon.js"></script>
<script src="../../JS/loginSignup/imageProcessing.js"></script>
    
<script src="../../JS/loginSignup/validation.js"></script>
  </body>


</html>




