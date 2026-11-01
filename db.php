<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "spor_salon_db";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}
?>
