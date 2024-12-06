function validateForm() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }

    // Email validation (e.g., ensure UoB domain for email)
    const email = document.getElementById('email').value;
    if (!email.endsWith("@uob.edu")) {
        alert("Please use a UoB email address.");
        return false;
    }

    return true;
}
