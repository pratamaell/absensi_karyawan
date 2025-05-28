<?php
session_start();
include 'config/db.php';
include 'includes/auth.php';

$user_id = $_SESSION['user_id'];
$tanggal_hari_ini = date('Y-m-d');

// Cek jika sudah absen hari ini
$cek = $conn->query("SELECT * FROM absensi WHERE user_id='$user_id' AND tanggal='$tanggal_hari_ini'");
if ($cek->num_rows > 0 && $cek->fetch_assoc()['jam_masuk']) {
    echo "<script>alert('Anda sudah absen masuk hari ini'); window.location.href='../dashboard.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Masuk - Sistem Absensi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/absen_masuk.css">
</head>
<body>
    <div class="container">
        <div class="attendance-container">
            <div class="text-center mb-4">
                <i class="fas fa-camera fa-3x mb-3" style="color: #667eea;"></i>
                <h2 class="fw-bold">Absen Masuk</h2>
                <p class="text-muted">Silakan ambil foto selfie Anda</p>
            </div>

            <form action="../../process/absen_masuk.php" method="POST" enctype="multipart/form-data" id="absenForm">
                <div class="camera-box">
                    <input type="file" name="foto" id="cameraInput" accept="image/*" capture="user" required 
                           class="form-control mb-3" style="display: none;">
                    <button type="button" class="btn btn-outline-primary mb-3" id="openCamera">
                        <i class="fas fa-camera me-2"></i>Buka Kamera
                    </button>
                    <img id="preview" alt="Preview">
                    <div class="status-indicator" id="locationStatus">
                        <i class="fas fa-spinner fa-spin me-2"></i>Mendeteksi lokasi...
                    </div>
                </div>

                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lng" id="lng">

                <button type="submit" class="btn btn-absen" id="submitBtn" disabled>
                    <i class="fas fa-check me-2"></i>Konfirmasi Absen Masuk
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/absen_masuk.js"></script>
</body>
</html>