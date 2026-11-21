<?php

class Koneksi
{
    private $server = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $database = 'klinikfaldan';

    protected $koneksi;

    public function __construct()
    {
        $this->koneksi = new mysqli(
            $this->server,
            $this->user,
            $this->pass,
            $this->database
        );

        if ($this->koneksi->connect_error) {
            die("Koneksi Gagal: " . $this->koneksi->connect_error);
        }

        $this->koneksi->set_charset("utf8mb4");
    }

    public function cekKoneksi()
    {
        return $this->koneksi->ping();
    }

    public function getKoneksi()
    {
        return $this->koneksi;
    }
}

$database = new Koneksi();
return $database->getKoneksi();
