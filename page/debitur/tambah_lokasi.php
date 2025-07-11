<?php
include "./function/connection.php";

if (!isset($_SESSION['nama'])) {
    header('Location: index.php?halaman=login');
    exit;
}

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $select = mysqli_query($connection, "SELECT * FROM debitur WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            header('Location: index.php?halaman=debitur');
            exit;
        }

        $cekLokasi = mysqli_query($connection, "SELECT * FROM lokasi WHERE id_debitur = '$id'");
        $lokasiSudahAda = mysqli_num_rows($cekLokasi) > 0;

        if (isset($_POST['submit']) && !$lokasiSudahAda) {
            $ruangan = htmlspecialchars($_POST['ruangan']);
            $digitalisasi = htmlspecialchars($_POST['digitalisasi']);

            // Jika bukan musnahkan, ambil lemari, rak, baris
            if ($ruangan !== 'musnahkan') {
                $lemari = htmlspecialchars($_POST['lemari']);
                $rak = htmlspecialchars($_POST['rak']);
                $baris = htmlspecialchars($_POST['baris']);

                // Cek posisi tidak boleh sama di ruangan yang sama
                $cekPosisi = mysqli_query($connection, "SELECT * FROM lokasi WHERE ruangan = '$ruangan' AND lemari = '$lemari' AND rak = '$rak' AND baris = '$baris'");
                if (mysqli_num_rows($cekPosisi) > 0) {
                    echo "
                    <script>
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Posisi penyimpanan ini sudah digunakan di ruangan yang sama.',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })
                    </script>
                    ";
                    return;
                }
            } else {
                $lemari = $rak = $baris = null;
            }

            $query = mysqli_query($connection, "
                INSERT INTO lokasi (id_debitur, ruangan, lemari, rak, baris, digitalisasi)
                VALUES ('$id', '$ruangan', " . ($lemari ? "'$lemari'" : "NULL") . ", " . ($rak ? "'$rak'" : "NULL") . ", " . ($baris ? "'$baris'" : "NULL") . ", '$digitalisasi')
            ");

            if ($query) {
                echo "
                <script>
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Lokasi berhasil ditambahkan.',
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
                echo "
                <script>
                Swal.fire({
                    title: 'Gagal',
                    text: 'Gagal menambahkan lokasi.',
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
    } else {
        header('Location: index.php?halaman=debitur');
        exit;
    }
} catch (\Throwable $th) {
    echo "
    <script>
    Swal.fire({
        title: 'Error',
        text: 'Terjadi kesalahan pada server.',
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

<!-- HTML Form -->
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Tambah Lokasi</h3>
                <p class="text-muted">Menentukan lokasi penyimpanan data debitur</p>
            </div>
        </div>
    </div>

    <section class="section">
        <a href="index.php?halaman=debitur" class="btn btn-primary btn-sm mb-3">Kembali</a>
        <div class="card">
            <div class="card-body">
                <?php if ($lokasiSudahAda): ?>
                    <div class="alert alert-warning">
                        Lokasi untuk debitur dengan CIF <strong><?= htmlspecialchars($data['cif']) ?></strong> sudah terdaftar.
                        Silakan update/hapus dari menu <strong>Lokasi Penyimpanan</strong>.
                    </div>
                <?php else: ?>
                    <form action="" method="post">

                        <!-- Ruangan -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="ruangan" id="ruangan" required>
                                <option disabled selected>Pilih Ruangan</option>
                                <option value="ruangan arsip">Ruangan Arsip</option>
                                <option value="gudang">Gudang</option>
                                <option value="musnahkan">Musnahkan</option>
                            </select>
                            <label>Ruangan</label>
                        </div>

                        <!-- Lemari -->
                        <div class="form-floating mb-3" id="lemari-field">
                            <select class="form-select" name="lemari">
                                <option disabled selected>Pilih Lemari</option>
                                <?php foreach (range('A', 'Z') as $char): ?>
                                    <option value="<?= $char ?>"><?= $char ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label>Lemari</label>
                        </div>

                        <!-- Rak -->
                        <div class="form-floating mb-3" id="rak-field">
                            <select class="form-select" name="rak">
                                <option disabled selected>Pilih Rak</option>
                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                    <option value="<?= $i ?>">Rak <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <label>Rak</label>
                        </div>

                        <!-- Baris -->
                        <div class="form-floating mb-3" id="baris-field">
                            <select class="form-select" name="baris">
                                <option disabled selected>Pilih Baris</option>
                                <?php for ($i = 1; $i <= 40; $i++): ?>
                                    <option value="<?= $i ?>">Baris <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <label>Baris</label>
                        </div>

                        <!-- Digitalisasi -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="digitalisasi" required>
                                <option disabled selected>Status Digitalisasi</option>
                                <option value="Sudah">Sudah</option>
                                <option value="Belum">Belum</option>
                            </select>
                            <label>Digitalisasi</label>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="submit">Simpan Lokasi</button>
                        </div>

                        <!-- JavaScript untuk hide lemari/rak/baris -->
                        <script>
                            const ruanganSelect = document.getElementById('ruangan');
                            const lemariField = document.getElementById('lemari-field');
                            const rakField = document.getElementById('rak-field');
                            const barisField = document.getElementById('baris-field');
                            const lemariSelect = document.querySelector('select[name="lemari"]');
                            const rakSelect = document.querySelector('select[name="rak"]');
                            const barisSelect = document.querySelector('select[name="baris"]');

                            function toggleFields() {
                                const isMusnahkan = ruanganSelect.value === 'musnahkan';
                                lemariField.style.display = isMusnahkan ? 'none' : '';
                                rakField.style.display = isMusnahkan ? 'none' : '';
                                barisField.style.display = isMusnahkan ? 'none' : '';
                                lemariSelect.disabled = isMusnahkan;
                                rakSelect.disabled = isMusnahkan;
                                barisSelect.disabled = isMusnahkan;
                            }

                            ruanganSelect.addEventListener('change', toggleFields);
                            window.addEventListener('DOMContentLoaded', toggleFields);
                        </script>

                    </form>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
