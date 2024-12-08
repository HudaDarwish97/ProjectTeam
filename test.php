<?php
try {
    $dsn = "mysql:host=localhost;port=4306;charset=utf8mb4";
    $db = new PDO($dsn, "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
