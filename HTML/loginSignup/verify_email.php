<?php
if (isset($_GET['email'])) {
    $email = urldecode($_GET['email']);
    // Now, $email contains the email passed from signup.php
} else {
    // Handle the case when the email parameter is not provided in the URL
    echo "Email parameter missing.";
}


if (isset($_POST["verify"])) {

    // Match email and Code
    require_once "../../References/connection.php";
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $dbOTP = $row['verify_email'];
            
            $otp_code = $_POST['otp_code'];

            if ($dbOTP != $otp_code) {
                $error_message = "Invalid OTP code "; // Corrected the variable here
            } else {
                $msg = "Verification complete, you may sign in now";
                header("location: http://localhost/reReads/HTML/loginSignup/login.php");
                exit;
            }
        } else {
            $error_message = "Email not found in the database $email sksjd" ;
        }
    } else {
        $error_message = "Error executing SQL query: " . mysqli_error($conn);
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>All done!</title>
    <link rel="stylesheet" href="../../CSS/ForgotPassword/forgot.css"/>
</head>
<body id="bg-img" style="background-image: url('../../assets/backgroundImage/download5.jpeg')">
<main id="mainAll">
    <div class="logo">
        <span class="re">re</span> <span class="Reads">Reads</span>
    </div>
    <br/><br/>

    <form method="POST" action="#" enctype="multipart/form-data">
        <label><u>Enter a verification code</u> <br/><br/></label>
        <input
                type="text"
                name="otp_code"
                required
                autofocus
                placeholder="Enter your OTP code"
        />
        <br/>
        <?php if (!empty($error_message)) { ?>
            <span class="error"><?php echo $error_message; ?></span>
        <?php } ?>
        <br>
        <span>
            <button type="submit" class="submit" name="verify" id="code">Verify</button>
        </span>
    </form>
</main>
<script src="../../JS/Background/background.js"></script>
</body>
</html>


