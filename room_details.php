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
    <title>Room Details - <?= htmlspecialchars($room['room_name']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center">Room Details</h1>

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
</body>
</html>
