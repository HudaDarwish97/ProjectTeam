document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    const conflictStatus = document.getElementById('conflict-status');
    
    // Check for conflicts when date or time changes
    ['date', 'start_time', 'end_time'].forEach(fieldId => {
        document.getElementById(fieldId).addEventListener('change', checkConflicts);
    });

    function checkConflicts() {
        const formData = new FormData(bookingForm);
        if (!formData.get('date') || !formData.get('start_time') || !formData.get('end_time')) return;

        fetch('check_conflicts.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.hasConflict) {
                conflictStatus.innerphp = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> 
                        There is a booking conflict at this time.
                    </div>`;
            } else {
                conflictStatus.innerphp = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> 
                        This time slot is available!
                    </div>`;
            }
        });
    }

    // Form submission handler
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Check if the user is logged in
        const isLoggedIn = checkUserLoggedIn(); // Implement this function to check login status

        if (!isLoggedIn) {
            alert("Please log in to confirm your booking."); // Alert message
            window.location.href = 'login.html'; // Redirect to login page
            return;
        }

        // Call the checkForConflicts function here
        checkForConflicts(); // Ensure this is called to check for conflicts before confirming

        // The rest of your form submission logic...
    });

    // Function to check if the user is logged in
    function checkUserLoggedIn() {
        // This function should return true if the user is logged in, false otherwise
        // You can implement this based on your authentication logic
        // For example, check if a session variable or a token exists
        return !!sessionStorage.getItem('userLoggedIn'); // Example using sessionStorage
    }

    // Add modify button listener
    document.getElementById('modifyBtn').addEventListener('click', function() {
        window.location.href = 'room_browsing.php';
    });

    // Add cancel button listener
    
    // Placeholder function - implement actual conflict checking logic
    function checkForConflict() {
        // This should be replaced with your actual conflict checking logic
        // For now, it returns a random boolean
        return Math.random() < 0.5;
    }

    document.querySelectorAll('.room-image img').forEach(img => {
        img.addEventListener('click', function() {
            const modal = document.querySelector('.modal');
            const modalImg = modal.querySelector('img');
            const roomId = this.getAttribute('data-room-id');
            
            // Fetch and display room number and description
            fetch(`get_room_details.php?room_id=${roomId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('room-number').textContent = data.room_number;
                        document.getElementById('room-description').textContent = data.description;
                    }
                })
                .catch(error => console.error('Error:', error));

            modal.classList.add('active');
            modalImg.src = this.src;
        });
    });

    document.querySelector('.modal-close').addEventListener('click', function() {
        document.querySelector('.modal').classList.remove('active');
    });

    document.querySelector('.modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });

    function checkForConflicts() {
        console.log("Checking for conflicts..."); // Debugging line
        const formData = new FormData(document.getElementById('bookingForm'));
        
        fetch('../php/check_conflicts.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.conflict) {
                document.getElementById('conflict-message').classList.remove('d-none');
                document.getElementById('no-conflict-message').classList.add('d-none');
            } else {
                document.getElementById('no-conflict-message').classList.remove('d-none');
                document.getElementById('conflict-message').classList.add('d-none');
            }
            document.getElementById('booking-message').innerText = data.message;
            document.getElementById('booking-message').classList.remove('d-none');
        })
        .catch(error => console.error('Error:', error));
    }
});
