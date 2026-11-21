<?php

namespace App\Models;

class Kunjungan
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    public function tampil()
    {
        $query = "SELECT kunjungan.*, pasien.namapasien
                  FROM kunjungan
                  INNER JOIN pasien ON kunjungan.idpasien = pasien.idpasien
                  ORDER BY kunjungan.idkunjungan DESC";
        return $this->koneksi->query($query);
    }

    public function ambil($id)
    {
        $query = "SELECT kunjungan.*, pasien.namapasien
                  FROM kunjungan
                  INNER JOIN pasien ON kunjungan.idpasien = pasien.idpasien
                  WHERE kunjungan.idkunjungan = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function tampilPasien()
    {
        $query = "SELECT idpasien, namapasien FROM pasien ORDER BY namapasien ASC";
        return $this->koneksi->query($query);
    }

    public function tambah($data)
    {
        $query = "INSERT INTO kunjungan
            (idpasien, tanggalkunjungan, keluhan, diagnosis,
             totalkunjungan, jumlahbayar, kembalian,
             statuspembayaran, statuskunjungan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param(
            "isssiiiss",
            $data['idpasien'],
            $data['tanggalkunjungan'],
            $data['keluhan'],
            $data['diagnosis'],
            $data['totalkunjungan'],
            $data['jumlahbayar'],
            $data['kembalian'],
            $data['statuspembayaran'],
            $data['statuskunjungan']
        );

        return $stmt->execute();
    }

    public function ubah($id, $data)
    {
        $query = "UPDATE kunjungan SET
            idpasien = ?,
            tanggalkunjungan = ?,
            keluhan = ?,
            diagnosis = ?,
            totalkunjungan = ?,
            jumlahbayar = ?,
            kembalian = ?,
            statuspembayaran = ?,
            statuskunjungan = ?
            WHERE idkunjungan = ?";

        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param(
            "isssiiissi",
            $data['idpasien'],
            $data['tanggalkunjungan'],
            $data['keluhan'],
            $data['diagnosis'],
            $data['totalkunjungan'],
            $data['jumlahbayar'],
            $data['kembalian'],
            $data['statuspembayaran'],
            $data['statuskunjungan'],
            $id
        );

        return $stmt->execute();
    }

    public function hapus($id)
    {
        $stmt = $this->koneksi->prepare("DELETE FROM kunjungan WHERE idkunjungan = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
