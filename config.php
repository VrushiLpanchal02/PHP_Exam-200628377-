<?php
$host = 'localhost';
$dbname = 'comp1006_reviews';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}
?>
