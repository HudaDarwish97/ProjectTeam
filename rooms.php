<?php
// Include database connection
require 'db_connection.php';

// Fetch filters from GET parameters (sent via AJAX)
$building = isset($_GET['Building']) ? $_GET['Building'] : '';
$department = isset($_GET['department']) ? $_GET['department'] : '';
$floor = isset($_GET['floor']) ? $_GET['floor'] : '';

// Build the query with the filters
$query = "SELECT * FROM rooms WHERE 1=1";
$conditions = [];
$params = [];

if ($building) {
    $conditions[] = "building = ?";
    $params[] = $building;
}
if ($department) {
    $conditions[] = "department = ?";
    $params[] = $department;
}
if ($floor) {
    $conditions[] = "floor = ?";
    $params[] = $floor;
}

if (count($conditions) > 0) {
    $query .= " AND " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($query);
if (count($params) > 0) {
    // Bind parameters dynamically based on the number of conditions
    $stmt->bind_param(str_repeat('s', count($params)), ...$params); 
}
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="rooms.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php
            // Check if there are rooms available based on the filters
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="col-md-4">
                        <div class="card-container" onclick="toggleFlip(this)">
                            <div class="card room-card">
                                <!-- Front of the Card -->
                                <div class="card-front">
                                    <div class="room-image position-relative">
                                        <img src="' . $row['room_image'] . '" alt="Room" class="card-img-top img-fluid">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between align-items-center">
                                            ' . $row['room_name'] . '
                                            <i class="bi bi-bookmark save-icon"></i>
                                        </h5>
                                        <div class="room-info">
                                            <span class="room-type badge bg-primary">' . $row['room_type'] . '</span> <br>
                                            <span class="room-capacity"><i class="bi bi-people-fill"></i> x' . $row['capacity'] . '</span> <br>
                                        </div>
                                        <p class="card-text">' . $row['description'] . '</p>
                                        <a href="room_details.php?room_id=' . $row['room_id'] . '" class="btn btn-outline-primary btn-sm">Details</a>
                                    </div>
                                </div>

                                <!-- Back of the Card -->
                                <div class="card-back">
                                    <h5>Additional Information</h5>
                                    <p class="room-details">' . $row['extra_info'] . '</p>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>No rooms available at the moment based on the selected filters.</p>';
            }
            ?>
        </div>
    </div>

    <script>
        function toggleFlip(cardContainer) {
            const card = cardContainer.querySelector('.room-card');
            card.classList.toggle('flipped');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
