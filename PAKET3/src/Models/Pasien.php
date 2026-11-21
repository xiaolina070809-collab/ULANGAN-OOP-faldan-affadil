<?php

namespace App\Models;

class Pasien
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    public function tampil()
    {
        $query = "SELECT * FROM pasien ORDER BY idpasien DESC";
        return $this->koneksi->query($query);
    }

    public function ambil($id)
    {
        $stmt = $this->koneksi->prepare("SELECT * FROM pasien WHERE idpasien = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function tambah($data)
    {
        $query = "INSERT INTO pasien
            (namapasien, username, password, usia, alergi,
             jeniskelamin, alamat, nohp, foto)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->koneksi->prepare($query);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bind_param(
            "sssisssss",
            $data['namapasien'],
            $data['username'],
            $password,
            $data['usia'],
            $data['alergi'],
            $data['jeniskelamin'],
            $data['alamat'],
            $data['nohp'],
            $data['foto']
        );

        return $stmt->execute();
    }

    public function ubah($id, $data)
    {
        if (!empty($data['password'])) {
            $query = "UPDATE pasien SET
                namapasien = ?, username = ?, password = ?, usia = ?,
                alergi = ?, jeniskelamin = ?, alamat = ?, nohp = ?, foto = ?
                WHERE idpasien = ?";

            $stmt = $this->koneksi->prepare($query);
            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt->bind_param(
                "sssisssssi",
                $data['namapasien'],
                $data['username'],
                $password,
                $data['usia'],
                $data['alergi'],
                $data['jeniskelamin'],
                $data['alamat'],
                $data['nohp'],
                $data['foto'],
                $id
            );
        } else {
            $query = "UPDATE pasien SET
                namapasien = ?, username = ?, usia = ?, alergi = ?,
                jeniskelamin = ?, alamat = ?, nohp = ?, foto = ?
                WHERE idpasien = ?";

            $stmt = $this->koneksi->prepare($query);
            $stmt->bind_param(
                "ssisssssi",
                $data['namapasien'],
                $data['username'],
                $data['usia'],
                $data['alergi'],
                $data['jeniskelamin'],
                $data['alamat'],
                $data['nohp'],
                $data['foto'],
                $id
            );
        }

        return $stmt->execute();
    }

    public function hapus($id)
    {
        $stmt = $this->koneksi->prepare("DELETE FROM pasien WHERE idpasien = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function hitungKunjungan($id)
    {
        $stmt = $this->koneksi->prepare(
            "SELECT COUNT(*) AS total FROM kunjungan WHERE idpasien = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return (int) ($row['total'] ?? 0);
    }
}
