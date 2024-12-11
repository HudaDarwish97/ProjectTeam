<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>IT Collage Room Booking</title>
        <link  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="../css/booking.css">

    </head>
    <body>
        
    <?php include_once '../php/navbar.php'; ?>


       <!-- Room Booking Section -->
   <main class="container">
        <h2 class="page-title">Booking</h2>
           <!--Modal for Room Details  -->

        <form id="bookingForm" action="../php/check_conflicts.php" method="POST">
            <div class="time">
                <h4>Booking Time:</h4>
                <input type="hidden" id="room_id" name="room_id">
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required min="{{ today }}">
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

            <div class="conflict-status" >
                <h4>Conflict Status: </h4>
                <div id="no-conflict-message" class="alert alert-success d-none">
                    <i class="fas fa-check-circle"></i> There is no conflict
                </div>
                <div id="conflict-message" class="alert alert-danger d-none">
                    <i class="fas fa-exclamation-circle"></i> There is a conflict
                </div>
                <div id="booking-message" class="alert d-none"></div>
            </div>
            <script>
                document.getElementById('bookingForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission
                    if (!isLoggedIn()) { // Check if the user is logged in
                        alert('Please log in to confirm your booking.'); // Alert message
                        return; // Exit the function
                    }
                    // Call a function to check for conflicts
                    checkForConflicts();
                });

                function isLoggedIn() {
                    // Implement your logic to check if the user is logged in
                    // For example, check a session variable or a cookie
                    return false; // Change this to your actual login check
                }
            </script>

            <div class="actions mt-4">
             <button type="submit" class="confirm-btn" id="confirmBtn">Confirm</button>
               <a href="room_browsing.php" class="btn modify-btn" id="modifyBtn">Modify </a>
            </div>
        </form>
    </main>

    <!--footer-->
    <footer class="footer py-3">
        <div class="text-center">
            <p>&copy; 2024 IT Collage Room Booking System. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/booking.js"></script>
    
    <div class="modal">
        <span class="modal-close">&times;</span>
        <img src="" alt="Modal Image">
    </div>
    
   
    </body>
</html>
