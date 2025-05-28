<?php
$host = "localhost";       // Ganti jika hosting berbeda
$user = "root";            // Username MySQL
$password = "";            // Password MySQL
$database = "absensi_db";  // Nama database kamu

// Buat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pilihan charset (opsional tapi disarankan)
$conn->set_charset("utf8mb4");
?>
