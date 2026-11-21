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
        return $this->koneksi->query(
            "SELECT * FROM pasien ORDER BY idpasien DESC"
        );
    }

    public function ambil($id)
    {
        $stmt = $this->koneksi->prepare(
            "SELECT * FROM pasien WHERE idpasien = ?"
        );
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
        if ($data['password'] !== '') {
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
                "sissssssi",
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
        $stmt = $this->koneksi->prepare(
            "DELETE FROM pasien WHERE idpasien = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
