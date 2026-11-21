<?php

namespace App\Controllers;

use App\Models\Kunjungan;

class KunjunganController
{
    private $kunjungan;

    public function __construct($koneksi)
    {
        $this->kunjungan = new Kunjungan($koneksi);
    }

    public function index()
    {
        $dataKunjungan = $this->kunjungan->tampil();
        require __DIR__ . '/../../views/Kunjungan/index.php';
    }

    public function create()
    {
        $daftarPasien = $this->kunjungan->tampilPasien();
        require __DIR__ . '/../../views/Kunjungan/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('kunjungan', 'index');
        }

        $total = (int) ($_POST['totalkunjungan'] ?? 0);
        $bayar = (int) ($_POST['jumlahbayar'] ?? 0);
        $kembalian = max(0, $bayar - $total);

        $data = [
            'idpasien'         => (int) ($_POST['idpasien'] ?? 0),
            'tanggalkunjungan' => $_POST['tanggalkunjungan'] ?? date('Y-m-d'),
            'keluhan'          => trim($_POST['keluhan'] ?? ''),
            'diagnosis'        => trim($_POST['diagnosis'] ?? ''),
            'totalkunjungan'   => $total,
            'jumlahbayar'      => $bayar,
            'kembalian'        => $kembalian,
            'statuspembayaran' => $_POST['statuspembayaran'] ?? 'Belum Bayar',
            'statuskunjungan'  => $_POST['statuskunjungan'] ?? 'Proses'
        ];

        if ($this->kunjungan->tambah($data)) {
            $_SESSION['pesan'] = 'Data kunjungan berhasil ditambahkan.';
            $_SESSION['jenis'] = 'success';
        } else {
            $_SESSION['pesan'] = 'Gagal menambahkan data kunjungan.';
            $_SESSION['jenis'] = 'danger';
        }

        $this->redirect('kunjungan', 'index');
    }

    public function edit($id)
    {
        $kunjungan = $this->kunjungan->ambil($id);
        if (!$kunjungan) {
            $_SESSION['pesan'] = 'Data kunjungan tidak ditemukan.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('kunjungan', 'index');
        }
        $daftarPasien = $this->kunjungan->tampilPasien();
        require __DIR__ . '/../../views/Kunjungan/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('kunjungan', 'index');
        }

        $kunjunganLama = $this->kunjungan->ambil($id);
        if (!$kunjunganLama) {
            $_SESSION['pesan'] = 'Data kunjungan tidak ditemukan.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('kunjungan', 'index');
        }

        $total = (int) ($_POST['totalkunjungan'] ?? 0);
        $bayar = (int) ($_POST['jumlahbayar'] ?? 0);
        $kembalian = max(0, $bayar - $total);

        $data = [
            'idpasien'         => (int) ($_POST['idpasien'] ?? 0),
            'tanggalkunjungan' => $_POST['tanggalkunjungan'] ?? date('Y-m-d'),
            'keluhan'          => trim($_POST['keluhan'] ?? ''),
            'diagnosis'        => trim($_POST['diagnosis'] ?? ''),
            'totalkunjungan'   => $total,
            'jumlahbayar'      => $bayar,
            'kembalian'        => $kembalian,
            'statuspembayaran' => $_POST['statuspembayaran'] ?? 'Belum Bayar',
            'statuskunjungan'  => $_POST['statuskunjungan'] ?? 'Proses'
        ];

        if ($this->kunjungan->ubah($id, $data)) {
            $_SESSION['pesan'] = 'Data kunjungan berhasil diperbarui.';
            $_SESSION['jenis'] = 'success';
        } else {
            $_SESSION['pesan'] = 'Gagal memperbarui data kunjungan.';
            $_SESSION['jenis'] = 'danger';
        }

        $this->redirect('kunjungan', 'index');
    }

    public function show($id)
    {
        $kunjungan = $this->kunjungan->ambil($id);
        if (!$kunjungan) {
            $_SESSION['pesan'] = 'Data kunjungan tidak ditemukan.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('kunjungan', 'index');
        }
        require __DIR__ . '/../../views/Kunjungan/show.php';
    }

    public function delete($id)
    {
        $kunjungan = $this->kunjungan->ambil($id);
        if (!$kunjungan) {
            $_SESSION['pesan'] = 'Data kunjungan tidak ditemukan.';
            $_SESSION['jenis'] = 'danger';
            $this->redirect('kunjungan', 'index');
        }

        if ($this->kunjungan->hapus($id)) {
            $_SESSION['pesan'] = 'Data kunjungan berhasil dihapus.';
            $_SESSION['jenis'] = 'success';
        } else {
            $_SESSION['pesan'] = 'Gagal menghapus data kunjungan.';
            $_SESSION['jenis'] = 'danger';
        }

        $this->redirect('kunjungan', 'index');
    }

    private function redirect($module, $action)
    {
        header("Location: index.php?module={$module}&action={$action}");
        exit;
    }
}
