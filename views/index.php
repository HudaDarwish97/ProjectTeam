<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <title>Comments Section</title>
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body id="app">
    <div id="comment_section">
        <h3>Leave a Comment</h3>
        <form id="set_comment" method="POST" action="../php/save_comment.php"  >
            <textarea id="comment_text" name="comment_text"rows="5" placeholder="Write your comment here..." required></textarea>
            <button id="submitComment" type="submit" >Post Comment</button>
        </form>
        
        <div id="comments_display">
            <h4>All Comments:</h4>
            <ul id="comments_list">
                <!-- Comments will be dynamically added here -->
                <?php
                include "../php/db_connection.php";
                $stmt = $conn->prepare("SELECT 
            c.comment_id, 
            c.comment_text, 
            c.created_at, 
            u.user_name, 
            r.room_name 
        FROM 
            comments AS c
        JOIN 
            users AS u ON c.user_id = u.user_id
        JOIN 
            rooms AS r ON c.room_id = r.room_id
        ORDER BY 
            c.created_at DESC");
                $stmt->execute();
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
               
                foreach ($comments as $comment) {
                    echo "<li>";
                    echo "<p><strong>User:</strong> " . htmlspecialchars($comment['user_name']) . "</p>";
                    echo "<p><strong>Room:</strong> " . htmlspecialchars($comment['room_name']) . "</p>";
                    echo "<p><strong>Comment:</strong> " . htmlspecialchars($comment['comment_text']) . "</p>";
                    echo "<p><strong>Posted At:</strong> " . htmlspecialchars($comment['created_at']) . "</p>";
                    echo "</li><hr>";
                }

                ?>
            </ul>
        </div>
    </div>
 
</body>
</html>