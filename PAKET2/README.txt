KLINIK FALDAN - PAKET 2 (CRUD PASIEN DAN KUNJUNGAN)

Persyaratan:
- Laragon dengan Apache dan MySQL aktif
- PHP 8.0+ disarankan
- Ekstensi mysqli aktif
- phpMyAdmin

CARA MEMASANG:
1. Ekstrak folder KlinikFaldan ke C:\laragon\www\
2. Buka http://localhost/phpmyadmin
3. Pilih tab Import, pilih file database.sql dari folder KlinikFaldan, lalu klik Import/Go.
4. Pastikan pengaturan database di koneksi.php sesuai Laragon:
   server localhost, user root, password kosong, database klinik_faldan.
5. Jalankan Laragon (Start All).
6. Buka http://localhost/KlinikFaldan/

FITUR:
- CRUD data pasien
- Upload dan ganti foto pasien (JPG/PNG/WEBP, maksimal 2 MB)
- Password pasien disimpan dengan password_hash()
- CRUD kunjungan pasien
- Relasi One-to-Many pasien ke kunjungan
- Pilihan pasien pada formulir kunjungan
- Perhitungan kembalian sederhana
- Tampilan responsif

CATATAN:
- Folder assets/images/pasien harus dapat ditulisi oleh PHP.
- Pasien yang masih memiliki kunjungan tidak dapat dihapus (ON DELETE RESTRICT).
  Hapus riwayat kunjungannya terlebih dahulu jika memang perlu menghapus pasien.
- Aplikasi ini mengikuti cakupan Paket 2: data pasien dan data kunjungan. Tidak ada login admin dalam pedoman Paket 2.
- Composer PSR-4 dicantumkan pada composer.json. Aplikasi memiliki autoloader sederhana sehingga dapat dijalankan tanpa menjalankan Composer.
