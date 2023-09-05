
<?php
// Composer autoloader for PHPMailer

// require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

  require '../../PHPMailer/src/Exception.php';
  require '../../PHPMailer/src/PHPMailer.php';
  require '../../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true); // Enable exceptions

    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP();
    $mail->Mailer = "smtp";

    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "rereads3@gmail.com";
  // $mail->Password   = "reReads@32080";
    $mail->Password   = "ufevpubiqqvumlkc";

    $mail->isHTML(true);
    $mail->setFrom("rereads3@gmail.com", "reReads");
    // echo 'Message has been sent';

?>
