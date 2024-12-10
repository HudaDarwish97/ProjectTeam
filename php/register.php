<?php  
include_once dirname(__DIR__) . '/php/config.php';

// Start Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME,Port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect POST data from the form
    $fullname = trim($_POST['name']); // Full name
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $role = $_POST['role'];

    // Initialize error array
    $errors = [];

    // Validate input
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($fullname) || empty($email) || empty($password) || empty($role)) {
        $errors[] = "All fields are required.";
    }

    // Check if email is valid and belongs to UoB
    if (!preg_match("/@stu\.uob\.edu\.bh$/", $email)) {
        $errors[] = "Email must be a valid @stu.uob.edu.bh address.";
    }

    // If no errors, proceed
    if (empty($errors)) {
        try {
            // Database connection using PDO for enhanced error handling
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if user already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE user_email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $userExists = $stmt->fetchColumn();

            if ($userExists > 0) {
                $_SESSION['error'] = "Email is already registered.";
                header("Location: register.php");
                exit();
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert user into the database
            $stmt = $pdo->prepare("INSERT INTO users (user_name, user_email, user_password, user_role) VALUES (:fullname, :email, :password, :role)");
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            // Registration success
            $_SESSION['success'] = "Account created successfully. You can now log in.";
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            // Handle errors
            $_SESSION['error'] = "Database error: " . $e->getMessage();
            header("Location: register.php");
            exit();
        }
    } else {
        // Store errors in session and redirect back
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: register.php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/firstask.css">
    <title>Room Booking | Sign Up</title>
</head>

<body>
    <?php include_once '../php/navbar.php'; ?>
    <section class="signup-container">
        <div class="signup-box">
            <h2>Sign Up</h2>
            <?php 
                if (isset($_SESSION['error'])) {
                    echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }

                if (isset($_SESSION['success'])) {
                    echo "<div class='success-message'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                }
            ?>
            <form class="signup-form" action="register.php" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email (UoB only)</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="signup-btn">Sign Up</button>
                <p class="signup-text">
                    Already have an account? <a href="login.php">Log In</a>
                </p>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 IT College</p>
    </footer>

    <script src="/PROJECTTEAM/js/script.js"></script>
</body>

</html>
