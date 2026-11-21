<?php
function e($nilai) {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pasien · KlinikFaldan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #0d5c56;
            --accent: #f43f5e;
            --accent-soft: #ffe4e6;
            --bg: #f0fdfa;
            --surface: #ffffff;
            --text: #134e4a;
            --muted: #5b7a76;
            --border: #ccfbf1;
            --radius: 16px;
        }
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        body { background: linear-gradient(160deg, #f0fdfa 0%, #ecfeff 40%, #fdf2f8 100%); min-height: 100vh; color: var(--text); }
        .navbar-custom {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 40%, #14b8a6 100%);
            box-shadow: 0 8px 32px rgba(15, 118, 110, 0.35);
        }
        .navbar-brand { font-weight: 800; letter-spacing: -0.5px; font-size: 1.25rem; }
        .nav-link { font-weight: 600; font-size: 0.9rem; opacity: 0.9; border-radius: 10px; padding: 0.45rem 0.9rem !important; transition: all .2s; }
        .nav-link:hover, .nav-link.active { opacity: 1; background: rgba(255,255,255,.18); }
        .page-title { font-weight: 800; font-size: 1.5rem; letter-spacing: -0.4px; color: #0f766e; }
        .page-sub { color: var(--muted); font-size: 0.9rem; font-weight: 500; }
        .card-soft {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 4px 24px rgba(15, 118, 110, 0.08);
            overflow: hidden;
        }
        .table { margin-bottom: 0; }
        .table thead th {
            font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;
            color: #0f766e; background: linear-gradient(180deg, #f0fdfa, #ccfbf1);
            border-bottom: 2px solid #99f6e4; padding: 1rem 1rem; white-space: nowrap;
        }
        .table tbody td { padding: 0.9rem 1rem; vertical-align: middle; border-color: #f0fdfa; font-size: 0.925rem; }
        .table tbody tr:hover { background: #f0fdfa; }
        .foto-thumb {
            width: 48px; height: 48px; object-fit: cover; border-radius: 12px;
            border: 3px solid #fff; box-shadow: 0 2px 8px rgba(15,118,110,.2);
        }
        .foto-placeholder {
            width: 48px; height: 48px; border-radius: 12px;
            background: linear-gradient(135deg, #99f6e4, #5eead4);
            display: flex; align-items: center; justify-content: center; color: #0f766e;
        }
        .btn-action {
            width: 36px; height: 36px; padding: 0;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 10px; border: none; transition: all .15s; font-size: 0.95rem;
        }
        .btn-view { background: #ccfbf1; color: #0f766e; }
        .btn-view:hover { background: #0f766e; color: #fff; }
        .btn-edit { background: #fef3c7; color: #b45309; }
        .btn-edit:hover { background: #f59e0b; color: #fff; }
        .btn-del { background: #ffe4e6; color: #e11d48; }
        .btn-del:hover { background: #f43f5e; color: #fff; }
        .btn-primary-soft {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            border: none; font-weight: 700; border-radius: 12px;
            padding: 0.6rem 1.25rem; color: #fff;
            box-shadow: 0 4px 14px rgba(15, 118, 110, 0.35);
        }
        .btn-primary-soft:hover { background: linear-gradient(135deg, #0d5c56, #0f766e); color: #fff; transform: translateY(-1px); }
        .empty-state { padding: 3.5rem 1rem; text-align: center; color: var(--muted); }
        .empty-state i { font-size: 2.75rem; opacity: 0.35; color: #0f766e; }
        .alert { border-radius: 12px; border: none; font-weight: 500; }
        .name-cell { font-weight: 700; color: #134e4a; }
        .meta { color: var(--muted); font-size: 0.85rem; font-weight: 500; }
        .badge-count {
            background: linear-gradient(135deg, #f43f5e, #fb7185);
            color: #fff; font-size: 0.7rem; font-weight: 700;
            padding: 0.2rem 0.5rem; border-radius: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <i class="bi bi-heart-pulse-fill fs-4"></i>
            <span>KlinikFaldan</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php?module=pasien&action=index">
                        <i class="bi bi-people-fill me-1"></i> Pasien
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?module=kunjungan&action=index">
                        <i class="bi bi-clipboard2-pulse-fill me-1"></i> Kunjungan
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Data Pasien</h1>
            <p class="page-sub mb-0">Kelola data & foto profil pasien klinik</p>
        </div>
        <a href="index.php?module=pasien&action=create" class="btn btn-primary-soft">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pasien
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
                        <th>Foto</th>
                        <th>Nama Pasien</th>
                        <th>Username</th>
                        <th>Usia</th>
                        <th>Jenis Kelamin</th>
                        <th>No. HP</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($dataPasien && $dataPasien->num_rows > 0): ?>
                    <?php $no = 1; while ($row = $dataPasien->fetch_assoc()): ?>
                    <tr>
                        <td class="ps-4 text-muted fw-semibold"><?= $no++ ?></td>
                        <td>
                            <?php if (!empty($row['foto'])): ?>
                                <img src="assets/images/pasien/<?= e($row['foto']) ?>" alt="Foto" class="foto-thumb" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <div class="foto-placeholder" style="display:none"><i class="bi bi-person-fill"></i></div>
                            <?php else: ?>
                                <div class="foto-placeholder"><i class="bi bi-person-fill"></i></div>
                            <?php endif; ?>
                        </td>
                        <td class="name-cell"><?= e($row['namapasien']) ?></td>
                        <td class="meta"><?= e($row['username']) ?></td>
                        <td class="fw-semibold"><?= e($row['usia']) ?> th</td>
                        <td><?= e($row['jeniskelamin']) ?></td>
                        <td class="meta"><?= e($row['nohp'] ?: '–') ?></td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-1">
                                <a href="index.php?module=pasien&action=show&id=<?= (int)$row['idpasien'] ?>" class="btn-action btn-view" title="Detail"><i class="bi bi-eye-fill"></i></a>
                                <a href="index.php?module=pasien&action=edit&id=<?= (int)$row['idpasien'] ?>" class="btn-action btn-edit" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                <form action="index.php?module=pasien&action=delete&id=<?= (int)$row['idpasien'] ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pasien ini?');">
                                    <button type="submit" class="btn-action btn-del" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-people d-block mb-2"></i>
                                <p class="mb-1 fw-bold" style="color:#0f766e">Belum ada data pasien</p>
                                <p class="small mb-3">Tambahkan pasien pertama beserta foto profilnya</p>
                                <a href="index.php?module=pasien&action=create" class="btn btn-sm btn-primary-soft">
                                    <i class="bi bi-person-plus-fill me-1"></i> Tambah Pasien
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
