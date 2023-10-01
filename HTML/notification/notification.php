<?php
include "../../References/connection.php";

// Function to fetch notifications from the database
function fetchNotifications($conn) {
    $notifications = array();

    // Query to fetch notifications for newly added books
    $query = "SELECT users.fullName AS user,
                    users.user_img As image, 
                     books.book_name AS message, 
                     DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s') AS time 
              FROM books
              JOIN users ON books.user_id = users.user_id
              ORDER BY books.book_id DESC
              LIMIT 5"; // You can adjust the limit as needed

    $result = $conn->query($query);

    if ($result) {
        $count = $result->num_rows; // Count the number of notifications
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
    }

    return array($notifications, $count);
}

// Fetch notifications and count
list($notifications, $count) = fetchNotifications($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/notification/notification.css">
    <title>Notification System</title>
</head>
<body>
    <div class="header">
        <label for="notification-toggle" class="notification-icon icon-button">
            <span class="material-icons">notifications</span>
            <span class="icon-button__badge"><?php echo $count; ?></span>
        </label>
        <input type="checkbox" id="notification-toggle" class="notification-toggle">
        <div class="notification-dropdown">
            <h3 class="notification-title">Notifications</h3>
            <ul>
                <?php foreach ($notifications as $notification): ?>
                    <li>
                        <div class="notification-user">
                            <img src="<?php echo $notification['image']; ?>" alt="<?php echo $notification['user']; ?>">
                            <div class="user-details">
                                <span class="user-name"><?php echo $notification['user']; ?></span>
                                <span class="notification-time"><?php echo $notification['time']; ?></span>
                            </div>
                        </div>
                        <a href="book-details.html"><?php echo $notification['message']; ?> was Uploded</a>
                        <button class="delete-button" onclick="deleteNotification(this)">Delete</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <script src="../../JS/notification/notification.js"></script>
</body>
</html>
