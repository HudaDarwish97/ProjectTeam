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
        

       <!-- Room Booking Section -->
    <main class="container">
        <h2 class="page-title">Booking</h2>
      <div class="content">
           <!--Modal for Room Details  -->
<div class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2 id="room-number"></h2>
        <p id="room-description"></p>
        <img src="" alt="Room Image">
    </div>
</div>

<!-- Room Images -->
<div class="room-images">
    <div class="room-image">
        <img src="room1.jpg" alt="Room 1" data-room-id="1">
    </div>
    <div class="room-image">
        <img src="room2.jpg" alt="Room 2" data-room-id="2">
    </div>
</div>
        

        <form id="bookingForm">
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
            

            <div class="actions mt-4">
             <button type="submit" class="confirm-btn" id="confirmBtn">Confirm</button>
               <a href="room_browsing.php" class="btn modify-btn">Modify </a>
               <a href="index.php" class="btn cancel-btn"> Cancel </a>
              </div>
        </form>
    </main>

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
