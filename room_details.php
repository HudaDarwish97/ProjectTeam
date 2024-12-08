<?php
include 'db_connection.php';

$room_id = $_GET['room_id'] ?? null;

if (!$room_id) {
    die("Room ID is required.");
}

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
        <title>IT Collage Room Booking</title>
        <link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="booking.css">

    </head>
    <body>
        <!--header -->
        <header class="header">
            <div class="container d-flex justify-content-between align-items-center py-3">
                <h1 class="logo">IT Collage Room Booking</h1>
                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="homepage.html" >Home </a></li>
                        <li class="nav-item"><a class="nav-link" href="login.html" >Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.html" >Register </a></li>
                        <li class="nav-item"><a class="nav-link" href="#features" >Features </a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact" >Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about-us" >About Us</a></li>

                    </ul>
                </nav>
            </div>
        </header>


    <div class="card">
        <!-- Room Images Carousel -->
        <div id="roomImagesCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="uploads/<?= htmlspecialchars($room['image1']) ?>" class="d-block w-100" alt="Room Image 1">
                </div>
                <?php if ($room['image2']) : ?>
                    <div class="carousel-item">
                        <img src="uploads/<?= htmlspecialchars($room['image2']) ?>" class="d-block w-100" alt="Room Image 2">
                    </div>
                <?php endif; ?>
                <?php if ($room['image3']) : ?>
                    <div class="carousel-item">
                        <img src="uploads/<?= htmlspecialchars($room['image3']) ?>" class="d-block w-100" alt="Room Image 3">
                    </div>
                <?php endif; ?>
                <?php if ($room['image4']) : ?>
                    <div class="carousel-item">
                        <img src="uploads/<?= htmlspecialchars($room['image4']) ?>" class="d-block w-100" alt="Room Image 4">
                    </div>
                <?php endif; ?>
                <?php if ($room['image5']) : ?>
                    <div class="carousel-item">
                        <img src="uploads/<?= htmlspecialchars($room['image5']) ?>" class="d-block w-100" alt="Room Image 5">
                    </div>
                <?php endif; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($room['room_name']) ?></h5>
            <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($room['room_type']) ?></p>
            <p class="card-text"><strong>Department:</strong> <?= htmlspecialchars($room['department']) ?></p>
            <p class="card-text"><strong>Floor:</strong> <?= htmlspecialchars($room['floor']) ?></p>
            <p class="card-text"><strong>Capacity:</strong> <?= htmlspecialchars($room['capacity']) ?></p>
            <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($room['description']) ?></p>
            <h5>Features:</h5>
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
            <a href="booking.html?room_id=<?= $room['room_id'] ?>" class="btn btn-success">Book it</a>
            <a href="room_browsing.php" class="btn btn-secondary">Back to Browse</a>
        </div>
    </div>
    <div class="card">    <!-- Noor comments saction -->    </div>
</div>

<!--footer-->
<footer class="footer py-3">
        <div class="text-center">
            <p>&copy; 2024 IT Collage Room Booking System. All rights reserved.</p>
        </div>
    </footer>

    <script src="booking.js"></script>
    
    <div class="modal">
        <span class="modal-close">&times;</span>
        <img src="" alt="Modal Image">
    </div>
    
</body>
</html>
