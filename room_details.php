<?php
require 'db_connection.php';

$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

// Use PDO to execute the query
$query = "SELECT * FROM rooms WHERE room_id = :room_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Room not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $room['room_name']; ?> Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="room_details.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="photos-section">
                    <img src="room1.jpg" alt="Room Image 1">
                    <img src="room2.jpg" alt="Room Image 2">
                    <img src="room3.jpg" alt="Room Image 3">
                    <img src="room4.jpeg" alt="Room Image 4">
                    <img src="room5.jpg" alt="Room Image 5">
                </div>
            </div>

            <div class="col-md-4">
                <div class="room-info">
                    <h3><?php echo $room['room_name']; ?> Details</h3>
                    <p><i class="bi bi-people-fill"></i> Capacity: <?php echo $room['capacity']; ?></p>
                    <p><i class="bi bi-door-open"></i> Room Type: <?php echo $room['room_type']; ?></p>
                    <h4>Features:</h4>
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
                </div>
            </div>
        </div>

        <div class="book-button">
    <a href="booking.html?room_id=<?php echo $room['room_id']; ?>" class="btn btn-primary">Book This Room</a>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close(); }
?>
