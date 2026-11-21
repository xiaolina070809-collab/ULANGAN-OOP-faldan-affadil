CREATE DATABASE IF NOT EXISTS klinik_faldan
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE klinik_faldan;

CREATE TABLE IF NOT EXISTS pasien (
  idpasien INT AUTO_INCREMENT PRIMARY KEY,
  namapasien VARCHAR(100) NOT NULL,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  usia INT NOT NULL,
  alergi VARCHAR(255) NOT NULL,
  jeniskelamin VARCHAR(20) NOT NULL,
  alamat VARCHAR(255) NULL,
  nohp VARCHAR(15) NULL,
  foto VARCHAR(255) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS kunjungan (
  idkunjungan INT AUTO_INCREMENT PRIMARY KEY,
  idpasien INT NOT NULL,
  tanggalkunjungan DATE NOT NULL,
  keluhan TEXT NULL,
  diagnosis TEXT NULL,
  totalkunjungan INT DEFAULT 0,
  jumlahbayar INT NOT NULL DEFAULT 0,
  kembalian INT NOT NULL DEFAULT 0,
  statuspembayaran ENUM('Belum Bayar','Lunas') NOT NULL DEFAULT 'Belum Bayar',
  statuskunjungan ENUM('Proses','Selesai') NOT NULL DEFAULT 'Proses',
  CONSTRAINT fk_kunjungan_pasien FOREIGN KEY (idpasien)
    REFERENCES pasien(idpasien) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Akun pasien contoh dapat dibuat melalui formulir aplikasi.
-- Password pada aplikasi disimpan menggunakan password_hash().
