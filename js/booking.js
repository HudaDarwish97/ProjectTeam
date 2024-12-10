document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    const conflictStatus = document.getElementById('conflict-status');

    // Check for conflicts when date or time changes
    ['date', 'start_time', 'end_time'].forEach(fieldId => {
        document.getElementById(fieldId).addEventListener('change', checkConflicts);
    });

    function checkConflicts() {
        const formData = new FormData(bookingForm);
        const date = formData.get('date');
        const startTime = formData.get('start_time');
        const endTime = formData.get('end_time');

        if (!date || !startTime || !endTime) {
            conflictStatus.innerHTML = `<div class="alert alert-warning"><i class="fas fa-exclamation-circle"></i> Please fill in all fields.</div>`;
            return;
        }

        fetch('check_conflicts.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            conflictStatus.innerHTML = data.hasConflict
                ? `<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> There is a booking conflict at this time.</div>`
                : `<div class="alert alert-success"><i class="fas fa-check-circle"></i> This time slot is available!</div>`;
        });
    }

    // Form submission handler
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const isLoggedIn = checkUserLoggedIn();
        if (!isLoggedIn) {
            alert("Please log in to confirm your booking.");
            window.location.href = 'login.html';
            return;
        }

        const messageDiv = document.getElementById('booking-message');
        const formData = new FormData(bookingForm);
        checkForConflict(formData).then(hasConflict => {
            messageDiv.classList.remove('d-none');
            messageDiv.className = hasConflict ? 'alert alert-danger' : 'alert alert-success';
            messageDiv.innerHTML = hasConflict
                ? '<i class="fas fa-exclamation-circle"></i> Cannot confirm booking due to conflict!'
                : '<i class="fas fa-check-circle"></i> Booking confirmed successfully!';

            if (!hasConflict) {
                document.getElementById('confirmBtn').disabled = true;
            }
        });
    });

    function checkUserLoggedIn() {
        return !!sessionStorage.getItem('userLoggedIn');
    }

    // Modify button listener
    document.getElementById('modifyBtn')?.addEventListener('click', function() {
        window.location.href = 'room_browsing.php';
    });

    // Cancel button listener
    document.getElementById('cancelBtn')?.addEventListener('click', function() {
        window.location.href = 'index.php';
    });

    // Function to check for conflicts via AJAX
    function checkForConflict(formData) {
        return new Promise((resolve, reject) => {
            fetch('check_conflicts.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                resolve(data.hasConflict);
            })
            .catch(error => {
                console.error('Error checking conflict:', error);
                resolve(false);
            });
        });
    }

    // Modal logic for displaying room details
    document.querySelectorAll('.room-image img').forEach(img => {
        img.addEventListener('click', function() {
            const modal = document.querySelector('.modal');
            const modalImg = modal.querySelector('img');
            const roomId = this.getAttribute('data-room-id');

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
});
