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
    <title>Data Kunjungan · KlinikFaldan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus Jakarta Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --brand: #0f766e; --bg: #f8fafc; --text: #134e4a; --muted: #5b7a76; --border: #ccfbf1; --radius: 14px; }
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        body { background: var(--bg); color: var(--text); min-height: 100vh; }
        .navbar-custom { background: linear-gradient(135deg, #0f766e 0%, #0f766e 50%, #14b8a6 100%); box-shadow: 0 4px 20px rgba(37,99,235,.25); }
        .navbar-brand { font-weight: 700; letter-spacing: -0.4px; font-size: 1.2rem; }
        .nav-link { font-weight: 500; font-size: 0.92rem; opacity: 0.9; }
        .nav-link:hover, .nav-link.active { opacity: 1; }
        .page-title { font-weight: 700; font-size: 1.45rem; letter-spacing: -0.3px; }
        .page-sub { color: var(--muted); font-size: 0.9rem; }
        .card-soft { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 12px rgba(0,0,0,.03); overflow: hidden; }
        .table { margin-bottom: 0; }
        .table thead th { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: var(--muted); background: #f8fafc; border-bottom: 1px solid var(--border); padding: 0.9rem 1rem; white-space: nowrap; }
        .table tbody td { padding: 0.85rem 1rem; vertical-align: middle; border-color: #f0fdfa; font-size: 0.925rem; }
        .table tbody tr:hover { background: #f8fafc; }
        .btn-action { width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; border: 1px solid var(--border); background: #fff; color: var(--muted); transition: all .15s; }
        .btn-action:hover { background: #f0fdfa; color: var(--text); }
        .btn-action.btn-view:hover { color: #0f766e; border-color: #99f6e4; background: #f0fdfa; }
        .btn-action.btn-edit:hover { color: #d97706; border-color: #fde68a; background: #fffbeb; }
        .btn-action.btn-del:hover { color: #dc2626; border-color: #fecaca; background: #fef2f2; }
        .btn-primary-soft { background: linear-gradient(135deg, #0f766e, #14b8a6); border: none; font-weight: 600; border-radius: 10px; padding: 0.55rem 1.15rem; box-shadow: 0 2px 8px rgba(37,99,235,.3); color: #fff; }
        .btn-primary-soft:hover { background: linear-gradient(135deg, #0d5c56, #0f766e); color: #fff; }
        .empty-state { padding: 3.5rem 1rem; text-align: center; color: var(--muted); }
        .empty-state i { font-size: 2.5rem; opacity: 0.4; }
        .alert { border-radius: 10px; border: none; }
        .name-cell { font-weight: 600; }
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
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item"><a class="nav-link px-3" href="index.php?module=pasien&action=index"><i class="bi bi-people me-1"></i> Pasien</a></li>
                <li class="nav-item"><a class="nav-link active px-3" href="index.php?module=kunjungan&action=index"><i class="bi bi-clipboard2-pulse me-1"></i> Kunjungan</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Data Kunjungan</h1>
            <p class="page-sub mb-0">Riwayat kunjungan pasien ke klinik</p>
        </div>
        <a href="index.php?module=kunjungan&action=create" class="btn btn-primary-soft">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kunjungan
        </a>
    </div>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="alert alert-<?= e($_SESSION['jenis']) ?> alert-dismissible fade show shadow-sm" role="alert">
            <?= e($_SESSION['pesan']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['pesan'], $_SESSION['jenis']); ?>
    <?php endif; ?>

    <div class="card-soft">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:50px">#</th>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>Keluhan</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($dataKunjungan && $dataKunjungan->num_rows > 0): ?>
                    <?php $no = 1; while ($row = $dataKunjungan->fetch_assoc()): ?>
                    <tr>
                        <td class="ps-4 text-muted"><?= $no++ ?></td>
                        <td><?= e(date('d/m/Y', strtotime($row['tanggalkunjungan']))) ?></td>
                        <td class="name-cell"><?= e($row['namapasien']) ?></td>
                        <td class="text-muted"><?= e(mb_strimwidth($row['keluhan'] ?? '', 0, 36, '...')) ?></td>
                        <td class="fw-medium"><?= formatRupiah($row['totalkunjungan']) ?></td>
                        <td>
                            <?php if ($row['statuspembayaran'] === 'Lunas'): ?>
                                <span class="badge badge-soft-success rounded-pill px-2 py-1">Lunas</span>
                            <?php else: ?>
                                <span class="badge badge-soft-warning rounded-pill px-2 py-1">Belum Bayar</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['statuskunjungan'] === 'Selesai'): ?>
                                <span class="badge badge-soft-primary rounded-pill px-2 py-1">Selesai</span>
                            <?php else: ?>
                                <span class="badge badge-soft-secondary rounded-pill px-2 py-1">Proses</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-1">
                                <a href="index.php?module=kunjungan&action=show&id=<?= (int)$row['idkunjungan'] ?>" class="btn-action btn-view" title="Detail"><i class="bi bi-eye"></i></a>
                                <a href="index.php?module=kunjungan&action=edit&id=<?= (int)$row['idkunjungan'] ?>" class="btn-action btn-edit" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="index.php?module=kunjungan&action=delete&id=<?= (int)$row['idkunjungan'] ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kunjungan ini?');">
                                    <button type="submit" class="btn-action btn-del" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-clipboard2-pulse d-block mb-2"></i>
                                <p class="mb-1 fw-medium">Belum ada data kunjungan</p>
                                <p class="small mb-3">Tambahkan kunjungan pertama untuk memulai</p>
                                <a href="index.php?module=kunjungan&action=create" class="btn btn-sm btn-primary-soft">
                                    <i class="bi bi-plus-lg me-1"></i> Tambah Kunjungan
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
