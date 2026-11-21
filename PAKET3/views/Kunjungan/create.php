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
    <title>Tambah Kunjungan · KlinikFaldan</title>
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
        .form-label { font-weight: 500; font-size: 0.875rem; color: #334155; }
        .form-control, .form-select { border-radius: 10px; border-color: var(--border); padding: 0.6rem 0.85rem; }
        .form-control:focus, .form-select:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
        .btn-primary-soft { background: linear-gradient(135deg, #0f766e, #14b8a6); border: none; font-weight: 600; border-radius: 10px; padding: 0.6rem 1.25rem; box-shadow: 0 2px 8px rgba(37,99,235,.3); color: #fff; }
        .btn-primary-soft:hover { background: linear-gradient(135deg, #0d5c56, #0f766e); color: #fff; }
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
                    <h1 class="page-title mb-1">Tambah Kunjungan</h1>
                    <p class="page-sub mb-0">Catat kunjungan pasien baru</p>
                </div>
                <a href="index.php?module=kunjungan&action=index" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card-soft">
                <div class="card-body p-4">
                    <form action="index.php?module=kunjungan&action=store" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pasien <span class="text-danger">*</span></label>
                                <select name="idpasien" class="form-select" required>
                                    <option value="">-- Pilih Pasien --</option>
                                    <?php if ($daftarPasien): while ($p = $daftarPasien->fetch_assoc()): ?>
                                        <option value="<?= (int)$p['idpasien'] ?>"><?= e($p['namapasien']) ?></option>
                                    <?php endwhile; endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                <input type="date" name="tanggalkunjungan" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keluhan</label>
                                <textarea name="keluhan" class="form-control" rows="2" placeholder="Keluhan yang disampaikan pasien"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Diagnosis</label>
                                <textarea name="diagnosis" class="form-control" rows="2" placeholder="Hasil diagnosis"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Biaya (Rp)</label>
                                <input type="number" name="totalkunjungan" id="total" class="form-control" min="0" value="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jumlah Bayar (Rp)</label>
                                <input type="number" name="jumlahbayar" id="bayar" class="form-control" min="0" value="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kembalian (Rp)</label>
                                <input type="number" name="kembalian" id="kembalian" class="form-control" min="0" value="0" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Pembayaran</label>
                                <select name="statuspembayaran" class="form-select">
                                    <option value="Belum Bayar">Belum Bayar</option>
                                    <option value="Lunas">Lunas</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Kunjungan</label>
                                <select name="statuskunjungan" class="form-select">
                                    <option value="Proses">Proses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-4 pt-2">
                            <button type="submit" class="btn btn-primary-soft"><i class="bi bi-check-lg me-1"></i> Simpan</button>
                            <a href="index.php?module=kunjungan&action=index" class="btn btn-light border rounded-3">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function hitungKembalian() {
    const total = parseInt(document.getElementById('total').value) || 0;
    const bayar = parseInt(document.getElementById('bayar').value) || 0;
    document.getElementById('kembalian').value = Math.max(0, bayar - total);
}
document.getElementById('total').addEventListener('input', hitungKembalian);
document.getElementById('bayar').addEventListener('input', hitungKembalian);
</script>
</body>
</html>
