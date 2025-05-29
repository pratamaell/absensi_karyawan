<?php
session_start();
include '../../config/db.php';
include '../../includes/auth.php';

$tanggal_sekarang = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Cuti - Sistem Absensi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/ajukan_cuti.css"> 
</head>
<body>
    <div class="container">
        <div class="leave-container">
            <div class="text-center mb-4">
                <i class="fas fa-calendar-alt fa-3x mb-3" style="color: #667eea;"></i>
                <h2 class="fw-bold">Pengajuan Cuti</h2>
                <p class="text-muted">Silakan isi form pengajuan cuti di bawah ini</p>
            </div>

            <div class="remaining-leave">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0">Sisa Cuti Tahunan</h6>
                        <small class="text-muted">Periode <?= date('Y') ?></small>
                    </div>
                    <div class="col-auto">
                        <h4 class="mb-0 fw-bold text-primary">12 Hari</h4>
                    </div>
                </div>
            </div>

            <form action="../../process/ajukan_cuti.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Cuti</label>
                    <input type="date" 
                           class="form-control" 
                           name="tanggal_cuti" 
                           min="<?= date('Y-m-d', strtotime('+1 day')) ?>" 
                           required>
                    <small class="text-muted">*Minimal pengajuan H-1 dari rencana cuti</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Alasan Cuti</label>
                    <textarea class="form-control" 
                              name="alasan" 
                              rows="4" 
                              placeholder="Jelaskan alasan pengajuan cuti Anda..."
                              required></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-paper-plane me-2"></i>Ajukan Cuti
                    </button>
                    <a href="../dashboard.php" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>