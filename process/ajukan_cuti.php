<?php
session_start();
include '../config/db.php';

$user_id = $_SESSION['user_id'];
$tanggal_cuti = $_POST['tanggal_cuti'];
$alasan = mysqli_real_escape_string($conn, $_POST['alasan']);
$tanggal_hari_ini = date('Y-m-d');

// Validasi maksimal H-1 (harus > hari ini)
$selisih = (strtotime($tanggal_cuti) - strtotime($tanggal_hari_ini)) / (60 * 60 * 24);
if ($selisih < 1) {
    echo "<script>alert('Pengajuan cuti harus dilakukan minimal H-1 sebelum tanggal cuti.'); window.location.href='../user/cuti/ajukan.php';</script>";
    exit();
}

// Cek apakah sudah pernah mengajukan pada tanggal tersebut
$cek = $conn->query("SELECT * FROM cuti WHERE user_id='$user_id' AND tanggal_cuti='$tanggal_cuti'");
if ($cek->num_rows > 0) {
    echo "<script>alert('Anda sudah mengajukan cuti untuk tanggal tersebut.'); window.location.href='../user/cuti/ajukan.php';</script>";
    exit();
}

// Masukkan pengajuan cuti
$stmt = $conn->prepare("INSERT INTO cuti (user_id, tanggal_pengajuan, tanggal_cuti, alasan, status) VALUES (?, ?, ?, ?, 'pending')");
$tanggal_pengajuan = date('Y-m-d');
$stmt->bind_param("isss", $user_id, $tanggal_pengajuan, $tanggal_cuti, $alasan);
$stmt->execute();

echo "<script>alert('Pengajuan cuti berhasil dikirim. Menunggu persetujuan.'); window.location.href='../user/riwayat/cuti.php';</script>";
