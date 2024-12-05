<?php
session_start();
include 'db_connection.php'; // Include database connection file

$user_id = $_SESSION['user_id'];

// Fetch user info from the database
$query = "SELECT name, email, profile_picture FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute([':user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="profile-view-container">
        <h1>User Profile</h1>
        <img src="<?= $user['profile_picture'] ?>" alt="Profile Picture" class="profile-picture">
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <a href="profile_edit.html">Edit Profile</a>
    </div>
</body>
</html>