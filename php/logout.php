<?php

// Include the configuration file
include_once dirname(__DIR__) . '/php/config.php';

// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page
header('Location: ' . BASE_URL . '/login');
exit();

?>
