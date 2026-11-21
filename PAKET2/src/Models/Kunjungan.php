<?php
namespace App\Models;
use mysqli;

class Kunjungan {
    public function __construct(private mysqli $db) {}
    public function tampil(): array {
        return $this->db->query("SELECT k.*,p.namapasien FROM kunjungan k JOIN pasien p ON p.idpasien=k.idpasien ORDER BY k.tanggalkunjungan DESC,k.idkunjungan DESC")->fetch_all(MYSQLI_ASSOC);
    }
    public function ambil(int $id): ?array {
        $s=$this->db->prepare("SELECT k.*,p.namapasien FROM kunjungan k JOIN pasien p ON p.idpasien=k.idpasien WHERE k.idkunjungan=?"); $s->bind_param("i",$id); $s->execute();
        return $s->get_result()->fetch_assoc() ?: null;
    }
    public function tampilPasien(): array {
        return $this->db->query("SELECT idpasien,namapasien FROM pasien ORDER BY namapasien")->fetch_all(MYSQLI_ASSOC);
    }
    public function tambah(array $d): void {
        $s=$this->db->prepare("INSERT INTO kunjungan(idpasien,tanggalkunjungan,keluhan,diagnosis,totalkunjungan,jumlahbayar,kembalian,statuspembayaran,statuskunjungan) VALUES(?,?,?,?,?,?,?,?,?)");
        $s->bind_param("isssiiiss",$d['idpasien'],$d['tanggal'],$d['keluhan'],$d['diagnosis'],$d['total'],$d['bayar'],$d['kembalian'],$d['pembayaran'],$d['status']);
        $s->execute();
    }
    public function ubah(int $id,array $d): void {
        $s=$this->db->prepare("UPDATE kunjungan SET idpasien=?,tanggalkunjungan=?,keluhan=?,diagnosis=?,totalkunjungan=?,jumlahbayar=?,kembalian=?,statuspembayaran=?,statuskunjungan=? WHERE idkunjungan=?");
        $s->bind_param("isssiiissi",$d['idpasien'],$d['tanggal'],$d['keluhan'],$d['diagnosis'],$d['total'],$d['bayar'],$d['kembalian'],$d['pembayaran'],$d['status'],$id);
        $s->execute();
    }
    public function hapus(int $id): void {
        $s=$this->db->prepare("DELETE FROM kunjungan WHERE idkunjungan=?"); $s->bind_param("i",$id); $s->execute();
    }
}