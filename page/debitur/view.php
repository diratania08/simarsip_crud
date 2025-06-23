<?php
include "./function/connection.php";

$query = mysqli_query($connection, "SELECT * FROM debitur");

$countResult = mysqli_query($connection, "SELECT COUNT(*) AS total FROM debitur");
$countRow = mysqli_fetch_assoc($countResult);
$count = $countRow['total'];

?>

<style>
  /* ✅ Memperindah tampilan tabel */
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

  /* ✅ Hover baris tabel */
  #table tbody tr:hover {
    background-color: #f9fbfc;
  }

  /* ✅ Tombol lebih menarik */
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
                <h3>Informasi Debitur</h3>
                <p class="text-subtitle text-muted">
                    Halaman Informasi Data Debitur
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=debitur">Data Debitur</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Informasi Debitur
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <a href="index.php?halaman=tambah_debitur" class="btn btn-primary btn-sm mb-3">Tambah Debitur</a>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CIF</th>
                                <th>Nomor Rekening</th>
                                <th>Nama Debitur</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Nominal</th>
                                <th>Segmen</th>
                                <th>Tanggal Masuk Arsip</th>
                                <th>Tanggal Sekarang</th>
                                <th>Usia Arsip</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($query->num_rows > 0) : ?>
                                <?php
                                $i = 1;
                                while ($data = mysqli_fetch_assoc($query)) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $data['cif'] ?></td>
                                        <td><?= $data['rekening'] ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['alamat'] ?></td>
                                        <td><?= $data['telepon'] ?></td>
                                        <td><?= $data['nominal'] ?></td>
                                        <td><?= $data['segmen'] ?></td>
                                        <td><?= $data['tanggal_masuk'] ?></td>
                                        <td><?= $data['tanggal_sekarang'] ?></td>
                                        <td><?= $data['usia_arsip'] ?></td>
                                        <td>
                                            <a href="index.php?halaman=ubah_debitur&id=<?= $data['id'] ?>" class="btn btn-sm btn-warning" style="display:block; margin-bottom:5px;">Update</a>
                                            <a href="index.php?halaman=tambah_lokasi&id=<?= $data['id'] ?>" class="btn btn-sm btn-primary" style="display:block; margin-bottom:5px;">Tambah Lokasi</a>
                                            <a href="index.php?halaman=hapus_debitur&id=<?= $data['id'] ?>" class="btn btn-sm btn-danger" id="btn-hapus" style="display:block;" onclick="confirmModal(event)">Hapus</a>
                                        </td>

                                    </tr>
                                <?php endwhile ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script>
  // ✅ Inisialisasi tanpa fitur sorting
  const table = document.querySelector("#table");
  const dataTable = new simpleDatatables.DataTable(table, {
    searchable: true,   // tetap bisa cari
    fixedHeight: true,
    sortable: false     // ❌ Nonaktifkan sorting
  });
</script>
