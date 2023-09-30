<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../References/connection.php";

$name = $address = $email = $phoneNumber = $password = $confirmPassword = "";
$name_err = $address_err = $email_err = $phoneNumber_err = $password_err = $confirmPassword_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Sanitize and validate input data

    // Name
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
    }

    // Address
    if (isset($_POST['Address'])) {
        $address = trim($_POST['Address']);
    }

    // Email
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        } else {
            $sql = "SELECT user_id FROM users WHERE email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                $param_email = $email;

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        $email_err = "This email is already taken";
                    }
                } else {
                    echo "Something went wrong";
                }
                mysqli_stmt_close($stmt);
            }
        }
    }

    // Phone Number
    if (isset($_POST['PhoneNumber'])) {
        $phoneNumber = trim($_POST['PhoneNumber']);
        if (!preg_match('/^[0-9]{10}$/', $phoneNumber)) {
            $phoneNumber_err = "Invalid phone number format.";
        }
    }

    // Password
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
        if (strlen($password) < 8) {
            $password_err = "Password cannot be less than 8 characters";
        }
    }

    // Confirm Password
    if (isset($_POST['confirm_Password'])) {
        $confirmPassword = trim($_POST['confirm_Password']);
        if ($password !== $confirmPassword) {
            $confirmPassword_err = "Passwords do not match";
        }
    }

    // If there were no errors, proceed to insert into the database
    if (empty($name_err) && empty($password_err) && empty($confirmPassword_err) && empty($email_err) && empty($address_err) && empty($phoneNumber_err)) {
        $sql = "INSERT INTO users (fullName, email, address, password, phoneNo) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_email, $param_address, $param_password, $param_phoneNumber);

            // Set the parameters
            $param_name = $name;
            $param_address = $address;
            $param_email = $email;
            $param_phoneNumber = $phoneNumber;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Try to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Generate a verification code
                $verify_email = rand(100000, 999999);

                // Update the verification code in the database
                $update_sql = "UPDATE users SET verify_email = ? WHERE email = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                if ($update_stmt) {
                    mysqli_stmt_bind_param($update_stmt, "is", $verify_email, $email);
                    if (mysqli_stmt_execute($update_stmt)) {
                        // Include the email sending code here to send a verification email
                        // You can use a library like PHPMailer to send emails

                        // Include the email sending code you provided
                        include "../ForgotPassword/mail.php";

                        // Send the email
                        $mail->AddAddress($email);
                        $mail->AddReplyTo($email);

                        $subject = "Account Verification Code";
                        $mail->Subject = $subject;

                        $content = "<b>The verification code to verify your email: $verify_email</b>";
                        $mail->MsgHTML($content);

                        if (!$mail->Send()) {
                            $error_message = "Error while sending Email.";
                            // Handle the error or provide feedback to the user
                            echo $error_message;
                        } else {

                            header("location: http://localhost/reReads/HTML/loginSignup/verify_email.php?email=". urlencode($email));
                            exit;
                        }
                    } else {
                        echo "Error updating verify code: " . mysqli_error($conn);
                    }
                }
            } else {
                echo "Something went wrong... cannot redirect!";
                // You can also output the exact error for debugging purposes
                // echo "Error: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Something went wrong... cannot prepare the statement!";
        }
    }

    mysqli_close($conn);
}
?>

<!-- HTML form remains the same -->



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
    style="background-image: url('../../assets/backgroundImage/download.jpeg')"
  >  
   <div class="wrapper">
    <div class="container main">
      <div class="row">
        <div class="col-md-6 side-image">
          <!-- Image -->
           <!-- <img src="../../assets/side_img.jpg" alt="Image1" id="Imagecontainer" />  -->
          <div class="text">
            <p>“Books are the mirrors of the soul.” <br><i>- Virginia Woolf</i></p>
          </div>
        </div>

        <div class="col-md-6 right">
          <!-- Form -->
          <form class="input-box" action="#" method="post">
            <div class="logo">
              <span class="re">re</span> <span class="Reads">Reads</span>
            </div>  
           
            <div class="input-field">
               <input
                class="input"
                type="text"
                name="name"
                required=""
                id="name"
                value="<?php echo isset($name) ? $name : ''; ?>" 
              
              />
              <label for="name">Enter your Full Name</label>
              <?php if (!empty($name_err)) { ?>
                <span class="error"><?php echo $name_err; ?></span>
              <?php } ?>
            </div>
            <div class="input-field">
               <input
                class="input"
                type="text"
                name="Address"
                required=""
                id="Address"
                value="<?php echo isset($address) ? $address : ''; ?>"
              
              />
              <label for="Address">Address</label>
              <?php if (!empty($address_err)) { ?>
                <span class="error"><?php echo $address_err; ?></span>
              <?php } ?>            </div>
             <div class="input-field">
              <input 
              name="email"
              type="text" 
              class="input" 
              id="email" 
              required="" 
              autocomplete="off" 
              value="<?php echo isset($email) ? $email : ''; ?>"
              />
             
              <label for="email">Email</label>
              <?php if (!empty($email_err)) { ?>
                  <span class="error"><?php echo $email_err; ?></span>
              <?php } ?>
            </div>
            <div class="input-field">
               <input
                class="input"
                type="text"
                name="PhoneNumber"
                required=""
                id="PhoneNumber"
                value="<?php echo isset($phoneNumber) ? $phoneNumber : ''; ?>"
              
              />
              <label for="PhoneNumber">PhoneNumber</label>
              <?php if (!empty($phoneNumber_err)) { ?>
                <span class="error"><?php echo $phoneNumber_err; ?></span>
              <?php } ?>
            </div>
            <div class="input-field">
              <input 
              type="password" 
              class="input" 
              id="password" 
              name="password"
              required="" />
              <label for="password">Password</label>
              <?php if (!empty($password_err)) { ?>
                <span class="error"><?php echo $password_err; ?></span>
              <?php } ?>
               <i
              class="far fa-eye left"
              id="togglePassword"
              style="margin-left: 280px; margin-top:-45px; cursor: pointer"
              ></i>

            </div>
            <br>
            <div class="input-field">
              <input 
              type="password" 
              class="input" 
              id="Cpassword" 
              name="confirm_Password"
              required="" />
              <label for="confirm_Password"> Confirm Password</label>
               <?php if (!empty($confirmPassword_err)) { ?>
                  <span class="error"><?php echo $confirmPassword_err; ?></span>
               <?php } ?>
               <i
              class="far fa-eye left"
              id="CtogglePassword"
              style="margin-left: 280px; margin-top:-45px; cursor: pointer"
              ></i>

            </div>
            
            <br>
            <div class="input-field">
              <input type="submit" class="submit" value=" Sign Up" />
            </div>
            <div class="signin">
              <span>  Already Sign In?<a href="../loginSignup/login.php">Log In Here</a></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

        <script src="../../JS/loginSignup/eyeicon.js"></script>
        <script src="../../JS/Background/background.js"></script>


  </body>
</html>




