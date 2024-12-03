<?php
$host = 'localhost'; // Nama host (misalnya localhost)
$user = 'root'; // Username database
$pass = ''; // Password database
$dbname = 'db_story'; // Nama database yang benar

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
