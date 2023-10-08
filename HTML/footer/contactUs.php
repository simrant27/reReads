<?php
include_once "../../References/connection.php";

if (isset($_POST['contact'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required.";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO contactUs (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>contact us</title>
</head>
<body>
<div class="container">
            <h1>Contact Us</h1>
            <p>If you have any questions, feedback, or inquiries, please feel free to contact us using the form below or through our contact information.</p>

            <!-- Contact Form ) -->
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="contact">Send Message</button>
                </div>
            </form>
        </div>
</body>
</html>
