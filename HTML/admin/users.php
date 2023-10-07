<?php
include_once "../../References/connection.php";

// Function to fetch users from the database
function fetchUsers($conn)
{
    $users = array();
    // Query to fetch users
    $query = "SELECT users.fullName AS user_name,
                 users.user_img AS image,
                 users.address AS Address,
                 users.email AS email,
                 users.phoneNo AS Number,
                 users.user_id AS user_id,
                 books.images AS image_book,
                 books.book_name AS book_name,
                 books.user_id AS user_book_id,
                 books.book_id AS bookid
          FROM users
          JOIN books 
          WHERE users.email != 'rereads3@gmail.com'
          ORDER BY users.user_id DESC";

    $result = $conn->query($query);

    if ($result) {
        $count = $result->num_rows; // Count the number of users
        while ($row = $result->fetch_assoc()) {
            $row['image_data'] = base64_decode($row['image']); // Decode base64 image data
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
        <?php include "../navbar/navbar.php"; ?>
    </nav>
    <div class="header_user">
        <h3 class="users-title">User List: No_of Users: <?php echo $count ?></h3>
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
                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                    </li>

            </ul>
                    <?php 
                    if ($user['user_book_id'] == $user['user_id']): ?>
                        <!-- Book details container -->
                        <div class="book-details-container" id="book-details-<?php echo $user['user_id']; ?>">
                            <ul>
                                <li>
                                    <div class="book-user">
                                        <img src="../../assets/uploads/<?php echo $user['image_book']; ?>" alt="<?php echo $user['user_name']; ?>">
                                    </div>
                                    <div class="book-details">
                                       <a href="../singlepage/singlepage.php?book_id=<?php echo $user['bookid'];?>">
                                        <span class="book-name"><?php echo $user['book_name']; ?></span>
                    </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <?php 
                endif; ?>
            
        <?php endforeach; ?>
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
   
</body>
</html>
