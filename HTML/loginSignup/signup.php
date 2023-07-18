<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../References/connection.php";

$name = $Address = $email = $PhoneNumber = $password = $confirm_Password = "";
$name_err = $Address_err = $email_err = $PhoneNumber_err = $password_err = $confirm_Password_err = "";

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
        $confirm_Password_err = "Confirm password cannot be blank";
    } else {
        $confirm_Password = trim($_POST['confirm_Password']);
        if ($password !== $confirm_Password) {
            $confirm_Password_err = "Passwords do not match";
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

        // Set the value of param email
        $param_email = trim($_POST['email']);

        // Try to execute this statement
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
    }
}

mysqli_stmt_close($stmt);


    // Check for Address
    if (empty(trim($_POST['Address']))) {
        $Address_err = "Address cannot be blank";
    } else if (strlen(trim($_POST['Address'])) < 5) {
        $Address_err = "Address cannot be less than 5 characters";
    } else {
        $Address = trim($_POST['Address']);
    }

    // Check for Phone Number
    if (empty(trim($_POST['PhoneNumber']))) {
        $PhoneNumber_err = "Phone number cannot be blank";
    } else if (!preg_match('/^[0-9]{10}$/', $_POST['PhoneNumber'])) {
        $PhoneNumber_err = "Invalid phone number format. Please enter a 10-digit numeric phone number without spaces or special characters.";
    } else {
        $PhoneNumber = trim($_POST['PhoneNumber']);
    }

    // If there were no errors, go ahead and insert into the database
    if (empty($name_err) && empty($password_err) && empty($confirm_Password_err) && empty($email_err) && empty($Address_err) && empty($PhoneNumber_err)) {
        $sql = "INSERT INTO users (fullName, email, address, password, phoneNo) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_email, $param_Address, $param_password,  $param_PhoneNumber);
            $param_name = $name;
            $param_Address = $Address;
            $param_email = $email;
            $param_PhoneNumber = $PhoneNumber;

            $param_password = password_hash($password, PASSWORD_DEFAULT);
            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo "Registration successful!";
                header("location:http://localhost/reReads/HTML/loginSignup/login.php");
                // exit; // Always include an exit after the header redirect to prevent further execution of the script.
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
            <img src="../../assets/flower-purple-lical-blosso.jpeg" alt="Image1"id="Imagecontainer" />
        </div>
      </aside>
      <section id="SectionSignUp">
<div class="logo">
          <span class="re">re</span> <span class="Reads">Reads</span>
        </div>        <br /><br />
        <br>
        <div class="signup">
          <form id="myForm" method="post" enctype="multipart/form-data" action="" >
            <input
              type="text"
              name="name"
              required=""
              id="name"
              placeholder="Enter your Full Name"
              
            />
            <br /><br />
            <input
              type="text"
              name="Address"
              id="Address"
              required=""
              placeholder="Address"
            />

            <br /><br />
            <input
              type="text"
              required=""
              name="email"
              id="email"
              placeholder="Email"
            />
            <br /><br />
            <input
              type="text"
              name="PhoneNumber"
              required=""
              id="PhoneNumber"
              placeholder="Phone Number"
            />
            <br /><br />

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
            <br />

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

            <br /><br />
            <button type="submit" id="signup"  >Sign Up </button>

            <br /><br />
            <div class="left">
              Already Sign In? <a href="../loginSignup/login.php">Log In</a>
            </div>
            <br /><br />
          </form>
        </div>
      </section>
    </main>
  </body>
  <script src="../../JS/loginSignup/eyeicon.js"></script>
  <script src="../../JS/loginSignup/imageProcessing.js"></script>
    <!-- <script src="../../JS/loginSignup/validation.js"></script> -->

</html>
