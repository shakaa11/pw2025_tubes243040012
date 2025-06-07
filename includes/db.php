<?php
$host = 'localhost'; 
$db = 'tourism_db'; 
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi database berhasil!"; // Untuk debugging, hapus di production
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>