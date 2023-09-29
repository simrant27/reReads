<?php
// Sample PHP code to fetch notifications with unique images
$notifications = [
    [
        'user' => 'Simran',
        'time' => '2 mins ago',
        'message' => 'uploaded book',
        'image' => '../../assets/notification/simran.jpg',
    ],
    [
        'user' => 'Asmita',
        'time' => '5 mins ago',
        'message' => 'book uploaded',
        'image' => '../../assets/notification/asmita.jpg',
    ],
    [
        'user' => 'Anmol',
        'time' => '10 mins ago',
        'message' => 'book uploaded',
        'image' => '../../assets/notification/316962449_1326660321482108_7742947422449348448_n.jpg',
    ],
];
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
        <label for="notification-toggle" class="notification-icon">bell</label>
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
                        <a href="book-details.html"><?php echo $notification['message']; ?></a>
                        <button class="delete-button" onclick="deleteNotification(this)">Delete</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <script src="../../JS/notification/notification.js"></script>
</body>
</html>
