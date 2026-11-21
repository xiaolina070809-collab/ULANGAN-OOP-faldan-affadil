<?php
function e($nilai) {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}
function formatRupiah($angka) {
    return 'Rp ' . number_format((int)$angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Kunjungan · KlinikFaldan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus Jakarta Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --brand: #0f766e; --bg: #f8fafc; --text: #134e4a; --muted: #5b7a76; --border: #ccfbf1; --radius: 14px; }
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        body { background: var(--bg); color: var(--text); min-height: 100vh; }
        .navbar-custom { background: linear-gradient(135deg, #0f766e 0%, #0f766e 50%, #14b8a6 100%); box-shadow: 0 4px 20px rgba(37,99,235,.25); }
        .navbar-brand { font-weight: 700; }
        .nav-link { font-weight: 500; opacity: .9; }
        .nav-link:hover, .nav-link.active { opacity: 1; }
        .card-soft { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 12px rgba(0,0,0,.03); }
        .page-title { font-weight: 700; font-size: 1.35rem; }
        .page-sub { color: var(--muted); font-size: 0.9rem; }
        .label-meta { font-size: 0.78rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.04em; color: var(--muted); margin-bottom: 0.2rem; }
        .value-meta { font-weight: 600; font-size: 0.975rem; }
        .btn-primary-soft { background: linear-gradient(135deg, #0f766e, #14b8a6); border: none; font-weight: 600; border-radius: 10px; padding: 0.5rem 1rem; box-shadow: 0 2px 8px rgba(37,99,235,.3); color: #fff; }
        .btn-primary-soft:hover { background: linear-gradient(135deg, #0d5c56, #0f766e); color: #fff; }
        .badge-soft-success { background: #dcfce7; color: #166534; font-weight: 500; }
        .badge-soft-warning { background: #fef3c7; color: #92400e; font-weight: 500; }
        .badge-soft-primary { background: #dbeafe; color: #0f766e; font-weight: 500; }
        .badge-soft-secondary { background: #f0fdfa; color: #475569; font-weight: 500; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php"><i class="bi bi-heart-pulse-fill fs-4"></i><span>KlinikFaldan</span></a>
        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item"><a class="nav-link px-3" href="index.php?module=pasien&action=index"><i class="bi bi-people me-1"></i> Pasien</a></li>
                <li class="nav-item"><a class="nav-link active px-3" href="index.php?module=kunjungan&action=index"><i class="bi bi-clipboard2-pulse me-1"></i> Kunjungan</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-title mb-1">Detail Kunjungan</h1>
                    <p class="page-sub mb-0">Informasi lengkap kunjungan</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="index.php?module=kunjungan&action=edit&id=<?= (int)$kunjungan['idkunjungan'] ?>" class="btn btn-primary-soft btn-sm">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <a href="index.php?module=kunjungan&action=index" class="btn btn-outline-secondary btn-sm rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-soft">
                <div class="card-body p-4 p-md-5">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="label-meta">ID Kunjungan</div>
                            <div class="value-meta">#<?= (int)$kunjungan['idkunjungan'] ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-meta">Tanggal Kunjungan</div>
                            <div class="value-meta"><?= e(date('d F Y', strtotime($kunjungan['tanggalkunjungan']))) ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-meta">Nama Pasien</div>
                            <div class="value-meta"><?= e($kunjungan['namapasien']) ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-meta">Status Kunjungan</div>
                            <div>
                                <?php if ($kunjungan['statuskunjungan'] === 'Selesai'): ?>
                                    <span class="badge badge-soft-primary rounded-pill px-2 py-1">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-soft-secondary rounded-pill px-2 py-1">Proses</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="label-meta">Keluhan</div>
                            <div class="value-meta"><?= e($kunjungan['keluhan'] ?: '–') ?></div>
                        </div>
                        <div class="col-12">
                            <div class="label-meta">Diagnosis</div>
                            <div class="value-meta"><?= e($kunjungan['diagnosis'] ?: '–') ?></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="label-meta">Total Biaya</div>
                            <div class="value-meta"><?= formatRupiah($kunjungan['totalkunjungan']) ?></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="label-meta">Jumlah Bayar</div>
                            <div class="value-meta"><?= formatRupiah($kunjungan['jumlahbayar']) ?></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="label-meta">Kembalian</div>
                            <div class="value-meta"><?= formatRupiah($kunjungan['kembalian']) ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-meta">Status Pembayaran</div>
                            <div>
                                <?php if ($kunjungan['statuspembayaran'] === 'Lunas'): ?>
                                    <span class="badge badge-soft-success rounded-pill px-2 py-1">Lunas</span>
                                <?php else: ?>
                                    <span class="badge badge-soft-warning rounded-pill px-2 py-1">Belum Bayar</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
