<?php
namespace App\Models;
use mysqli;

class Pasien {
    public function __construct(private mysqli $db) {}
    public function tampil(): array {
        return $this->db->query("SELECT * FROM pasien ORDER BY idpasien DESC")->fetch_all(MYSQLI_ASSOC);
    }
    public function ambil(int $id): ?array {
        $s=$this->db->prepare("SELECT * FROM pasien WHERE idpasien=?"); $s->bind_param("i",$id); $s->execute();
        return $s->get_result()->fetch_assoc() ?: null;
    }
    public function tambah(array $d): void {
        $hash=password_hash($d['password'], PASSWORD_DEFAULT);
        $foto=$d['foto'] ?: 'default.png';
        $s=$this->db->prepare("INSERT INTO pasien(namapasien,username,password,usia,alergi,jeniskelamin,alamat,nohp,foto) VALUES(?,?,?,?,?,?,?,?,?)");
        $s->bind_param("sssisssss",$d['namapasien'],$d['username'],$hash,$d['usia'],$d['alergi'],$d['jeniskelamin'],$d['alamat'],$d['nohp'],$foto);
        $s->execute();
    }
    public function ubah(int $id,array $d): void {
        if ($d['password'] !== '') {
            $hash=password_hash($d['password'], PASSWORD_DEFAULT);
            $s=$this->db->prepare("UPDATE pasien SET namapasien=?,username=?,password=?,usia=?,alergi=?,jeniskelamin=?,alamat=?,nohp=?,foto=? WHERE idpasien=?");
            $s->bind_param("sssisssssi",$d['namapasien'],$d['username'],$hash,$d['usia'],$d['alergi'],$d['jeniskelamin'],$d['alamat'],$d['nohp'],$d['foto'],$id);
        } else {
            $s=$this->db->prepare("UPDATE pasien SET namapasien=?,username=?,usia=?,alergi=?,jeniskelamin=?,alamat=?,nohp=?,foto=? WHERE idpasien=?");
            $s->bind_param("ssisssssi",$d['namapasien'],$d['username'],$d['usia'],$d['alergi'],$d['jeniskelamin'],$d['alamat'],$d['nohp'],$d['foto'],$id);
        }
        $s->execute();
    }
    public function hapus(int $id): void {
        $s=$this->db->prepare("DELETE FROM pasien WHERE idpasien=?"); $s->bind_param("i",$id); $s->execute();
    }
}