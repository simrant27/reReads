<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recovery password</title>
    <link rel="stylesheet" href="../../CSS/ForgotPassword/forgot.css">
</head>
<body id="bg-img" style="background-image: url('../../assets/backgroundImage/download5.jpeg')">
    <main id="mainAll">
        <div class="logo">
            <span class="re">re</span> <span class="Reads">Reads</span>
        </div>
        <br /><br />
        <div>
            <?php
            $email = $_GET['email'];
            if ($email == 'null') {
                ?>
                <p>Account with that email was not found.</p>
                <p>Email not matched. Please try entering it correctly.</p>
                <a href="forget.php">
                    <input type="submit" class="submit" value="Re-enter Email" name="submit">
                </a>
                <?php
            } else {
                ?>
                <p>Email has been sent to your email address.</p>
                <p>Check your email and enter the recovery code below.</p>
                <?php
            }
            ?>
        </div>
        <div>
            <form method="POST" action="check_code.php" enctype="multipart/form-data">
                <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                <label><u>Enter Account Recovery Code</u></label><br><br>
                <label for="code">Your Code (6 digits):</label>
                <input type="text" id="code" class="form-control" placeholder="Recovery Code" name="code" required><br><br>
                <label style="font-size: small;">Verification Code has been sent to your email. Please enter it here.
                    Make sure you entered the correct code.
                    If you didn't receive the code, click "Re-Send Code" below.</label><br><br>
                <a href="forgot.php">Re-Send Code</a><br><br>
                <button type="submit" class="submit" name="submit" id="code">Submit Code</button>
            </form>
        </div>
    </main>
    <script src="../../JS/Background/background.js"></script>
</body>
</html>
