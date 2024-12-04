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
$stmt->bind_param(str_repeat('s', count($params)), ...$params); 
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Browsing</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buildingSelect = document.getElementById('Building');
            const departmentSelect = document.getElementById('department');
            const floorSelect = document.getElementById('floor');
            const roomListSection = document.querySelector('.room-list-section');
            const mapImage = document.getElementById('map-image');

            // Event listeners for filter changes
            buildingSelect.addEventListener('change', updateRoomList);
            departmentSelect.addEventListener('change', updateRoomList);
            floorSelect.addEventListener('change', updateRoomList);

            function updateRoomList() {
                const building = buildingSelect.value;
                const department = departmentSelect.value;
                const floor = floorSelect.value;

                // Send an AJAX request to filter rooms
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'room_browsing.php?Building=' + building + '&department=' + department + '&floor=' + floor, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        roomListSection.innerHTML = xhr.responseText;
                    }
                };
                xhr.send();

                if (building === 'IT') {
            if (department === 'Computer Science') {
                if (floor === 'First Floor') {
                    mapImage.src = 'CS_first_floor_map.jpg'; 
                    mapImage.alt = 'Computer Science First Floor Map';
                } else if (floor === 'Second Floor') {
                    mapImage.src = 'CS_second_floor_map.jpg'; 
                    mapImage.alt = 'Computer Science Second Floor Map';
                } else if (floor === 'Ground Floor') {
                    mapImage.src = 'CS_ground_floor_map.jpg'; 
                    mapImage.alt = 'Computer Science ground Floor Map';
                } else {
                    mapImage.src = 'CS_department_map.jpg'; 
                    mapImage.alt = 'Computer Science Department Map';
                }
            } else if (department === 'Computer Engineering') {
                if (floor === 'First Floor') {
                    mapImage.src = 'CE_first_floor_map.jpg'; 
                    mapImage.alt = 'Computer Engineering First Floor Map';
                } else if (floor === 'Second Floor') {
                    mapImage.src = 'CE_second_floor_map.jpg'; 
                    mapImage.alt = 'Computer Engineering Second Floor Map';
                } else if (floor === 'Ground Floor') {
                    mapImage.src = 'CE_ground_floor_map.jpg'; 
                    mapImage.alt = 'Computer Engineer ground Floor Map';
                } else {
                    mapImage.src = 'CE_department_map.jpg'; 
                    mapImage.alt = 'Computer Engineering Department Map';
                }
            } else if (department === 'Information System') {
                if (floor === 'First Floor') {
                    mapImage.src = 'IS_first_floor_map.jpg'; 
                    mapImage.alt = 'Information System First Floor Map';
                } else if (floor === 'Second Floor') {
                    mapImage.src = 'IS_second_floor_map.jpg';
                    mapImage.alt = 'Information System Second Floor Map';
                } else if (floor === 'Ground Floor') {
                    mapImage.src = 'IS_ground_floor_map.jpg'; 
                    mapImage.alt = 'Information System ground Floor Map';
                } else {
                    mapImage.src = 'IS_department_map.jpg';
                    mapImage.alt = 'Information System Department Map';
                }
            } else {
                mapImage.src = 'Map.jpeg'; 
                mapImage.alt = 'IT Building Map';
            }
        } else {
            mapImage.src = ''; // Reset map if no building is selected
            mapImage.alt = '';
        }
    }
});
    </script>
</head>
<body>

    <a href="index.html" class="back-to-home">Back to Home</a>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="filter-group">
            <label for="Building">Building:</label>
            <select id="Building" name="Building">
                <option value="">Select Building</option>
                <option value="IT">IT - S40</option>
                <!-- Add more buildings here if needed -->
            </select>
        </div>

        <div class="filter-group">
            <label for="department">Department:</label>
            <select id="department" name="department">
                <option value="">Select Department</option>
                <option value="Computer Science">Computer Science: CS</option>
                <option value="Computer Engineering">Computer Engineering: CE</option>
                <option value="Information System">Information System: IS</option>
                <!-- Add more departments here if needed -->
            </select>
        </div>

        <div class="filter-group">
            <label for="floor">Floor:</label>
            <select id="floor" name="floor">
                <option value="">Select Floor</option>
                <option value="Ground Floor">Ground Floor</option>
                <option value="First Floor">First Floor</option>
                <option value="Second Floor">Second Floor</option>
            </select>
        </div>

        <button type="submit" id="filter-btn">Filter</button>
    </section>

    <!-- Map Image Section -->
    <section class="map-section">
        <img id="map-image" src="" alt="Map" class="img-fluid">
    </section>

    <!-- Room List Section -->
    <section class="room-list-section">
        <h2>Available Rooms</h2>
        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while($row = $result->fetch_assoc()): ?>
                    <li>
                        <h3><?php echo $row['room_name']; ?> (<?php echo $row['room_type']; ?>)</h3>
                        <p>Capacity: <?php echo $row['capacity']; ?></p>
                        <p>Department: <?php echo $row['department']; ?></p>
                        <p>Floor: <?php echo $row['floor']; ?></p>
                        <a href="room_details.php?room_id=<?php echo $row['room_id']; ?>">View Details</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No rooms available matching the selected criteria.</p>
        <?php endif; ?>
    </section>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
