<?php
session_start();
include 'config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = $conn->prepare("SELECT id, nama, password, role FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
        exit();
    } else {
        header("Location: ../index.php?error=Password salah.");
        exit();
    }
} else {
    header("Location: ../index.php?error=Email tidak ditemukan.");
    exit();
}
?>