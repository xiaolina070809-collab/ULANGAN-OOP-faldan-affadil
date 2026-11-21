<?php

use App\Controllers\PasienController;
use App\Controllers\KunjunganController;

session_start();

require_once __DIR__ . '/vendor/autoload.php';

$koneksi = require __DIR__ . '/koneksi.php';

$module = $_GET['module'] ?? 'pasien';
$action = $_GET['action'] ?? 'index';
$id     = isset($_GET['id']) && ctype_digit((string)$_GET['id']) ? (int)$_GET['id'] : null;

if ($module === 'kunjungan') {
    $controller = new KunjunganController($koneksi);
} else {
    $controller = new PasienController($koneksi);
    $module = 'pasien';
}

switch ($action) {
    case 'index':
        $controller->index();
        break;

    case 'create':
        $controller->create();
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->store();
        } else {
            header("Location: index.php?module={$module}&action=index");
            exit;
        }
        break;

    case 'edit':
        if ($id !== null && $id > 0) {
            $controller->edit($id);
        } else {
            header("Location: index.php?module={$module}&action=index");
            exit;
        }
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id !== null && $id > 0) {
            $controller->update($id);
        } else {
            header("Location: index.php?module={$module}&action=index");
            exit;
        }
        break;

    case 'show':
        if ($id !== null && $id > 0) {
            $controller->show($id);
        } else {
            header("Location: index.php?module={$module}&action=index");
            exit;
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id !== null && $id > 0) {
            $controller->delete($id);
        } else {
            header("Location: index.php?module={$module}&action=index");
            exit;
        }
        break;

    default:
        header("Location: index.php?module={$module}&action=index");
        exit;
}
