<?php  
// Start Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once dirname(__DIR__) . '/php/config.php';

// Check if form data is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect POST data from the form
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Initialize error array
    $errors = [];

    // Validate input
    if (empty($email) || empty($password)) {
        $errors[] = "Both email and password are required.";
    }

    // If no errors, proceed with login
    if (empty($errors)) {
        try {
            // Database connection using PDO for enhanced error handling
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if user exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE user_email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // If user is found and password matches
            if ($user && password_verify($password, $user['user_password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['user_role'] = $user['user_role'];

                // Login success
                $_SESSION['success'] = "Login successful. Welcome back, " . $user['user_name'] . "!";
                header("Location: ../index.php"); // Redirect to dashboard
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: <php>login.php"); // Redirect back to login
                exit();
            }
        } catch (PDOException $e) {
            // Handle errors
            $_SESSION['error'] = "Database error: " . $e->getMessage();
            header("Location: login.php");
            exit();
        }
    } else {
        // Store errors in session and redirect back
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/firstask.css">
    <title>IT Room Booking | Login</title>
</head>
<body>
    <?php include_once '../php/navbar.php'; ?>
    <section class="signin-container">
        <div class="signin-box">
            <h2>Login</h2>
            <?php 
                // Display error or success messages
                if (isset($_SESSION['error'])) {
                    echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }

                if (isset($_SESSION['success'])) {
                    echo "<div class='success-message'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                }
            ?>
            <form class="signin-form" action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <form action="index.php" method="get">
                   <button type="submit" class="signin-btn">Log In</button>
                </form>
                <p class="signup-text">
                    Don't have an account? <a href="register.php">Sign Up</a>
                </p>
            </form>
        </div>
    </section>
</body>
</html>
