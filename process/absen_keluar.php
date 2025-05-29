<?php
session_start();
include '../config/db.php';

function hitung_jarak($lat1, $lon1, $lat2, $lon2) {
    $theta = $lon1 - $lon2;
    $jarak = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $jarak = acos($jarak);
    $jarak = rad2deg($jarak);
    return $jarak * 60 * 1.1515 * 1.609344 * 1000;
}

$user_id = $_SESSION['user_id'];
$tanggal = date('Y-m-d');
$jam_keluar = date('H:i:s');

$lat_user = $_POST['lat'];
$lng_user = $_POST['lng'];

$lat_kantor = -6.732440;
$lng_kantor = 108.552241;

$jarak = hitung_jarak($lat_kantor, $lng_kantor, $lat_user, $lng_user);
if ($jarak > 500) {
    echo "<script>alert('Anda berada di luar area kantor (>500m).'); window.location.href='../user/dashboard.php';</script>";
    exit();
}

// Validasi status keluar
$status = ($jam_keluar >= '17:00:00') ? 'valid' : 'tidak valid';

// Upload foto keluar
$foto_name = $_FILES['foto']['name'];
$foto_tmp = $_FILES['foto']['tmp_name'];
$ext = pathinfo($foto_name, PATHINFO_EXTENSION);
$nama_file = 'keluar_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
$folder = '../assets/uploads/' . $nama_file;
move_uploaded_file($foto_tmp, $folder);

// Cek jam awal lembur & upah dari tabel settings
$get_set = $conn->query("SELECT * FROM setting_lembur LIMIT 1")->fetch_assoc();
$jam_awal_lembur = $get_set['jam_awal'];
$upah_per_jam = $get_set['upah_per_jam'];

// Hitung lembur (jika lewat 1 jam dari jam_awal_lembur)
$lembur_jam = 0;
$lembur_upah = 0;

if ($jam_keluar > date("H:i:s", strtotime($jam_awal_lembur) + 3600)) {
    $lembur_jam = floor((strtotime($jam_keluar) - strtotime($jam_awal_lembur)) / 3600);
    $lembur_upah = $lembur_jam * $upah_per_jam;
}

// Update absensi
$stmt = $conn->prepare("UPDATE absensi SET jam_keluar=?, status_keluar=?, foto_keluar=?, lokasi_keluar=?, jam_lembur=?, upah_lembur=? WHERE user_id=? AND tanggal=?");
$lokasi = $lat_user . ',' . $lng_user;
$stmt->bind_param("ssssiiis", $jam_keluar, $status, $nama_file, $lokasi, $lembur_jam, $lembur_upah, $user_id, $tanggal);
$stmt->execute();

echo "<script>alert('Absen keluar berhasil.'); window.location.href='../user/dashboard.php';</script>";
