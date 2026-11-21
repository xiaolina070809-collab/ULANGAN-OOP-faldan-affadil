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
    <title>Detail Pasien · KlinikFaldan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0f766e; --text: #134e4a; --muted: #5b7a76; --border: #ccfbf1; --radius: 16px; }
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        body { background: linear-gradient(160deg, #f0fdfa 0%, #ecfeff 40%, #fdf2f8 100%); min-height: 100vh; color: var(--text); }
        .navbar-custom { background: linear-gradient(135deg, #0f766e 0%, #0d9488 40%, #14b8a6 100%); box-shadow: 0 8px 32px rgba(15,118,110,.35); }
        .navbar-brand { font-weight: 800; }
        .nav-link { font-weight: 600; opacity: .9; border-radius: 10px; padding: 0.45rem 0.9rem !important; }
        .nav-link:hover, .nav-link.active { opacity: 1; background: rgba(255,255,255,.18); }
        .card-soft { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 4px 24px rgba(15,118,110,.08); }
        .page-title { font-weight: 800; font-size: 1.4rem; color: #0f766e; }
        .page-sub { color: var(--muted); font-size: 0.9rem; font-weight: 500; }
        .foto-detail { width: 170px; height: 170px; object-fit: cover; border-radius: 20px; border: 4px solid #fff; box-shadow: 0 8px 24px rgba(15,118,110,.2); }
        .foto-placeholder-lg { width: 170px; height: 170px; border-radius: 20px; background: linear-gradient(135deg, #99f6e4, #5eead4); display: flex; align-items: center; justify-content: center; color: #0f766e; }
        .label-meta { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #0f766e; margin-bottom: 0.25rem; }
        .value-meta { font-weight: 700; font-size: 1rem; }
        .btn-primary-soft { background: linear-gradient(135deg, #0f766e, #14b8a6); border: none; font-weight: 700; border-radius: 12px; padding: 0.5rem 1rem; color: #fff; box-shadow: 0 4px 14px rgba(15,118,110,.3); }
        .btn-primary-soft:hover { background: linear-gradient(135deg, #0d5c56, #0f766e); color: #fff; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php"><i class="bi bi-heart-pulse-fill fs-4"></i><span>KlinikFaldan</span></a>
        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item"><a class="nav-link active" href="index.php?module=pasien&action=index"><i class="bi bi-people-fill me-1"></i> Pasien</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?module=kunjungan&action=index"><i class="bi bi-clipboard2-pulse-fill me-1"></i> Kunjungan</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-title mb-1">Detail Pasien</h1>
                    <p class="page-sub mb-0">Profil lengkap pasien</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="index.php?module=pasien&action=edit&id=<?= (int)$pasien['idpasien'] ?>" class="btn btn-primary-soft btn-sm"><i class="bi bi-pencil-fill me-1"></i> Edit</a>
                    <a href="index.php?module=pasien&action=index" class="btn btn-outline-secondary btn-sm rounded-3 fw-semibold"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                </div>
            </div>

            <div class="card-soft">
                <div class="card-body p-4 p-md-5">
                    <div class="row g-4 align-items-start">
                        <div class="col-auto text-center">
                            <?php if (!empty($pasien['foto'])): ?>
                                <img src="assets/images/pasien/<?= e($pasien['foto']) ?>" alt="Foto" class="foto-detail">
                            <?php else: ?>
                                <div class="foto-placeholder-lg"><i class="bi bi-person-fill fs-1"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="col">
                            <h3 class="fw-extrabold mb-3" style="letter-spacing:-0.4px;font-weight:800"><?= e($pasien['namapasien']) ?></h3>
                            <div class="row g-3">
                                <div class="col-sm-6"><div class="label-meta">Username</div><div class="value-meta"><?= e($pasien['username']) ?></div></div>
                                <div class="col-sm-6"><div class="label-meta">Usia</div><div class="value-meta"><?= e($pasien['usia']) ?> tahun</div></div>
                                <div class="col-sm-6"><div class="label-meta">Jenis Kelamin</div><div class="value-meta"><?= e($pasien['jeniskelamin']) ?></div></div>
                                <div class="col-sm-6"><div class="label-meta">No. HP</div><div class="value-meta"><?= e($pasien['nohp'] ?: '–') ?></div></div>
                                <div class="col-12"><div class="label-meta">Alergi</div><div class="value-meta"><?= e($pasien['alergi']) ?></div></div>
                                <div class="col-12"><div class="label-meta">Alamat</div><div class="value-meta"><?= e($pasien['alamat'] ?: '–') ?></div></div>
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
