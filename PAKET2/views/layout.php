<?php
function h($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function rupiah($v): string { return 'Rp '.number_format((int)$v,0,',','.'); }
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Klinik Faldan</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="top"><div class="brand">✚ KLINIK <b>FALDAN</b><small>Pelayanan kesehatan keluarga</small></div><nav><a href="index.php?module=pasien">Data Pasien</a><a href="index.php?module=kunjungan">Kunjungan</a></nav></header><main class="wrap">
