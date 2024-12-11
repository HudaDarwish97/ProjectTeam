<?php
session_start();
include 'db_connection.php';


// Get form data
$comment_id = $_POST['comment_id'] ?? null;
$reply_text = $_POST['reply_text'] ?? null;
$user_id = $_SESSION['user_id'];
$room_id = $_POST['room_id'] ?? null;



// Validate inputs
// if (!$comment_id || !$reply_text || !$room_id) {
//     die("Missing required information");
// }

try {
    // Insert reply into database
    $stmt = $conn->prepare("INSERT INTO comment_replies (comment_id, user_id, reply_text) VALUES (:comment_id, :user_id, :reply_text)");
    
    $stmt->bindParam(':comment_id', $comment_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':reply_text', $reply_text);
    
    $stmt->execute();
    
    // Redirect back to room details page
    header("Location: ../views/room_details.php?room_id=" . $room_id);
    exit();
    
} catch (PDOException $e) {
    die("Error saving reply: " . $e->getMessage());
}
?> 
