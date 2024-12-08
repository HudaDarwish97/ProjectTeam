<?php 
include_once dirname(__DIR__) . '/php/config.php';

// Start Session
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if form data is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect POST data from the form
    $username = trim($_POST['username']);
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

    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $errors[] = "All fields are required.";
    }

    // Check if email is valid and belongs to UoB
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_contains($email, '@uob.edu')) {
        $errors[] = "Please use a valid University of Bahrain email.";
    }

    // If no errors, proceed
    if (empty($errors)) {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement to insert the user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "Error registering account. Please try again.";
        }

        // Close the statement
        $stmt->close();
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
    <link rel="stylesheet" href="../styles/main.css">
    <title>Room Booking | Sign Up</title>
</head>

<body>
    <?php include_once '../components/navbar.php'; ?>
    <section class="signup-container">
        <div class="signup-box">
            <h2>Sign Up</h2>
            <?php 
                if(isset($_SESSION['error'])) {
                    echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }

                if(isset($_SESSION['success'])) {
                    echo "<div class='success-message'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                }
            ?>
            <form class="signup-form" action="register.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
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
                    Already have an account? <a href="<?php echo BASE_URL ?>/login">Log In</a>
                </p>
            </form>
        </div>
    </section>
</body>

</html>
