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
);
