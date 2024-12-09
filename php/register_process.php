<?php
// if (session_status() == PHP_SESSION_NONE) {
//    session_start();
//}

//include_once dirname(__DIR__) . '/php/db_connection.php'; // Adjust path as needed
//include_once dirname(__DIR__) . '/php/config.php'; // Ensure BASE_URL and DB config are defined

// Get POST data
//$fullname = $_POST['name'];
//$email = $_POST['email'];
//$password = $_POST['password'];
//$confirmPassword = $_POST['confirmPassword'];
//$role = $_POST['role'];

// Check password match
//if ($password !== $confirmPassword) {
//    $_SESSION['error'] = "Passwords do not match.";
//    header("Location: " . BASE_URL . "/php/register.php");
//    exit();
//}

// Validate email domain
//if (!preg_match("/@stu\.uob\.edu\.bh$/", $email)) {
//    $_SESSION['error'] = "Email must be a valid @stu.uob.edu.bh address.";
//    header("Location: " . BASE_URL . "/php/register.php");
//    exit();
//}

//try {
    // Database connection
//    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
//    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user already exists
 //   $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
//    $stmt->bindParam(':email', $email);
//    $stmt->execute();
//    $userExists = $stmt->fetchColumn();

//    if ($userExists > 0) {
//        $_SESSION['error'] = "Email is already registered.";
//        header("Location: " . BASE_URL . "/php/register.php");
//        exit();
//    }

    // Hash the password
//    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
//    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role) VALUES (:fullname, :email, :password, :role)");
//    $stmt->bindParam(':fullname', $fullname);
//    $stmt->bindParam(':email', $email);
//    $stmt->bindParam(':password', $hashedPassword);
//    $stmt->bindParam(':role', $role);
//    $stmt->execute();

    // Registration success
//    $_SESSION['success'] = "Account created successfully. You can now log in.";
//    header("Location: " . BASE_URL . "/php/register.php");
//    exit();
//} catch (PDOException $e) {
    // Handle errors
//    $_SESSION['error'] = "Database error: " . $e->getMessage();
//    header("Location: " . BASE_URL . "/php/register.php");
//    exit();
//}
?>
