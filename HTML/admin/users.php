<?php
session_start();
include_once "../../References/connection.php";

// Function to fetch users from the database
function fetchUsers($conn)
{
    $users = array();
    // Query to fetch users
    $query = "SELECT
    users.fullName AS user_name,
    users.user_img AS image,
    users.address AS Address,
    users.email AS email,
    users.phoneNo AS Number,
    users.user_id AS user_id,
    GROUP_CONCAT(books.book_name SEPARATOR ', ') AS book_name,
     GROUP_CONCAT(books.images SEPARATOR ', ') AS book_img,
    GROUP_CONCAT(books.book_id SEPARATOR ', ') AS bookid
FROM
    users
LEFT JOIN
    books ON users.user_id = books.user_id
WHERE
    users.email != 'rereads3@gmail.com'
GROUP BY
    users.user_id, users.fullName, users.user_img, users.address, users.email, users.phoneNo
ORDER BY
    users.user_id DESC;

";

    $result = $conn->query($query);

    if ($result) {
        $count = $result->num_rows; // Count the number of users
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return array($users, $count);
}

// Function to delete a user
function deleteUser($conn, $userId)
{
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        return true; // Deletion successful
    } else {
        return false; // Deletion failed
    }
}

// Fetch users and count
list($users, $count) = fetchUsers($conn);

// Check if a delete request was made
if (isset($_POST['delete_user_id'])) {
    $userIdToDelete = $_POST['delete_user_id'];

    if (deleteUser($conn, $userIdToDelete)) {
        // Refresh the page or redirect to update the user list
        header('Location: http://localhost/reReads/HTML/admin/users.php');
        exit;
    } else {
        echo "Error deleting user.";
        header('Location: http://localhost/reReads/HTML/admin/users.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/admin/users.css">
    <title>Users</title>
</head>
<body id="bg-img" style="background-image: url('../../assets/backgroundImage/download5.jpeg')">
    <nav class="navbar">
        <?php include "../navbar/navbar.php";?>
    </nav>
    <div class="header_user">
        <h3 class="users-title">User List: No_of Users: <?php echo $count - 1 ?></h3>
        <?php foreach ($users as $user): ?>
            <ul>
                <!-- Inside the <li> for each user -->
                <li>
                    <div class="users-details">
                        <img src="<?php echo ($user['image'] == 0) ? '../../assets/profile_picture/default.png' : '../../assets/profile_picture/' . $user['image']; ?>" alt="<?php echo 'image'; ?>">
                        <div class="user-image">
                            <span class="user-name"><?php echo $user['user_name']; ?></span>
                        </div>
                    </div>
                    <a href="#" class="user-link" onclick="toggleBookDetails(<?php echo $user['user_id']; ?>)">
                        <div class="user-details">
                            <div class="user-detail"><?php echo $user['email']; ?></div>
                            <div class="user-detail"><?php echo $user['Address']; ?></div>
                            <div class="user-detail"><?php echo $user['Number']; ?></div>
                        </div>
                    </a>
                    <form method="POST">
                        <input type="hidden" name="delete_user_id" value="<?php echo $user['user_id']; ?>">
                        <button type="submit" class="delete-button" onclick="return confirmDelete()">Delete</button>
                    </form>
                </li>

            </ul>
            <?php if ($user['bookid'] != null): ?>
                <!-- Book details container -->
                <div class="book-details-container" id="book-details-<?php echo $user['user_id']; ?>">
                    <ul>
                       <?php foreach (explode(",", $user['book_img']) as $index => $bookImage): ?>
                        <li>
                            <div class="book-user">
                                <img src="../../assets/uploads/<?php echo trim($bookImage); ?>" alt="image">
                            </div>
                            <div class="book-details">
                                <a href="../singlepage/singlepage.php?book_id=<?php echo preg_split("/,/", $user['bookid'])[$index]; ?>">
                                    <span class="book-name"><?php echo preg_split("/,/", $user['book_name'])[$index]; ?></span>
                                </a>
                            </div>
                        </li>
                    <?php endforeach;?>


                    </ul>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
    <script src="../../JS/Background/background.js"></script>
     <script>
        function toggleBookDetails(userId) {
            var bookDetails = document.getElementById('book-details-' + userId);
            if (bookDetails.style.display === 'none' || bookDetails.style.display === '') {
                bookDetails.style.display = 'block';
            } else {
                bookDetails.style.display = 'none';
            }
        }
    </script>
    <script src="../../JS/homepage/conformdelete.js"></script>
</body>
</html>
