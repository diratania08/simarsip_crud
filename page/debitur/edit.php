<?php
include "./function/connection.php";

if (!isset($_SESSION['nama'])) {
    header('Location: index.php?halaman=login');
}


try {
    $message = "";
    $success = FALSE;
    $error = FALSE;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Select Data
        $select = mysqli_query($connection, "SELECT * FROM debitur WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            header('Location: index.php?halaman=debitur');
        }

        // Submit
        if (isset($_POST['submit'])) {
            $cif = htmlspecialchars($_POST['cif']);
            $rekening = htmlspecialchars($_POST['rekening']);
            $nama = htmlspecialchars($_POST['nama']);
            $alamat = htmlspecialchars($_POST['alamat']);
            $telepon = htmlspecialchars($_POST['telepon']);
            $nominal = htmlspecialchars($_POST['nominal']);
            $segmen = htmlspecialchars($_POST['segmen']);
            $tanggal_masuk = htmlspecialchars($_POST['tanggal_masuk']);

            // Ambil tanggal sekarang secara otomatis
             $tanggal_sekarang = date('Y-m-d');

            // Hitung usia arsip (dalam hari)
            $usia_arsip = floor((strtotime($tanggal_sekarang) - strtotime($tanggal_masuk)) / (60 * 60 * 24));

            $query = mysqli_query($connection, "UPDATE debitur SET cif = '$cif', rekening = '$rekening', nama = '$nama', alamat = '$alamat', telepon = '$telepon', nominal = '$nominal', segmen = '$segmen', tanggal_masuk = '$tanggal_masuk', tanggal_sekarang = '$tanggal_sekarang', usia_arsip = '$usia_arsip'  WHERE id = '$id'");

            if ($query == TRUE) {
                $message = "Berhasil mengubah data";
                echo "
            <script>
            Swal.fire({
                title: 'Berhasil',
                text: '$message',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
                window.location.href = 'index.php?halaman=debitur';
            })
            </script>
            ";
            } else {
                $message = "Gagal mengubah data";
                echo "
            <script>
            Swal.fire({
                title: 'Gagal',
                text: '$message',
                icon: 'error',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
                window.location.href = 'index.php?halaman=debitur';
            })
            </script>
            ";
            }
        }
    }
} catch (\Throwable $th) {
    echo "
            <script>
            Swal.fire({
                title: 'Gagal',
                text: 'Server error!',
                icon: 'error',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
                window.location.href = 'index.php?halaman=debitur';
            })
            </script>
            ";
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Debitur</h3>
                <p class="text-subtitle text-muted">
                    Halaman Ubah Data Debitur
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=debitur">Debitur</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Ubah Data Debitur
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <a href="index.php?halaman=debitur" class="btn btn-primary btn-sm mb-3">Kembali</a>
        <div class="card">
            <div class="card-body">
                <form action="" method="post">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="cif" placeholder="123456" name="cif" value="<?= $data['cif'] ?>" required>
                        <label for="cif">CIF</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="rekening" placeholder="987654321" name="rekening" value="<?= $data['rekening'] ?>" required>
                        <label for="rekening">Nomor Rekening</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nama" placeholder="John Doe" name="nama" value="<?= $data['nama'] ?>" required>
                        <label for="nama">Nama Debitur</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="alamat" placeholder="John Doe" name="alamat" value="<?= $data['alamat'] ?>" required>
                        <label for="alamat">Alamat Debitur</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="telepon" placeholder="081234567890" name="telepon" value="<?= $data['telepon'] ?>" required>
                        <label for="telepon">Nomor Kontak</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nominal" placeholder="10000000" name="nominal" value="<?= $data['nominal'] ?>" required>
                        <label for="nominal">Nominal Pinjaman</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="segmen" name="segmen" required>
                            <option disabled selected>Pilih Segmen</option>
                            <option value="KUR" <?= $data['segmen'] == 'KUR' ? 'selected' : '' ?>>KUR</option>
                            <option value="KUPEDES" <?= $data['segmen'] == 'KUPEDES' ? 'selected' : '' ?>>KUPEDES</option>
                            <option value="BRIGUNA" <?= $data['segmen'] == 'BRIGUNA' ? 'selected' : '' ?>>BRIGUNA</option>
                        </select>
                        <label for="segmen">Segmen</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?= $data['tanggal_masuk'] ?>" required>
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                    </div>

                    <!-- Tanggal Sekarang: otomatis (hidden) -->
                    <input type="hidden" name="tanggal_sekarang" value="<?= date('Y-m-d') ?>">

                    <!-- Usia Arsip: otomatis dihitung di PHP (hidden) -->
                    <?php
                        $tanggal_masuk = $data['tanggal_masuk'];
                        $tanggal_sekarang = date('Y-m-d');
                        $usia_arsip = floor((strtotime($tanggal_sekarang) - strtotime($tanggal_masuk)) / (60 * 60 * 24));
                    ?>
                    <input type="hidden" name="usia_arsip" value="<?= $usia_arsip ?>">
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>