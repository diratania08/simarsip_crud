<?php

if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
    switch ($halaman) {
        case 'beranda':
            include "page/index.php";
            break;
        case 'logout':
            include "page/logout.php";
            break;
        case 'debitur':
            include "page/debitur/view.php";
            break;
        case 'tambah_debitur':
            include "page/debitur/add.php";
            break;
        case 'ubah_debitur':
            include "page/debitur/edit.php";
            break;
        case 'hapus_debitur':
            include "page/debitur/delete.php";
            break;
        case 'tambah_lokasi':
            include "page/debitur/tambah_lokasi.php";
            break;
        case 'lokasi':
            include "page/lokasi/view_lokasi.php";
            break;
        case 'edit_lokasi':
            include "page/lokasi/edit_lokasi.php";
            break;
        case 'delete_lokasi':
            include "page/lokasi/delete_lokasi.php";
            break;

        default:
            include "page/error.php";
    }
} else {
    include "page/index.php";
}
