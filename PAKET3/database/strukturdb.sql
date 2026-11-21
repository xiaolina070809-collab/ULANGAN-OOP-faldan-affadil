CREATE DATABASE IF NOT EXISTS klinikfaldan;
USE klinikfaldan;

CREATE TABLE IF NOT EXISTS pasien (
    idpasien INT AUTO_INCREMENT PRIMARY KEY,
    namapasien VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    usia INT NOT NULL,
    alergi VARCHAR(255) NOT NULL,
    jeniskelamin VARCHAR(20) NOT NULL,
    alamat VARCHAR(255),
    nohp VARCHAR(15),
    foto VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS kunjungan (
    idkunjungan INT AUTO_INCREMENT PRIMARY KEY,
    idpasien INT NOT NULL,
    tanggalkunjungan DATE NOT NULL,
    keluhan TEXT,
    diagnosis TEXT,
    totalkunjungan INT DEFAULT 0,
    jumlahbayar INT NOT NULL DEFAULT 0,
    kembalian INT NOT NULL DEFAULT 0,
    statuspembayaran ENUM('Belum Bayar','Lunas') NOT NULL DEFAULT 'Belum Bayar',
    statuskunjungan ENUM('Proses','Selesai') NOT NULL DEFAULT 'Proses',
    FOREIGN KEY (idpasien)
        REFERENCES pasien(idpasien)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;
