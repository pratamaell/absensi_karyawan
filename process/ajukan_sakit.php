<?php
session_start();
include '../config/db.php';

$user_id = $_SESSION['user_id'];
$tanggal_sakit = $_POST['tanggal_sakit'];
$keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
$tanggal_hari_ini = date('Y-m-d');

// Validasi maksimal H+3
$selisih = (strtotime($tanggal_hari_ini) - strtotime($tanggal_sakit)) / (60 * 60 * 24);
if ($selisih > 3) {
    echo "<script>alert('Izin sakit hanya bisa diajukan maksimal H+3.'); window.location.href='../user/sakit/ajukan.php';</script>";
    exit();
}

// Upload surat dokter jika ada
$surat_dokter = null;
if ($_FILES['surat_dokter']['name'] != '') {
    $target_dir = "../assets/uploads/";
    $ext = pathinfo($_FILES['surat_dokter']['name'], PATHINFO_EXTENSION);
    $file_name = "surat_sakit_" . time() . "." . $ext;
    $target_file = $target_dir . $file_name;
    if (move_uploaded_file($_FILES['surat_dokter']['tmp_name'], $target_file)) {
        $surat_dokter = $file_name;
    }
}

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO izin_sakit (user_id, tanggal_pengajuan, tanggal_sakit, keterangan, surat_dokter, status) VALUES (?, ?, ?, ?, ?, 'pending')");
$tanggal_pengajuan = $tanggal_hari_ini;
$stmt->bind_param("issss", $user_id, $tanggal_pengajuan, $tanggal_sakit, $keterangan, $surat_dokter);
$stmt->execute();

echo "<script>alert('Izin sakit berhasil diajukan.'); window.location.href='../user/riwayat/absensi.php';</script>";
