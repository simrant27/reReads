<?php
include "mail.php";
require_once "../../References/connection.php";

$email = $_POST['email'];
$newPassword = $_POST['password'];
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];

    $updateSql = "UPDATE users SET password = ? WHERE user_id = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($updateStmt, "si", $hashedPassword, $user_id);
    
    if (mysqli_stmt_execute($updateStmt)) {
        // Password updated successfully
        
        // Sending Mail
        $mail->AddAddress($email);
        $mail->AddReplyTo($email);

        $subject = "Password Updated Successfully!";
        $mail->Subject = $subject;

        $content = "Your password has been updated. From now onwards, use the updated password to login. 
        Remember not to share your password with anyone else. Keep a strong password 
        but make sure you remember it or keep it safe somewhere.<br>";

        $mail->MsgHTML($content); 
        if (!$mail->Send()) {
            echo "Error while sending Email.";
            var_dump($mail);
        } else {
            header("location:http://localhost/reReads/HTML/ForgotPassword/all_done.php?user_id=$user_id");
            exit();
        }
    } else {
        echo "Error updating password.";
    }
} else {
    echo "User not found.";
}

mysqli_close($conn);
?>
