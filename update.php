<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@uob.edu')) {
        echo "Invalid UoB email address.";
        exit;
    }

    // Update profile picture if provided
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['profile_picture']['type'], $allowed_types)) {
            echo "Invalid image type.";
            exit;
        }

        $upload_dir = 'uploads/';
        $file_name = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
        $upload_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->execute([$file_name, $user_id]);
        } else {
            echo "Failed to upload image.";
            exit;
        }
    }

    // Update user details
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $user_id]);

    echo "Profile updated successfully!";
}
?>