<?php
session_start();
$message = ""; // Initialize message variable
$messageClass = ""; // Initialize message class variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    include_once '../php/process_booking.php'; // Include the booking processing logic
    $result = processBooking(); // Call the function to process booking

    // Check if $result is an array
    if (is_array($result)) {
        $message = $result['message']; // Get the message
        $messageClass = $result['class']; // Get the class for styling
    } else {
        // Handle unexpected return type
        $message = "Unexpected error occurred.";
        $messageClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Collage Room Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/booking.css">
    <style>
        .message {
            font-size: 1.2em; /* Default size */
            display: none; /* Hide by default */
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
            font-size: 1.5em; /* Larger size for error messages */
        }
    </style>
</head>
<body>
<?php include_once '../php/navbar.php'; ?>
    <h1>Room Booking</h1>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <p style="color: red;">You must log in to confirm the booking.</p>
    <?php endif; ?>
    <?php if ($message): ?>
        <p class="message <?php echo $messageClass; ?>" style="display: block;"><?php echo htmlspecialchars($message); ?></p> <!-- Display the message here -->
    <?php endif; ?>
        <form  id="bookingForm" method="POST" action="">
        <div class="time">
                <h4>Booking Time:</h4>
                <input type="hidden" id="room_id" name="room_id">
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="booking_date" required min="{{ today }}">
                 <script>
                   document.addEventListener('DOMContentLoaded', function() {
                    const today = new Date().toISOString().split('T')[0];
                  document.getElementById('date').setAttribute('min', today);    });
                  </script>
                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" name="start_time" required min="08:00" max="23:00">
                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" name="end_time" required min="08:00" max="23:00">
            </div>


        
        <button type="submit" class="confirm-btn" id="confirmBtn" name="confirm" <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>Confirm</button>
        <a href="room_browsing.php" class="btn modify-btn" id="modifyBtn">Modify </a>
        </form>
</body>
</html>
