<?php
// Include the database connection
include '../php/db_connection.php';

// Define the departments for filtering
$departments = ['CS', 'IS', 'CE'];

// Get the selected department from the URL, default to 'CS' if not selected
$selected_department = $_GET['department'] ?? 'CS';

// Prepare and execute the SQL query to fetch rooms based on the selected department
try {
    $query = $conn->prepare("SELECT * FROM rooms WHERE department = :department");
    $query->bindParam(':department', $selected_department, PDO::PARAM_STR);
    $query->execute();
    $rooms = $query->fetchAll(PDO::FETCH_ASSOC);

    // If no rooms are found, set rooms to an empty array
    if (!$rooms) {
        $rooms = [];
    }
} catch (PDOException $e) {
    // Handle database errors gracefully
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Collage Room Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/room_browsing.css">
</head>
<body>

    <div class="row">
        <!-- Left Section: Department Filter -->
        <div class="col-md-4 left-section">
            <div class="building-title text-center">IT Building - S40</div>
            <div>
                <!-- Display department filter buttons -->
                <?php foreach ($departments as $department): ?>
                    <a href="?department=<?= htmlspecialchars($department) ?>" class="btn btn-<?= $department === $selected_department ? 'primary' : 'secondary' ?> w-100 department-btn">
                        <?= htmlspecialchars($department) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Right Section: Rooms -->
        <div class="col-md-8">
            <div class="row">
                <?php if (!empty($rooms)): ?>
                    <!-- Display each room in a card -->
                    <?php foreach ($rooms as $room): ?>
                        <div class="col-md-6">
                            <div class="room-card-container" onclick="toggleFlip(this)">
                                <div class="room-card">
                                    <!-- Front of the card -->
                                    <div class="card front">
                                        <img src="../img/<?= htmlspecialchars($room['image1'] ?? 'default_image.jpg') ?>" class="card-img-top" alt="Room Image">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="room-icon bi bi-door-closed"></i>
                                                <?= htmlspecialchars($room['room_name']) ?>
                                            </h5>
                                            <p class="card-text">
                                                <?= htmlspecialchars($room['description'] ?? 'No description available.') ?>
                                            </p>
                                            <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($room['room_type']) ?></p>
                                            <p class="card-text">
                                                <strong>Capacity:</strong> <?= htmlspecialchars($room['capacity']) ?>
                                            </p>
                                            <a href="room_details.php?room_id=<?= htmlspecialchars($room['room_id']) ?>" class="btn btn-primary">View Details</a>
                                        </div>
                                    </div>
                                    <!-- Back of the card -->
                                    <div class="card back">
                                        <h1>hello</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">No rooms available in this department.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!--footer-->
    <footer class="footer py-3">
        <div class="text-center">
            <p>&copy; 2024 IT Collage Room Booking System. All rights reserved.</p>
        </div>
    </footer>
    
    <script>
        function toggleFlip(cardContainer) {
            const card = cardContainer.querySelector('.room-card');
            card.classList.toggle('flipped');
        }
    </script>

</body>
</html>
