<?php
session_start();
include '../../config/db.php';
include '../../includes/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Izin Sakit - Sistem Absensi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
    </style>
</head>
<body>
    <div class="container">
        <div class="sick-leave-container">
            <div class="text-center mb-4">
                <i class="fas fa-notes-medical fa-3x mb-3" style="color: #667eea;"></i>
                <h2 class="fw-bold">Pengajuan Izin Sakit</h2>
                <p class="text-muted">Silakan lengkapi form pengajuan izin sakit di bawah ini</p>
            </div>

            <form action="../../process/ajukan_sakit.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt me-2"></i>Tanggal Tidak Hadir
                    </label>
                    <input type="date" 
                           name="tanggal_sakit" 
                           class="form-control" 
                           max="<?= date('Y-m-d') ?>" 
                           required>
                    <small class="text-muted">*Maksimal pengajuan H+3 dari tanggal ketidakhadiran</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-file-medical me-2"></i>Surat Dokter
                    </label>
                    <div class="file-upload">
                        <input type="file" 
                               name="surat_dokter" 
                               accept="image/*,application/pdf" 
                               class="form-control" 
                               id="fileInput" 
                               style="display: none;">
                        <label for="fileInput">
                            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                            <p class="mb-0">Klik untuk upload surat dokter</p>
                            <small class="text-muted">Format: JPG, PNG, PDF (Max. 2MB)</small>
                        </label>
                    </div>
                    <div id="filePreview" class="mt-2"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-comment-medical me-2"></i>Keterangan
                    </label>
                    <textarea name="keterangan" 
                              class="form-control" 
                              rows="4" 
                              placeholder="Jelaskan alasan ketidakhadiran Anda..."
                              required></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-paper-plane me-2"></i>Ajukan Izin Sakit
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
    <script>
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                document.getElementById('filePreview').innerHTML = `
                    <div class="alert alert-info">
                        <i class="fas fa-file me-2"></i>${fileName}
                    </div>`;
            }
        });
    </script>
</body>
</html>