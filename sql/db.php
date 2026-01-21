<?php
// db.php - centralized DB connection using PDO
// Edit these values:
$dbHost = 'localhost';
$dbName = 'flycronos_db';
$dbUser = 'dbusername';
$dbPass = 'dbpassword';
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {
    // In production, log the error and show a generic message.
    http_response_code(500);
    echo "Database connection failed.";
    exit;
}
