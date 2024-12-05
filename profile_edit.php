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

    // Validate name and email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Check if password fields are filled in
    if (!empty($old_password) || !empty($new_password) || !empty($confirm_password)) {
        // Fetch the current password hash from the database
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the old password
        if (!password_verify($old_password, $user['password_hash'])) {
            die("Current password is incorrect.");
        }

        // Validate the new password
        if (strlen($new_password) < 8) {
            die("New password must be at least 8 characters long.");
        }
        if ($new_password !== $confirm_password) {
            die("New password and confirmation do not match.");
        }

        // Hash the new password
        $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

        // Update the password in the database
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$new_password_hash, $user_id]);

        echo "Password updated successfully!";
    }

    // Update name and email
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $user_id]);

    echo "Profile updated successfully!";
}
?>