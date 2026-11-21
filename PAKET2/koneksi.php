<?php
class Koneksi {
    private string $server = 'localhost';
    private string $user = 'root';
    private string $pass = '';
    private string $database = 'klinik_faldan';
    protected mysqli $koneksi;

    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->koneksi = new mysqli($this->server, $this->user, $this->pass, $this->database);
            $this->koneksi->set_charset('utf8mb4');
        } catch (mysqli_sql_exception $e) {
            die('Koneksi database gagal. Pastikan MySQL aktif dan database klinik_faldan sudah diimpor. Detail: ' .
                htmlspecialchars($e->getMessage()));
        }
    }
    public function getKoneksi(): mysqli { return $this->koneksi; }
}