<?php
require_once '../config/config.php';
$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASSWORD;  // Replace with your actual MySQL root password
$dbname = DB_NAME;

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

