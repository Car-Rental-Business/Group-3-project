<?php
// db.php - change $dbname if your DB name is different (car_rental or login_system)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host   = '127.0.0.1';
$user   = 'root';
$pass   = '';            // XAMPP default is empty
$dbname = 'car_rental';  // <<< CHANGE this if your DB name is different

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('DB Connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
