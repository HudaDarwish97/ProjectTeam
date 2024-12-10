<?php
session_start();

include '../php/db_connection.php';

// Retrieve room_id from GET parameters and validate it
$room_id = $_GET['room_id'] ?? null;
if (!$room_id) {
    die("Room ID is required.");
}

// Fetch room details
$query = $conn->prepare("SELECT * FROM rooms WHERE room_id = :room_id");
$query->bindParam(':room_id', $room_id);
$query->execute();
$room = $query->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    die("Room not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details - <?= htmlspecialchars($room['room_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">

<!-- Popper.js (required by Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/js/bootstrap.min.js"></script>

        
    <link rel="stylesheet" href="../css/room_details.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container d-flex justify-content-between align-items-center py-3">
            <h1 class="logo">IT Collage Room Booking</h1>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="room_browsing.php">Rooms</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about-us">About Us</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container my-5">
        <h1 class="text-center">Room Details</h1>

        <div class="card">
               <!-- Room Images Carousel -->
    <div id="roomImagesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../img/<?= htmlspecialchars($room['image1']) ?>" class="d-block w-100" alt="Room Image 1">
            </div>
            <?php if ($room['image2']) : ?>
                <div class="carousel-item">
                    <img src="../img/<?= htmlspecialchars($room['image2']) ?>" class="d-block w-100" alt="Room Image 2">
                </div>
            <?php endif; ?>
            <?php if ($room['image3']) : ?>
                <div class="carousel-item">
                    <img src="../img/<?= htmlspecialchars($room['image3']) ?>" class="d-block w-100" alt="Room Image 3">
                </div>
            <?php endif; ?>
            <?php if ($room['image4']) : ?>
                <div class="carousel-item">
                    <img src="../img/<?= htmlspecialchars($room['image4']) ?>" class="d-block w-100" alt="Room Image 4">
                </div>
            <?php endif; ?>
            <?php if ($room['image5']) : ?>
                <div class="carousel-item">
                    <img src="../img/<?= htmlspecialchars($room['image5']) ?>" class="d-block w-100" alt="Room Image 5">
                </div>
            <?php endif; ?>
        </div>

        <!-- Carousel controls inside the card -->
        <button class="carousel-control-prev" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>


<div class="card">
  <div class="card-header">
    <h5 class="card-title"><?= htmlspecialchars($room['room_name']) ?></h5>
  </div>
  <div class="card-body">
    <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($room['room_type']) ?></p>
    <p class="card-text"><strong>Department:</strong> <?= htmlspecialchars($room['department']) ?></p>
    <p class="card-text"><strong>Floor:</strong> <?= htmlspecialchars($room['floor']) ?></p>
    <p class="card-text"><strong>Capacity:</strong> <?= htmlspecialchars($room['capacity']) ?></p>
    <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($room['description']) ?></p>
    <h5 class="card-title">Features:</h5>
    <div class="features">
      <div>
        <i class="bi bi-wind"></i>
        <p>Air Conditioner</p>
      </div>
      <div>
        <i class="bi bi-projector"></i>
        <p>Projector</p>
      </div>
      <div>
        <i class="bi bi-wifi"></i>
        <p>WiFi</p>
      </div>
      <div>
        <i class="bi bi-easel"></i>
        <p>Whiteboard</p>
      </div>
    </div>
    <div class="button-group">
      <a href="booking.html?room_id=<?= $room['room_id'] ?>" class="btn btn-success">Book it</a>
      <a href="room_browsing.php" class="btn btn-secondary">Back to Browse</a>
    </div>
  </div>
</div>


    <script>
    var myCarousel = document.getElementById('roomImagesCarousel');
    var carousel = new bootstrap.Carousel(myCarousel);
</script>


<div class="card">    
    <!-- Noor comments section -->   
    <div id="comment_section">
        <h3>Leave a Comment</h3>
        <form id="set_comment" method="POST" action="../php/save_comment.php?room_id=<?php echo $room_id?>">
            <textarea id="comment_text" name="comment_text" rows="5" placeholder="Write your comment here..." required></textarea>
            <button id="submitComment" type="submit">Post Comment</button>
        </form>
        
        <div id="comments_display">
            <h4>All Comments:</h4>
            <ul id="comments_list">
                <!-- Comments will be dynamically added here -->
                <?php
                // Modify the query to include replies
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
                    WHERE 
                        c.room_id = ?
                    ORDER BY  
                        c.created_at DESC");
                $stmt->bindParam(1, $room_id, PDO::PARAM_INT);
                $stmt->execute();
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
               
                foreach ($comments as $comment) {
                    echo "<li class='comment-item'>";
                    echo "<div class='user-comment'>";
                    echo "<p><strong>User:</strong> " . htmlspecialchars($comment['user_name']) . "</p>";
                    echo "<p><strong>Comment:</strong> " . htmlspecialchars($comment['comment_text']) . "</p>";
                    echo "<p><small>Posted At: " . htmlspecialchars($comment['created_at']) . "</small></p>";
                    echo "</div>";
                    


                    
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin' ){
                    // Add reply form for each comment
                    echo "<div class='reply-form-container'>";
                    echo "<button class='btn btn-sm btn-primary show-reply-form'>Reply</button>";
                    echo "<form class='reply-form' style='display:none;' method='POST' action='../php/save_reply.php'>";
                    echo "<input type='hidden' name='comment_id' value='" . $comment['comment_id'] . "'>";
                    echo "<input type='hidden' name='room_id' value='" . $room_id . "'>";
                    echo "<textarea name='reply_text' class='form-control' rows='2' required></textarea>";
                    echo "<button type='submit' class='btn btn-sm btn-success mt-2'>Submit Reply</button>";
                    echo "</form>";
                    echo "</div>";
                }

                    // Display existing replies
                    $reply_stmt = $conn->prepare("SELECT 
                            r.reply_text,
                            r.created_at,
                            u.user_name
                        FROM 
                            comment_replies r
                        JOIN 
                            users u ON r.user_id = u.user_id
                        JOIN 
                            comments c ON c.comment_id = r.comment_id    
                        WHERE 
                            r.comment_id = ?
                        ORDER BY 
                            r.created_at ASC");
                    $reply_stmt->bindParam(1, $comment['comment_id']);
                    $reply_stmt->execute();
                    $replies = $reply_stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (!empty($replies)) {
                        echo "<div class='replies-container ml-4'>";
                        foreach ($replies as $reply) {
                            echo "<div class='reply'>";
                            echo "<p><strong>" . htmlspecialchars($reply['user_name']) . ":</strong> ";
                            echo htmlspecialchars($reply['reply_text']) . "</p>";
                            echo "<small>Replied at: " . htmlspecialchars($reply['created_at']) . "</small>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                    
                    echo "</li><hr>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<!--footer-->
<footer class="footer py-3">
    <div class="text-center">
        <p>&copy; 2024 IT College Room Booking System. All rights reserved.</p>
    </div>
</footer>


<script>
document.querySelectorAll('.show-reply-form').forEach(button => {
    button.addEventListener('click', function() {
        const form = this.nextElementSibling;
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
});
</script>
</body>
</html>