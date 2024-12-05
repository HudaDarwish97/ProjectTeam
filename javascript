document.querySelector('form').addEventListener('submit', function (e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const profilePicture = document.getElementById('profile_picture').files[0];
    const oldPassword = document.getElementById('old_password').value.trim();
    const newPassword = document.getElementById('new_password').value.trim();
    const confirmPassword = document.getElementById('confirm_password').value.trim();

    if (!name || !email) {
        alert("Please fill in all required fields.");
        e.preventDefault();
        return;
    }

    if (!email.endsWith('@uob.edu')) {
        alert("Email must be a UoB email address.");
        e.preventDefault();
        return;
    }

    if (profilePicture && !['image/jpeg', 'image/png', 'image/gif'].includes(profilePicture.type)) {
        alert("Invalid image file type.");
        e.preventDefault();
    }
    if (newPassword || confirmPassword || oldPassword) {
        if (!oldPassword) {
            alert("Please enter your current password.");
            e.preventDefault();
            return;
        }

        if (newPassword.length < 8) {
            alert("New password must be at least 8 characters long.");
            e.preventDefault();
            return;
        }

        if (newPassword !== confirmPassword) {
            alert("New password and confirmation do not match.");
            e.preventDefault();
        }
    }
});

