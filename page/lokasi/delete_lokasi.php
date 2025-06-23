<?php
include "./function/connection.php";

try {
    if (!isset($_SESSION['nama'])) {
        header('Location: index.php?halaman=login');
        exit;
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $select = mysqli_query($connection, "SELECT baris FROM lokasi WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            header('Location: index.php?halaman=lokasi');
            exit;
        }

        $query = mysqli_query($connection, "DELETE FROM lokasi WHERE id = '$id'");

        if ($query) {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
            Swal.fire({
                title: 'Berhasil',
                text: 'Data lokasi berhasil dihapus',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = 'index.php?halaman=lokasi';
            });
            </script>";
        } else {
            $error = mysqli_error($connection);
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
            Swal.fire({
                title: 'Gagal',
                text: 'Gagal menghapus data lokasi: $error',
                icon: 'error',
                showConfirmButton: true
            });
            </script>";
        }
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            title: 'Error',
            text: 'ID lokasi tidak ditemukan!',
            icon: 'warning',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location.href = 'index.php?halaman=lokasi';
        });
        </script>";
    }
} catch (\Throwable $th) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Terjadi kesalahan pada server!',
        icon: 'error',
        showConfirmButton: false,
        timer: 2000
    }).then(() => {
        window.location.href = 'index.php?halaman=lokasi';
    });
    </script>";
}
?>
