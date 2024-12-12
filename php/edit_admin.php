<?php

if(isset($_GET['id']))
{$booking_id=$_GET ["id"];}

require 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare("UPDATE booking SET 
            user_id = ?, 
            room_id = ?, 
            booking_date = ?, 
            time_slot = ?, 
            status = ? 
            WHERE booking_id = ?");
           

        $stmt->execute([
            $_POST['user_id'],
            $_POST['room_id'],
            $_POST['booking_date'],
            $_POST['time_slot'],
            $_POST['status'],
            $booking_id
        ]);

        header("Location: booking.php");
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information System Department</title>

    <nav>       
        <ul>
            <li><a href="structure.html">Admin Dashboard</a></li>
            <li><a href="profile.html">Profile</a></li> 
            <li><a href="login.php">Switch Account</a></li>
            <li><a href="NotesPage.html">Notes</a></li>
        </ul>
    </nav>

    <style>
        .edit-form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1 class="heads">Edit Booking</h1>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="edit-form">
        <form method="POST">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="text" id="user_id" name="user_id" required>
            </div>

            <div class="form-group">
                <label for="room_id">Room ID:</label>
                <input type="text" id="room_id" name="room_id" required>
            </div>

            <div class="form-group">
                <label for="booking_date">Booking Date:</label>
                <input type="date" id="booking_date" name="booking_date" value="<?php echo htmlspecialchars($booking['booking_date']); ?>" required>
            </div>

            <div class="form-group">
                <label for="time_slot">Time Slot:</label>
                <input type="text" id="time_slot" name="time_slot" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option >Pending</option>
                    <option >Approved</option>
                    <option >Rejected</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">Update Booking</button>
        </form>
    </div>

</body>
</html>

