<?php
session_start();
include '../../config/db.php';
include '../../includes/auth.php';

$user_id = $_SESSION['user_id'];
$tanggal = date('Y-m-d');

// Cek apakah sudah absen masuk
$cek = $conn->query("SELECT * FROM absensi WHERE user_id='$user_id' AND tanggal='$tanggal'");
$data = $cek->fetch_assoc();

if (!$data || !$data['jam_masuk']) {
    echo "<script>alert('Anda belum absen masuk.'); window.location.href='../dashboard.php';</script>";
    exit();
}

// Jika sudah absen keluar
if ($data['jam_keluar']) {
    echo "<script>alert('Anda sudah absen keluar.'); window.location.href='../dashboard.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Keluar - Sistem Absensi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/absen_keluar.css">
</head>
<body>
    <div class="container">
        <div class="checkout-container">
            <div class="text-center mb-4">
                <i class="fas fa-sign-out-alt fa-3x mb-3" style="color: #764ba2;"></i>
                <h2 class="fw-bold">Absen Keluar</h2>
                <p class="text-muted">Silakan ambil foto selfie untuk absen keluar</p>
            </div>

            <form action="../../process/absen_keluar.php" method="POST" enctype="multipart/form-data" id="checkoutForm">
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

                <button type="submit" class="btn btn-checkout" id="submitBtn" disabled>
                    <i class="fas fa-check me-2"></i>Konfirmasi Absen Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="assets/js/absen_keluar.js"></script>
</body>
</html>