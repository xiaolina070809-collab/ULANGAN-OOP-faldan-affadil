<?php
namespace App\Controllers;
use App\Models\Pasien;
use mysqli;

class PasienController {
    private Pasien $model;
    public function __construct(mysqli $db) { $this->model=new Pasien($db); }
    private function render(string $view,array $data=[]): void { extract($data); require __DIR__ . '/../../views/Pasien/'.$view.'.php'; }
    private function dataForm(): array {
        $d=$_POST;
        foreach (['namapasien','username','alergi','jeniskelamin','alamat','nohp'] as $k) $d[$k]=trim($d[$k] ?? '');
        $d['usia']=(int)($d['usia'] ?? 0); $d['password']=$d['password'] ?? '';
        if ($d['namapasien']==='' || $d['username']==='' || $d['usia']<0 || $d['jeniskelamin']==='' || ($d['password']==='' && !isset($_GET['id']))) throw new \RuntimeException('Lengkapi data wajib. Password wajib diisi saat menambah pasien.');
        $d['foto']=$this->uploadFoto($_FILES['foto'] ?? null, $_POST['foto_lama'] ?? '');
        return $d;
    }
    private function uploadFoto(?array $f,string $lama=''): string {
        if (!$f || ($f['error'] ?? UPLOAD_ERR_NO_FILE)===UPLOAD_ERR_NO_FILE) return $lama ?: 'default.png';
        if ($f['error']!==UPLOAD_ERR_OK) throw new \RuntimeException('Upload foto gagal.');
        $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
        if (!in_array($ext,['jpg','jpeg','png','webp'])) throw new \RuntimeException('Foto harus JPG, PNG, atau WEBP.');
        if ($f['size']>2*1024*1024) throw new \RuntimeException('Ukuran foto maksimal 2 MB.');
        $name=uniqid('pasien_',true).'.'.$ext; $dir=__DIR__.'/../../assets/images/pasien/';
        if (!is_dir($dir)) mkdir($dir,0775,true);
        if (!move_uploaded_file($f['tmp_name'],$dir.$name)) throw new \RuntimeException('Tidak dapat menyimpan foto.');
        if ($lama && $lama!=='default.png' && is_file($dir.$lama)) @unlink($dir.$lama);
        return $name;
    }
    public function index(): void { $this->render('index',['data'=>$this->model->tampil()]); }
    public function create(): void { $this->render('form',['title'=>'Tambah Pasien','item'=>null]); }
    public function store(): void { $this->model->tambah($this->dataForm()); header('Location: index.php?module=pasien'); exit; }
    public function edit(int $id): void { $item=$this->model->ambil($id); if(!$item) throw new \RuntimeException('Pasien tidak ditemukan.'); $this->render('form',['title'=>'Edit Pasien','item'=>$item]); }
    public function update(int $id): void { $old=$this->model->ambil($id); if(!$old) throw new \RuntimeException('Pasien tidak ditemukan.'); $_GET['id']=$id; $d=$this->dataForm(); if($d['foto']==='default.png' && $old['foto']!=='default.png') $d['foto']=$old['foto']; $this->model->ubah($id,$d); header('Location: index.php?module=pasien'); exit; }
    public function show(int $id): void { $item=$this->model->ambil($id); if(!$item) throw new \RuntimeException('Pasien tidak ditemukan.'); $this->render('show',['item'=>$item]); }
    public function delete(int $id): void { $item=$this->model->ambil($id); if(!$item) throw new \RuntimeException('Pasien tidak ditemukan.'); $this->model->hapus($id); if($item['foto']!=='default.png') @unlink(__DIR__.'/../../assets/images/pasien/'.$item['foto']); header('Location: index.php?module=pasien'); exit; }
}