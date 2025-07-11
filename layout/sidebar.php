<?php
$beranda = false;
$debitur = false;
$tambah = false;
$ubah = false;
$tambah_lokasi = false;
$lokasi = false; 
$edit_lokasi = false;
$delete_lokasi = false;

if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
    switch ($halaman) {
        case 'beranda':
            $beranda = true;
            break;
        case 'debitur':
            $debitur = true;
            break;
        case 'tambah_debitur':
            $tambah = true;
            break;
        case 'ubah_debitur':
            $ubah = true;
            break;
        case 'tambah_lokasi':
            $tambah_lokasi = true;
            break;
        case 'lokasi': 
            $lokasi = true;
            break;
        case 'edit_lokasi':
            $edit_lokasi = true;
            break;
        case 'delete_lokasi':
            $delete_lokasi = true;
            break;
        default:
            $beranda = $debitur = $tambah = $ubah = $tambah_lokasi = $lokasi = $edit_lokasi = $delete_lokasi = false;
    }
} else {
    $beranda = true;
}
?>

<div id="sidebar">
    <div class="sidebar-wrapper active">

        <!-- Mulai logo simarsip -->
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo" style="text-align: left;">
                <a href="index.php?halaman=beranda">
                    <img src="./assets/compiled/svg/logo2.svg" alt="Logo" style="width: 250px; height: auto; display: block;" />
                </a>
                </div>

                <!-- Mulai Tombol silang -->
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
                <!-- Akhir Tombol silang -->
            </div>
        </div>
        <!-- Akhir logo simarsip -->

        <!-- Mulai nama menu -->
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item <?= $beranda ? 'active' : '' ?>">
                    <a href="index.php?halaman=beranda" class="sidebar-link">
                        <i class="bi bi-ui-checks-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <?php if (isset($_SESSION['nama'])) : ?>
                    <li class="sidebar-title">Data Debitur</li>

                    <li class="sidebar-item <?= $debitur || $tambah || $ubah ? 'active' : '' ?>">
                        <a href="index.php?halaman=debitur" class="sidebar-link">
                            <i class="bi bi-file-earmark-person"></i>
                            <span>Informasi Debitur</span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= $lokasi || $edit_lokasi ? 'active' : '' ?>">
                        <a href="index.php?halaman=lokasi" class="sidebar-link">
                            <i class="bi bi-file-earmark-lock"></i>
                            <span>Lokasi Penyimpanan</span>
                        </a>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
        <!-- Akhir nama menu -->

    </div>
</div>
