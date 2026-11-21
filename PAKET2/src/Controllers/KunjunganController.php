<?php
namespace App\Controllers;
use App\Models\Kunjungan;
use mysqli;

class KunjunganController {
    private Kunjungan $model;
    public function __construct(mysqli $db) { $this->model=new Kunjungan($db); }
    private function render(string $view,array $data=[]): void { extract($data); require __DIR__ . '/../../views/Kunjungan/'.$view.'.php'; }
    private function formData(): array {
        $d=['idpasien'=>(int)($_POST['idpasien']??0),'tanggal'=>$_POST['tanggal']??date('Y-m-d'),'keluhan'=>trim($_POST['keluhan']??''),'diagnosis'=>trim($_POST['diagnosis']??''),'total'=>(int)($_POST['total']??0),'bayar'=>(int)($_POST['bayar']??0),'pembayaran'=>$_POST['pembayaran']??'Belum Bayar','status'=>$_POST['status']??'Proses'];
        if($d['idpasien']<1 || $d['total']<0 || $d['bayar']<0) throw new \RuntimeException('Pilih pasien dan masukkan nominal yang benar.');
        if(!in_array($d['pembayaran'],['Belum Bayar','Lunas']) || !in_array($d['status'],['Proses','Selesai'])) throw new \RuntimeException('Status tidak valid.');
        $d['kembalian']=max(0,$d['bayar']-$d['total']); return $d;
    }
    public function index(): void { $this->render('index',['data'=>$this->model->tampil()]); }
    public function create(): void { $this->render('form',['title'=>'Tambah Kunjungan','item'=>null,'pasien'=>$this->model->tampilPasien()]); }
    public function store(): void { $this->model->tambah($this->formData()); header('Location: index.php?module=kunjungan'); exit; }
    public function edit(int $id): void { $item=$this->model->ambil($id); if(!$item) throw new \RuntimeException('Kunjungan tidak ditemukan.'); $this->render('form',['title'=>'Edit Kunjungan','item'=>$item,'pasien'=>$this->model->tampilPasien()]); }
    public function update(int $id): void { $this->model->ubah($id,$this->formData()); header('Location: index.php?module=kunjungan'); exit; }
    public function show(int $id): void { $item=$this->model->ambil($id); if(!$item) throw new \RuntimeException('Kunjungan tidak ditemukan.'); $this->render('show',['item'=>$item]); }
    public function delete(int $id): void { $this->model->hapus($id); header('Location: index.php?module=kunjungan'); exit; }
}