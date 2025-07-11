<?php
include "./function/connection.php";

// Ambil data lokasi dan debitur
$query = mysqli_query($connection, "SELECT lokasi.*, debitur.cif, debitur.rekening, debitur.nama, debitur.usia_arsip FROM lokasi JOIN debitur ON lokasi.id_debitur = debitur.id");

$resultLokasi = mysqli_query($connection, "SELECT COUNT(*) AS total FROM lokasi");
$dataLokasi = mysqli_fetch_assoc($resultLokasi);
$totalLokasi = $dataLokasi['total'];

?>

<style>
  /* Memperindah tampilan tabel */
  #table {
    border-collapse: collapse;
    font-size: 14px;
  }

  #table thead {
    background-color: #f0f4f8;
    color: #333;
  }

  #table th, #table td {
    padding: 10px;
    vertical-align: middle;
  }

  /* Hover baris tabel */
  #table tbody tr:hover {
    background-color: #f9fbfc;
  }

  /* Tombol lebih menarik */
  .btn-sm {
    font-size: 13px;
    padding: 6px 10px;
    border-radius: 5px;
  }

  .btn-warning {
    background-color: #f0ad4e;
    border: none;
  }

  .btn-warning:hover {
    background-color: #ec971f;
  }

  .btn-primary {
    background-color: #4e73df;
    border: none;
  }

  .btn-primary:hover {
    background-color: #2e59d9;
  }

  .btn-danger {
    background-color: #e74a3b;
    border: none;
  }

  .btn-danger:hover {
    background-color: #c0392b;
  }

</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Lokasi Penyimpanan</h3>
                <p class="text-subtitle text-muted">Halaman Informasi Lokasi Penyimpanan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Data Debitur</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lokasi Penyimpanan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <a href="index.php?halaman=tambah_lokasi" class="btn btn-primary btn-sm mb-3">Tambah Lokasi</a>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>CIF</th>
                                <th>Rekening</th>
                                <th>Nama</th>
                                <th>Usia Arsip</th>
                                <th>Ruangan</th>
                                <th>Lemari</th>
                                <th>Rak</th>
                                <th>Baris</th>
                                <th>Digitalisasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query) > 0): ?>
                                <?php $no = 1; ?>
                                <?php while ($data = mysqli_fetch_assoc($query)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($data['cif']) ?></td>
                                        <td><?= htmlspecialchars($data['rekening']) ?></td>
                                        <td><?= htmlspecialchars($data['nama']) ?></td>
                                        <?php
                                            $tanggal_masuk = new DateTime("-{$data['usia_arsip']} days");
                                            $hari_ini = new DateTime();
                                            $selisih = $tanggal_masuk->diff($hari_ini);
                                            $usia_format = "{$selisih->y} tahun {$selisih->m} bulan {$selisih->d} hari";
                                        ?>
                                        <td><?= $usia_format ?></td>
                                        <td><?= ucfirst($data['ruangan']) ?></td>
                                        <td><?= ucfirst($data['lemari']) ?></td>
                                        <td><?= ucfirst($data['rak']) ?></td>
                                        <td><?= ucfirst($data['baris']) ?></td>
                                        <td><?= ucfirst($data['digitalisasi']) ?></td>
                                        <td>
                                            <a href="index.php?halaman=edit_lokasi&id=<?= $data['id'] ?>" class="btn btn-sm btn-warning">Update</a>
                                            <a class="btn btn-danger btn-sm" id="btn-hapus" href="index.php?halaman=delete_lokasi&id=<?= $data['id'] ?>" onclick="confirmModal(event)">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center">Belum ada data lokasi penyimpanan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Datatables -->
<script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="./assets/static/js/pages/simple-datatables.js"></script>
