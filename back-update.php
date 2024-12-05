<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $profile_image = $_FILES['profile_image'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Handle profile image upload
    if (isset($profile_image) && $profile_image['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2 MB

        $file_tmp = $profile_image['tmp_name'];
        $file_name = basename($profile_image['name']);
        $file_size = $profile_image['size'];
        $file_type = mime_content_type($file_tmp);

        // Validate file type and size
        if (!in_array($file_type, $allowed_types)) {
            die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
        }

        if ($file_size > $max_size) {
            die("File size exceeds 2 MB.");
        }

        // Generate a unique file name to prevent overwriting
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid('profile_', true) . '.' . $file_ext;

        // Move the uploaded file to the uploads directory
        $file_path = $upload_dir . $new_file_name;
        if (!move_uploaded_file($file_tmp, $file_path)) {
            die("Failed to upload the profile image.");
        }

        // Update the user's profile image in the database
        $stmt = $pdo->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
        $stmt->execute([$file_path, $user_id]);
    }

    // Handle password change
    if (!empty($old_password) || !empty($new_password) || !empty($confirm_password)) {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($old_password, $user['password_hash'])) {
            die("Current password is incorrect.");
        }

        if (strlen($new_password) < 8) {
            die("New password must be at least 8 characters long.");
        }

        if ($new_password !== $confirm_password) {
            die("New password and confirmation do not match.");
        }

        $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$new_password_hash, $user_id]);
    }

    // Update name and email
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $user_id]);

    echo "Profile updated successfully!";
}
?>