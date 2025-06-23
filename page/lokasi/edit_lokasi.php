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
        $select = mysqli_query($connection, "SELECT * FROM lokasi WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            header('Location: index.php?halaman=lokasi');
        }

        // Submit
        if (isset($_POST['submit'])) {
            $ruangan = htmlspecialchars($_POST['ruangan']);
            $digitalisasi = htmlspecialchars($_POST['digitalisasi']);

            // Jika musnahkan, kosongkan kolom lemari, rak, baris
            if ($ruangan === 'musnahkan') {
                $lemari = '';
                $rak = '';
                $baris = '';
            } else {
                $lemari = htmlspecialchars($_POST['lemari']);
                $rak = htmlspecialchars($_POST['rak']);
                $baris = htmlspecialchars($_POST['baris']);
            }

            $query = mysqli_query($connection, "UPDATE lokasi SET ruangan = '$ruangan', lemari = '$lemari', rak = '$rak', baris = '$baris', digitalisasi = '$digitalisasi' WHERE id = '$id'");

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
                    window.location.href = 'index.php?halaman=lokasi';
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
                    window.location.href = 'index.php?halaman=lokasi';
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
        window.location.href = 'index.php?halaman=lokasi';
    })
    </script>
    ";
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Lokasi Penyimpanan</h3>
                <p class="text-subtitle text-muted">
                    Halaman Ubah Data Lokasi Penyimpanan
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=debitur">Lokasi</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Ubah Data Lokasi Penyimpanan
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
                        <select class="form-select" id="ruangan" name="ruangan" required>
                            <option disabled>Pilih Ruangan</option>
                            <option value="ruangan arsip" <?= $data['ruangan'] == 'ruangan arsip' ? 'selected' : '' ?>>Ruangan Arsip</option>
                            <option value="gudang" <?= $data['ruangan'] == 'gudang' ? 'selected' : '' ?>>Gudang</option>
                            <option value="musnahkan" <?= $data['ruangan'] == 'musnahkan' ? 'selected' : '' ?>>Musnahkan</option>
                        </select>
                        <label for="ruangan">Ruangan</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="lemari" name="lemari" required>
                            <?php foreach (range('A', 'Z') as $char): ?>
                                <option value="<?= $char ?>" <?= $data['lemari'] == $char ? 'selected' : '' ?>><?= $char ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="lemari">Lemari</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="rak" name="rak" required>
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                                <option value="<?= $i ?>" <?= $data['rak'] == $i ? 'selected' : '' ?>>Rak <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="rak">Rak</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="baris" name="baris" required>
                            <?php for ($i = 1; $i <= 40; $i++): ?>
                                <option value="<?= $i ?>" <?= $data['baris'] == $i ? 'selected' : '' ?>>Baris <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="baris">Baris</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="digitalisasi" name="digitalisasi" required>
                            <option value="Sudah" <?= $data['digitalisasi'] == 'Sudah' ? 'selected' : '' ?>>Sudah</option>
                            <option value="belum" <?= $data['digitalisasi'] == 'belum' ? 'selected' : '' ?>>Belum</option>
                        </select>
                        <label for="digitalisasi">Digitalisasi</label>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript untuk menonaktifkan field jika ruangan == musnahkan -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ruanganSelect = document.getElementById('ruangan');
    const lemariSelect = document.getElementById('lemari');
    const rakSelect = document.getElementById('rak');
    const barisSelect = document.getElementById('baris');

    function toggleFields() {
        const isMusnahkan = ruanganSelect.value === 'musnahkan';
        lemariSelect.disabled = isMusnahkan;
        rakSelect.disabled = isMusnahkan;
        barisSelect.disabled = isMusnahkan;

        if (isMusnahkan) {
            lemariSelect.value = '';
            rakSelect.value = '';
            barisSelect.value = '';
        }
    }

    toggleFields();
    ruanganSelect.addEventListener('change', toggleFields);
});
</script>
