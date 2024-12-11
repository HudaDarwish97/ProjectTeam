<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, Port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $_SESSION['user_id'];

// Fetch notifications for the logged-in user
$query = "SELECT notification_id, message, is_read, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($notificationId, $message, $isRead, $createdAt);

// Mark notifications as read if they haven't been read yet
if ($isLoggedIn) {
    include "db_connection.php";
    $updateQuery = "UPDATE notifications SET is_read = FALSE WHERE user_id = ? AND is_read = TRUE";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->execute([$userId]);
    $updateStmt->execute();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="notification.css">
</head>
<body>
    <h1>Notifications</h1>

    <?php if ($isLoggedIn): ?>
        <?php
        $fetch = "Select * from notifications WHERE user_id = ?";
        $Stmt = $conn->prepare($fetch);
        $Stmt->execute([$userId]);
        $updateStmt->execute();
        $notfications = $Stmt->fetchAll();
        
        if ($notfications):
            foreach ($notfications as $notification):
        ?>
                <div class="notification">
                    <p><strong>Message:</strong> <?php echo htmlspecialchars($notification['message']); ?></p>
                    <p><strong>Created At:</strong> <?php echo htmlspecialchars($notification['created_at']); ?></p>
                    <p><strong>Read Status:</strong> <?php echo $notification['is_read'] ? 'Read' : 'Unread'; ?></p>
                </div>
        <?php
            endforeach;
        else:
            echo "<p>No notifications found.</p>";
        endif;
        ?>
    <?php else: ?>
        <p>Please log in to view your notifications.</p>
    <?php endif; ?>

    <a href="javascript:history.back()">Go back</a>

    
</body>
</html>
