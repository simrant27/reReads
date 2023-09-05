<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset password</title>

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
    <form method="POST" action="save_password.php" enctype="multipart/form-data">
       <label> <u>Change Password</u> <br><br></label>
                <input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
                <label for="password">Enter New Password</label>
                <input type="password" id="password" class= "form-control" placeholder="Enter New Password" name="password" required><br><br>
                <label style="font-size: small;">This can update your password. From now onwards use this password to login. <br>Remember not share your password with anyone else. Keep strong password <br>but make sure you had remembered or kept safe somewhere.</label>
            </div><br>

          <br /><br />
          <button type="submit" class="submit"  name="submit" id="code">Save Passsword</button>
        </form>
      </div>
    </main>
    <script src="../../JS/Background/background.js"></script>
  </body>
</html>
