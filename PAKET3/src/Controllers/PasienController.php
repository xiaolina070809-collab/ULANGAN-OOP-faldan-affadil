<?php

namespace App\Controllers;

use App\Models\Pasien;

class PasienController
{
    private $pasien;

    public function __construct($koneksi)
    {
        $this->pasien = new Pasien($koneksi);
    }

    public function index()
    {
        $dataPasien = $this->pasien->tampil();
        require __DIR__ . '/../../views/Pasien/index.php';
    }

    public function create()
    {
        require __DIR__ . '/../../views/Pasien/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('pasien', 'index');
        }

        $namaFoto = $this->unggahFoto();
        if ($namaFoto === false) {
            return;
        }

        $data = [
            'namapasien'   => trim($_POST['namapasien'] ?? ''),
            'username'     => trim($_POST['username'] ?? ''),
            'password'     => $_POST['password'] ?? '',
            'usia'         => (int) ($_POST['usia'] ?? 0),
            'alergi'       => trim($_POST['alergi'] ?? ''),
            'jeniskelamin' => $_POST['jeniskelamin'] ?? '',
            'alamat'       => trim($_POST['alamat'] ?? ''),
            'nohp'         => trim($_POST['nohp'] ?? ''),
            'foto'         => $namaFoto
        ];

        if ($this->pasien->tambah($data)) {
            $_SESSION['pesan'] = 'Data pasien berhasil ditambahkan.';
            $_SESSION['jenis'] = 'success';
        } else {
            $this->hapusFileFoto($namaFoto);
            $_SESSION['pesan'] = 'Gagal menambahkan data pasien.';
            $_SESSION['jenis'] = 'danger';
        }

        $this->redirect('pasien', 'index');
    }

    public function edit($id)
    {
        $pasien = $this->pasien->ambil($id);
        if (!$pasien) {
            $_SESSION['pesan'] = 'Data pasien tidak ditemukan.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('pasien', 'index');
        }
        require __DIR__ . '/../../views/Pasien/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('pasien', 'index');
        }

        $pasienLama = $this->pasien->ambil($id);
        if (!$pasienLama) {
            $_SESSION['pesan'] = 'Data pasien tidak ditemukan.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('pasien', 'index');
        }

        $namaFoto = $pasienLama['foto'];
        $fotoBaru = false;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
            $hasilUpload = $this->unggahFoto();
            if ($hasilUpload === false) {
                return;
            }
            $namaFoto = $hasilUpload;
            $fotoBaru = true;
        }

        $data = [
            'namapasien'   => trim($_POST['namapasien'] ?? ''),
            'username'     => trim($_POST['username'] ?? ''),
            'password'     => $_POST['password'] ?? '',
            'usia'         => (int) ($_POST['usia'] ?? 0),
            'alergi'       => trim($_POST['alergi'] ?? ''),
            'jeniskelamin' => $_POST['jeniskelamin'] ?? '',
            'alamat'       => trim($_POST['alamat'] ?? ''),
            'nohp'         => trim($_POST['nohp'] ?? ''),
            'foto'         => $namaFoto
        ];

        if ($this->pasien->ubah($id, $data)) {
            if ($fotoBaru && !empty($pasienLama['foto'])) {
                $this->hapusFileFoto($pasienLama['foto']);
            }
            $_SESSION['pesan'] = 'Data pasien berhasil diperbarui.';
            $_SESSION['jenis'] = 'success';
        } else {
            if ($fotoBaru) {
                $this->hapusFileFoto($namaFoto);
            }
            $_SESSION['pesan'] = 'Gagal memperbarui data pasien.';
            $_SESSION['jenis'] = 'danger';
        }

        $this->redirect('pasien', 'index');
    }

    public function show($id)
    {
        $pasien = $this->pasien->ambil($id);
        if (!$pasien) {
            $_SESSION['pesan'] = 'Data pasien tidak ditemukan.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('pasien', 'index');
        }
        require __DIR__ . '/../../views/Pasien/show.php';
    }

    public function delete($id)
    {
        $pasien = $this->pasien->ambil($id);
        if (!$pasien) {
            $_SESSION['pesan'] = 'Data pasien tidak ditemukan.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('pasien', 'index');
        }

        $jumlahKunjungan = $this->pasien->hitungKunjungan($id);
        if ($jumlahKunjungan > 0) {
            $_SESSION['pesan'] = 'Pasien tidak dapat dihapus karena masih memiliki data kunjungan.';
            $_SESSION['jenis'] = 'warning';
            $this->redirect('pasien', 'index');
        }

        if ($this->pasien->hapus($id)) {
            $this->hapusFileFoto($pasien['foto']);
            $_SESSION['pesan'] = 'Data pasien berhasil dihapus.';
            $_SESSION['jenis'] = 'success';
        } else {
            $_SESSION['pesan'] = 'Gagal menghapus data pasien.';
            $_SESSION['jenis'] = 'danger';
        }

        $this->redirect('pasien', 'index');
    }

    private function unggahFoto()
    {
        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['pesan'] = 'Foto pasien wajib diunggah.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('pasien', 'create');
            return false;
        }

        $file = $_FILES['foto'];
        $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $diizinkan = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ekstensi, $diizinkan)) {
            $_SESSION['pesan'] = 'Format foto harus JPG, JPEG, PNG, atau WEBP.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('pasien', 'create');
            return false;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            $_SESSION['pesan'] = 'Ukuran foto maksimal 2 MB.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('pasien', 'create');
            return false;
        }

        $mime = mime_content_type($file['tmp_name']);
        $mimeDiizinkan = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($mime, $mimeDiizinkan)) {
            $_SESSION['pesan'] = 'File yang diunggah bukan gambar yang valid.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('pasien', 'create');
            return false;
        }

        $namaFoto = bin2hex(random_bytes(16)) . '.' . $ekstensi;
        $folder = __DIR__ . '/../../assets/images/pasien/';

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $folder . $namaFoto)) {
            $_SESSION['pesan'] = 'Gagal mengunggah foto.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('pasien', 'create');
            return false;
        }

        return $namaFoto;
    }

    private function hapusFileFoto($namaFile)
    {
        if (empty($namaFile)) {
            return;
        }
        $path = __DIR__ . '/../../assets/images/pasien/' . basename($namaFile);
        if (is_file($path)) {
            unlink($path);
        }
    }

    private function redirect($module, $action)
    {
        header("Location: index.php?module={$module}&action={$action}");
        exit;
    }
}
