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
    $updateQuery = "UPDATE notifications SET is_read = TRUE WHERE user_id = ? AND is_read = FALSE";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(245, 245, 220);
            margin: 0;
            padding: 30px 30px 30px 30px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;            color: #333; /* Slightly lighter for readability */
        }

        h1 {
            text-align: left;
            color: #333;
            margin: 20px 0;
           
        }

        .notification-container {
            max-width: 800px;
            width: 100%; /* Make it responsive */
            margin: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 0px;
            margin-left: 20px;
        }

        .notification {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 5px 15px;
            display:flex;
            flex-direction: column;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 50%;
            transition: transform 0.2s ease; /* Smooth hover effect */
        }

        .notification:hover {
            transform: translateY(-2px); /* Lift the notification on hover */
        }

        .notification p {
            margin: 5px 0;
        }

        .notification p strong {
            color: rgb(87, 81, 81);
        }

        .unread {
            background-color: rgb(188, 31, 31);
            color: white;
        }

        .read {
            background-color: rgb(245, 245, 220);
        }

        a {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 15px;
            background-color: rgb(87, 81, 81);
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: black;
        }
        .no-notifications {
            text-align: left;
            color: #666;
            font-size: 18px;
            margin-left: 30px;
        }

    </style>
</head>
<body>
    <h1>Notifications</h1>
<div>
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

    </div>
</body>
</html>
