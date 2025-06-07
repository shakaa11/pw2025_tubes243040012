<?php
$host = 'localhost'; // Ganti jika database Anda di tempat lain
$db = 'tourism_db'; // Nama database yang sudah dibuat
$user = 'root'; // Username database Anda
$pass = ''; // Password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi database berhasil!"; // Untuk debugging, hapus di production
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>