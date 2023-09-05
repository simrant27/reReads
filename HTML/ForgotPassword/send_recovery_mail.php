<?php
include "mail.php";
require_once "../../References/connection.php";

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             header("location: http://localhost/reReads/HTML/ForgotPassword/recover.php?email=invalid");
                    exit;
            $error_message = "Invalid email format";
        } else {
            $code = rand(100000, 999999);
            $sql = "SELECT * FROM `users` WHERE `email` = ?";
            echo gettype($code);

        $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $update_sql = "UPDATE `users` SET `code` = ? WHERE `email` = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "is", $code, $email);
                mysqli_stmt_execute($update_stmt);

                $mail->AddAddress($email);
                $mail->AddReplyTo($email);

                $subject = "Account Recovery Code!";
                $mail->Subject = $subject;

                $content = "<b>The code to reset your password for the account in reReads website is $code</b>";
                $mail->MsgHTML($content);

                if (!$mail->Send()) {
                    $error_message = "Error while sending Email.";
                } else {
                    header("location: http://localhost/reReads/HTML/ForgotPassword/recover.php?email=$email");
                    exit;
                }
            } else {
                // Email not found
                    header("location: http://localhost/reReads/HTML/ForgotPassword/recover.php?email=notfound");

                $error_message = "Email not found";
            }
        }
    } else {
        // Email not provided
        header("location: http://localhost/reReads/HTML/ForgotPassword/recover.php?email=missing");

        $error_message = "Email Missing / Enter your email";
    }
}

?>
