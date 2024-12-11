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
    <link rel="stylesheet" href="../css/firstask.css">


</head>
<body>

<?php include_once '../php/navbar.php'; ?>


    <div class="row">
        
        <!-- Department Filter -->
<div class="row text-center">
<div class="building-title text-center">IT Building - S40</div>
    <?php foreach ($departments as $department): ?>
        <div class="col-md-4 mb-3">
            <a href="?department=<?php echo htmlspecialchars($department); ?>" 
               class="department-card <?php echo strtolower($department) . '-department'; ?> text-decoration-none">
                <div class="p-3 rounded">
                    <h5 class="mb-2"><?php echo htmlspecialchars($department); ?> Department</h5>
                    <p class="mb-0">
                        <?php 
                        if ($department === 'CS') {
                            echo 'Book rooms for computer science classes and workshops.';
                        } elseif ($department === 'IS') {
                            echo 'Reserve space for information systems projects and labs.';
                        } else {
                            echo 'Find room for computer engineering lectures and events.';
                        }
                        ?>
                    </p>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>


<div class="col-md-8">
    <div class="room-carousel">
    <button class="carousel-arrow left" onclick="scrollCarousel(-1)">
        <i class="bi bi-chevron-left"></i>
    </button>
        <!-- Rooms container -->
        <div class="rooms-container">
            <?php if (!empty($rooms)): ?>
                <?php foreach ($rooms as $room): ?>
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
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">No rooms available in this department.</p>
                </div>
            <?php endif; ?>
        </div>
        <button class="carousel-arrow right" onclick="scrollCarousel(1)">
        <i class="bi bi-chevron-right"></i>
    </button>

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

<script>
function scrollCarousel(direction) {
    const container = document.querySelector('.rooms-container');
    const cardWidth = 300; // Width of a single card
    const gap = 20; // Gap between cards
    const scrollAmount = cardWidth + gap; // Total scroll per click
    container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}
</script>

</body>
</html>
