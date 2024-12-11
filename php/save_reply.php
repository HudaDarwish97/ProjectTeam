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
    
  
} catch (PDOException $e) {
    die("Error saving reply: " . $e->getMessage());
}

$te = "SELECT user_id AS id FROM comments WHERE comment_id = ?";
$ye = $conn->prepare($te);
$ye->execute([$comment_id]);
$fe = $ye->fetch(PDO::FETCH_DEFAULT);
$acc = $fe['id'];


$query = "INSERT INTO notifications (user_id, message, is_read, created_at) VALUES (:user_id, :message, :is_read, :created_at)";
    $ste = $conn->prepare($query);
   
    $ste->execute([
        ':user_id' => $acc ,
        ':message' => $reply_text,
        ':created_at' => $date,
        ':is_read' => False
    ]);


    // Redirect back to room details page
    header("Location: ../views/room_details.php?room_id=" . $room_id);
    exit();
    
?> 
