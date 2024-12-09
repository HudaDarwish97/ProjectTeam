<?php 
include_once dirname(__DIR__) . '../php/config.php'; 

// Start Session if not already started
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <title>IT College Room Booking | Login</title>
</head>

<body>
    <?php include_once 'navbar.php'; ?>

    <section class="signin-container">
        <div class="signin-box">
            <h2>Login</h2>
            
            <?php 
                // Display error or success messages from session if available
                if(isset($_SESSION['login_error'])) {
                    echo "<div class='error-message'>" . $_SESSION['login_error'] . "</div>";
                    unset($_SESSION['login_error']);
                }

                if(isset($_SESSION['registration_success'])) {
                    echo "<div class='success-message'>" . $_SESSION['registration_success'] . "</div>";
                    unset($_SESSION['registration_success']);
                }
            ?>
            
            <form class="signin-form" action="process_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="signin-btn">Sign In</button>
                <p class="signup-text">
                    Don't have an account? <a href="signup.php">sign up</a>
                </p>
            </form>
        </div>
    </section>
</body>

</html>
