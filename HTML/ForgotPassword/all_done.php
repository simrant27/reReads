<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>All done !</title>

    <link rel="stylesheet" href="../../CSS/ForgotPassword/forgot.css" />
  </head>
  <body
    id="bg-img"
    style="background-image: url('../../assets/backgroundImage/download5.jpeg')"
  >
    <main id="mainAll">
      <div class="logo">
        <span class="re">re</span> <span class="Reads">Reads</span>
      </div>
      <br /><br />

      <div>
   
 <label> <u>Hi! <?php echo $_GET['fullName']; ?> Your Password has Changed Successfully!</u> <br><br></label>
                <label style="font-size: small;">Your password has been updated. From now onwards use this password to login. <br>Remember not share your password with anyone else. Keep strong password <br>but make sure you had remembered or kept safe somewhere.</label>
                <br><br><br>
                <label style="color: red;"> Check out mail for your Security Updates!</label>
                <br>
                <a href="../../HTML/loginSignup/login.php" style="text-decoration: none;">
                    Login to begin!
                </a>    
      </div>
    </main>
    <script src="../../JS/Background/background.js"></script>
  </body>
</html>
