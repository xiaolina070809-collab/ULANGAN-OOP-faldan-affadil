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

    public function edit($id)
    {
        $data = $this->pasien->ambil($id);
        if (!$data) {
            $this->redirect("Data pasien tidak ditemukan.", "gagal");
        }
        require __DIR__ . '/../../views/Pasien/edit.php';
    }

    public function show($id)
    {
        $data = $this->pasien->ambil($id);
        if (!$data) {
            $this->redirect("Data pasien tidak ditemukan.", "gagal");
        }
        require __DIR__ . '/../../views/Pasien/show.php';
    }

    public function store()
    {
        $data = $this->validasi($_POST, true);
        if ($data === false) {
            $this->redirect("Data tidak valid. Periksa kembali form.", "gagal");
        }

        $foto = $this->uploadFoto($_FILES['foto'] ?? [], null, true);
        if ($foto === false) {
            $this->redirect($_SESSION['pesan_upload'] ?? "Upload foto gagal.", "gagal");
        }

        $data['foto'] = $foto;

        if ($this->pasien->tambah($data)) {
            $this->redirect("Data pasien berhasil ditambahkan.", "sukses");
        }

        $this->hapusFileFoto($foto);
        $this->redirect("Data pasien gagal ditambahkan.", "gagal");
    }

    public function update($id)
    {
        $pasienLama = $this->pasien->ambil($id);
        if (!$pasienLama) {
            $this->redirect("Data pasien tidak ditemukan.", "gagal");
        }

        $data = $this->validasi($_POST, false);
        if ($data === false) {
            $this->redirect("Data tidak valid. Periksa kembali form.", "gagal");
        }

        $fotoLama = $pasienLama['foto'];
        $fotoBaru = $this->uploadFoto($_FILES['foto'] ?? [], $fotoLama, false);

        if ($fotoBaru === false) {
            $this->redirect($_SESSION['pesan_upload'] ?? "Upload foto gagal.", "gagal");
        }

        $data['foto'] = $fotoBaru;

        if ($this->pasien->ubah($id, $data)) {
            if ($fotoBaru !== $fotoLama) {
                $this->hapusFileFoto($fotoLama);
            }
            $this->redirect("Data pasien berhasil diperbarui.", "sukses");
        }

        if ($fotoBaru !== $fotoLama) {
            $this->hapusFileFoto($fotoBaru);
        }
        $this->redirect("Data pasien gagal diperbarui.", "gagal");
    }

    public function delete($id)
    {
        $data = $this->pasien->ambil($id);
        if (!$data) {
            $this->redirect("Data pasien tidak ditemukan.", "gagal");
        }

        if ($this->pasien->hapus($id)) {
            $this->hapusFileFoto($data['foto']);
            $this->redirect("Data pasien berhasil dihapus.", "sukses");
        }

        $this->redirect("Data pasien gagal dihapus.", "gagal");
    }

    private function validasi($input, $passwordWajib = true)
    {
        $nama = trim($input['namapasien'] ?? '');
        $username = trim($input['username'] ?? '');
        $password = $input['password'] ?? '';
        $usia = $input['usia'] ?? '';
        $alergi = trim($input['alergi'] ?? '');
        $jk = $input['jeniskelamin'] ?? '';
        $alamat = trim($input['alamat'] ?? '');
        $nohp = trim($input['nohp'] ?? '');

        if ($nama === '' || strlen($nama) > 100 ||
            $username === '' || strlen($username) > 100) {
            return false;
        }

        if (($passwordWajib && $password === '') || strlen($password) > 255) {
            return false;
        }

        if ($usia === '' || !ctype_digit((string)$usia) ||
            (int)$usia < 1 || (int)$usia > 150) {
            return false;
        }

        if ($alergi === '' || strlen($alergi) > 255) {
            return false;
        }

        if (!in_array($jk, ['Laki-laki', 'Perempuan'], true)) {
            return false;
        }

        if (strlen($alamat) > 255 ||
            strlen($nohp) > 15 ||
            !preg_match('/^[0-9]*$/', $nohp)) {
            return false;
        }

        return [
            'namapasien' => $nama,
            'username' => $username,
            'password' => $password,
            'usia' => (int)$usia,
            'alergi' => $alergi,
            'jeniskelamin' => $jk,
            'alamat' => $alamat,
            'nohp' => $nohp
        ];
    }

    private function uploadFoto($file, $fotoLama = null, $wajib = false)
    {
        if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            if ($wajib) {
                $_SESSION['pesan_upload'] = "Foto pasien wajib diunggah.";
                return false;
            }
            return $fotoLama;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['pesan_upload'] = "Terjadi kesalahan saat mengunggah foto.";
            return false;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            $_SESSION['pesan_upload'] = "Ukuran foto maksimal 2 MB.";
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $jenisFoto = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];

        if (!isset($jenisFoto[$mime]) || getimagesize($file['tmp_name']) === false) {
            $_SESSION['pesan_upload'] = "Format foto harus JPG, JPEG, PNG, atau WEBP.";
            return false;
        }

        $folderFoto = __DIR__ . '/../../assets/images/pasien/';
        if (!is_dir($folderFoto)) {
            mkdir($folderFoto, 0755, true);
        }

        $namaFile = bin2hex(random_bytes(16)) . '.' . $jenisFoto[$mime];
        if (!move_uploaded_file($file['tmp_name'], $folderFoto . $namaFile)) {
            $_SESSION['pesan_upload'] = "Foto gagal disimpan ke folder.";
            return false;
        }

        return $namaFile;
    }

    private function hapusFileFoto($namaFile)
    {
        if ($namaFile === '') {
            return;
        }

        $lokasi = __DIR__ . '/../../assets/images/pasien/' . basename($namaFile);
        if (is_file($lokasi)) {
            unlink($lokasi);
        }
    }

    private function redirect($pesan, $jenis)
    {
        $_SESSION['pesan'] = $pesan;
        $_SESSION['jenis'] = $jenis;
        unset($_SESSION['pesan_upload']);
        header("Location: index.php");
        exit;
    }
}
