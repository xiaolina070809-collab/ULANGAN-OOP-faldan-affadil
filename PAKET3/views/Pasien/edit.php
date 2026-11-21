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
    <title>Edit Pasien · KlinikFaldan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0f766e; --bg: #f0fdfa; --text: #134e4a; --muted: #5b7a76; --border: #ccfbf1; --radius: 16px; }
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        body { background: linear-gradient(160deg, #f0fdfa 0%, #ecfeff 40%, #fdf2f8 100%); min-height: 100vh; color: var(--text); }
        .navbar-custom { background: linear-gradient(135deg, #0f766e 0%, #0d9488 40%, #14b8a6 100%); box-shadow: 0 8px 32px rgba(15,118,110,.35); }
        .navbar-brand { font-weight: 800; }
        .nav-link { font-weight: 600; opacity: .9; border-radius: 10px; padding: 0.45rem 0.9rem !important; }
        .nav-link:hover, .nav-link.active { opacity: 1; background: rgba(255,255,255,.18); }
        .card-soft { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 4px 24px rgba(15,118,110,.08); }
        .page-title { font-weight: 800; font-size: 1.4rem; color: #0f766e; }
        .page-sub { color: var(--muted); font-size: 0.9rem; font-weight: 500; }
        .form-label { font-weight: 600; font-size: 0.875rem; color: #134e4a; }
        .form-control, .form-select { border-radius: 12px; border-color: #99f6e4; padding: 0.65rem 0.9rem; font-weight: 500; }
        .form-control:focus, .form-select:focus { border-color: #14b8a6; box-shadow: 0 0 0 3px rgba(20,184,166,.2); }
        .btn-primary-soft { background: linear-gradient(135deg, #0f766e, #14b8a6); border: none; font-weight: 700; border-radius: 12px; padding: 0.65rem 1.3rem; color: #fff; box-shadow: 0 4px 14px rgba(15,118,110,.35); }
        .btn-primary-soft:hover { background: linear-gradient(135deg, #0d5c56, #0f766e); color: #fff; }
        .foto-preview-box {
            width: 130px; height: 130px; border-radius: 18px; border: 3px solid #5eead4;
            background: linear-gradient(135deg, #f0fdfa, #ccfbf1); display: flex; align-items: center; justify-content: center;
            overflow: hidden; cursor: pointer;
        }
        .foto-preview-box img { width: 100%; height: 100%; object-fit: cover; }
        .foto-preview-box .placeholder { text-align: center; color: #0f766e; font-size: 0.8rem; font-weight: 600; }
        .foto-preview-box .placeholder i { font-size: 2rem; display: block; margin-bottom: 6px; opacity: .7; }
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
                    <h1 class="page-title mb-1">Edit Pasien</h1>
                    <p class="page-sub mb-0">Perbarui data & foto profil</p>
                </div>
                <a href="index.php?module=pasien&action=index" class="btn btn-outline-secondary btn-sm rounded-3 fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card-soft">
                <div class="card-body p-4">
                    <form action="index.php?module=pasien&action=update&id=<?= (int)$pasien['idpasien'] ?>" method="post" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">Foto Profil</label>
                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <label for="fotoInput" class="foto-preview-box mb-0">
                                        <?php if (!empty($pasien['foto'])): ?>
                                            <img id="previewImg" src="assets/images/pasien/<?= e($pasien['foto']) ?>" alt="Foto">
                                            <div class="placeholder" id="placeholder" style="display:none"><i class="bi bi-camera-fill"></i> Pilih foto</div>
                                        <?php else: ?>
                                            <div class="placeholder" id="placeholder"><i class="bi bi-camera-fill"></i> Pilih foto</div>
                                            <img id="previewImg" style="display:none" alt="Preview">
                                        <?php endif; ?>
                                    </label>
                                    <div>
                                        <input type="file" name="foto" id="fotoInput" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" style="max-width:280px">
                                        <div class="form-text mt-1 fw-medium" style="color:#0f766e">Kosongkan jika tidak ganti · Maks. 2 MB</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Pasien <span class="text-danger">*</span></label>
                                <input type="text" name="namapasien" class="form-control" maxlength="100" required value="<?= e($pasien['namapasien']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" maxlength="100" required value="<?= e($pasien['username']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Usia <span class="text-danger">*</span></label>
                                <input type="number" name="usia" class="form-control" min="0" max="150" required value="<?= e($pasien['usia']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jeniskelamin" class="form-select" required>
                                    <option value="Laki-laki" <?= $pasien['jeniskelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= $pasien['jeniskelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. HP</label>
                                <input type="text" name="nohp" class="form-control" maxlength="15" value="<?= e($pasien['nohp']) ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alergi <span class="text-danger">*</span></label>
                                <input type="text" name="alergi" class="form-control" maxlength="255" required value="<?= e($pasien['alergi']) ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="2" maxlength="255"><?= e($pasien['alamat']) ?></textarea>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-4 pt-2">
                            <button type="submit" class="btn btn-primary-soft"><i class="bi bi-check-lg me-1"></i> Simpan Perubahan</button>
                            <a href="index.php?module=pasien&action=index" class="btn btn-light border rounded-3 fw-semibold">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('fotoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('previewImg');
    const placeholder = document.getElementById('placeholder');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            preview.src = ev.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});
</script>
</body>
</html>
