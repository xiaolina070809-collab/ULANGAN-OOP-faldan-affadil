<?php
require_once __DIR__ . '/koneksi.php';
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) return;
    $file = __DIR__ . '/src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) require $file;
});
use App\Controllers\PasienController;
use App\Controllers\KunjunganController;

$koneksi = (new Koneksi())->getKoneksi();
$pasien = new PasienController($koneksi);
$kunjungan = new KunjunganController($koneksi);
$module = $_GET['module'] ?? 'pasien';
$action = $_GET['action'] ?? 'index';
$id = (int)($_GET['id'] ?? 0);

try {
    if ($module === 'kunjungan') {
        match ($action) {
            'create' => $kunjungan->create(),
            'store' => $kunjungan->store(),
            'edit' => $kunjungan->edit($id),
            'update' => $kunjungan->update($id),
            'show' => $kunjungan->show($id),
            'delete' => $kunjungan->delete($id),
            default => $kunjungan->index()
        };
    } else {
        match ($action) {
            'create' => $pasien->create(),
            'store' => $pasien->store(),
            'edit' => $pasien->edit($id),
            'update' => $pasien->update($id),
            'show' => $pasien->show($id),
            'delete' => $pasien->delete($id),
            default => $pasien->index()
        };
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo '<div style="font-family:Arial;padding:30px"><h2>Terjadi kesalahan</h2><p>' .
        htmlspecialchars($e->getMessage()) . '</p><a href="index.php">Kembali</a></div>';
}