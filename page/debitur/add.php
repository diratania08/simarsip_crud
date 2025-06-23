<?php
include "./function/connection.php";

try {
    $message = "";
    $success = FALSE;
    $error = FALSE;

    if (isset($_POST['submit'])) {
        $cif = htmlspecialchars($_POST['cif']);
        $rekening = htmlspecialchars($_POST['rekening']);
        $nama = htmlspecialchars($_POST['nama']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $telepon = htmlspecialchars($_POST['telepon']);
        $nominal = htmlspecialchars($_POST['nominal']);
        $segmen = htmlspecialchars($_POST['segmen']);

        // Ambil tanggal masuk dari form
        $tanggal_masuk = htmlspecialchars($_POST['tanggal_masuk']);

        // Tanggal sekarang otomatis
        $tanggal_sekarang = date('Y-m-d');

        // Hitung usia arsip dalam hari
        $diff = strtotime($tanggal_sekarang) - strtotime($tanggal_masuk);
        $usia_arsip = floor($diff / (60 * 60 * 24)); // konversi ke hari

        $query = mysqli_query($connection, "INSERT INTO debitur VALUES (null, '$cif', '$rekening', '$nama', '$alamat', '$telepon', '$nominal', '$segmen', '$tanggal_masuk', '$tanggal_sekarang', '$usia_arsip')");

        if ($query == TRUE) {
            $message = "Berhasil menambahkan data";
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
            $message = "Gagal menambahkan data";
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
                    Halaman Tambah Data Debitur
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=debitur">Debitur</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tambah Data Debitur
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
                        <input type="text" class="form-control" id="cif" placeholder="123456" name="cif" required>
                        <label for="cif">CIF</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="rekening" placeholder="987654321" name="rekening" required>
                        <label for="rekening">Nomor Rekening</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nama" placeholder="John Doe" name="nama" required>
                        <label for="nama">Nama Debitur</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="alamat" placeholder="Alamat Lengkap" name="alamat" style="height: 100px" required></textarea>
                        <label for="alamat">Alamat</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="telepon" placeholder="081234567890" name="telepon" required>
                        <label for="telepon">No Telepon</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nominal" placeholder="10000000" name="nominal" required>
                        <label for="nominal">Nominal Pinjaman</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="segmen" name="segmen" required>
                            <option selected disabled>Pilih Segmen</option>
                            <option value="KUR">KUR</option>
                            <option value="KUPEDES">KUPEDES</option>
                            <option value="BRIGUNA">BRIGUNA</option>
                        </select>
                        <label for="segmen">Segmen</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                        <label for="tanggal_masuk">Tanggal Masuk Arsip</label>
                    </div>

                    <!-- Tanggal sekarang & usia arsip otomatis via PHP -->
                    <input type="hidden" name="tanggal_sekarang" value="<?= date('Y-m-d'); ?>">
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>