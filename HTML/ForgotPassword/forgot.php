<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>forget password</title>

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
        <form id="myForm" method="post" action="">
          <label>
            <u>Give Your Email To Recover the Account</u> <br /><br
          /></label>

          <input
            type="text"
            name="email"
            id="email"
            required=""
            placeholder="Enter your Email"
          />
          <br /><br />

          <br />
          <label style="font-size: small"
            >Verification Code will be sent on the mail you mentioned here. Make
            <br />sure you entered correct Email. Click on 'Send Code' and wait
            for <br />code in your Mail and entered to recover your
            account.</label
          >

          <br /><br />
          <button type="submit" id="code">Send Code</button>
        </form>
      </div>
    </main>
    <script src="../../JS/Background/background.js"></script>
  </body>
</html>
