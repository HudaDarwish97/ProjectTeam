<?php
// Start the session
session_start();

// Include database connection
$pdo = new PDO('mysql:host=localhost;dbname=room_booking', 'root', '');

// Fetch user data from the database
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare('SELECT name, email, profile_picture FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set default picture if none is found
    if (empty($user['profile_picture'])) {
        $user['profile_picture'] = 'img/profile_pic.png'; 
    }
} else {
    // Redirect to login if no user is logged in
    header('Location: login.php');
    exit;
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $profile_picture = $user['profile_picture'];

    // Handle profile picture upload
    if (!empty($_FILES['profile_picture']['name'])) {
        $upload_dir = __DIR__ . '/uploads/';
        $file_name = time() . '_' . basename($_FILES['profile_picture']['name']);
        $upload_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_file)) {
            $profile_picture = $file_name;
        } else {
            $error = "Failed to upload profile picture.";
        }
    }

    // Update user data in the database
    $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, profile_picture = ? WHERE id = ?');
    $stmt->execute([$name, $email, $profile_picture, $user_id]);

    // Update session variables
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;

    $success = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: rgb(245, 245, 220);
            font-family: Arial, sans-serif;
        }

        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .profile-container img {
            display: block;
            margin: 20px auto;
            border-radius: 50%;
            object-fit: cover;
        }

        .btn-primary {
            background-color: rgb(87, 81, 81);
            border: none;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #6c6767;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-container">
            <h1 class="text-center">My Profile</h1>
            
            <!-- Display success or error messages -->
            <?php if (!empty($success)): ?>
                <div class="alert alert-success" role="alert"><?= $success ?></div>
            <?php elseif (!empty($error)): ?>
                <div class="alert alert-danger" role="alert"><?= $error ?></div>
            <?php endif; ?>

            <form action="profile.php" method="POST" enctype="multipart/form-data">
                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="name" 
                        name="name" 
                        value="<?= htmlspecialchars($user['name'] ?? '') ?>" 
                        placeholder="Enter your name"
                        required
                        aria-label="Name">
                </div>
                
                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="email" 
                        name="email" 
                        value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                        placeholder="Enter your email"
                        required
                        aria-label="Email">
                </div>
                
                <!-- Profile Picture Upload -->
                <div class="mb-3 text-center">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input 
                        type="file" 
                        class="form-control" 
                        id="profile_picture" 
                        name="profile_picture" 
                        accept="image/*"
                        aria-label="Upload Profile Picture">
                    
                    <!-- Profile Picture Preview -->
                    <img 
                        src="uploads/<?= htmlspecialchars($user['profile_picture']) ?>" 
                        alt="<?= htmlspecialchars($user['name'] ?? 'User') ?>'s Profile Picture" 
                        class="img-thumbnail mt-3" 
                        width="150">
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary" aria-label="Save Changes">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Live Preview of Uploaded Profile Picture
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.querySelector('.profile-container img');
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
