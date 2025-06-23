<?php
$now = time();

session_start();

if (!isset($_SESSION['nama'])) {
    header('Location: login.php');
}

if ($now > $_SESSION['timeout']) {
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AplikaSIMARSIP</title>

    <link rel="shortcut icon" href="assets/compiled/svg/judul.ico" type="image/x-icon"> 
    
    <link rel="stylesheet" href="./assets/extensions/simple-datatables/style.css" />
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable.css" />
    <link rel="stylesheet" href="./assets/compiled/css/app.css" />
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css" />
    <link rel="stylesheet" href="./assets/compiled/css/error.css" />
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script src="./assets/static/js/initTheme.js"></script>
    <div id="app">
        <!-- Start Sidebar -->
        <?php require("./layout/sidebar.php") ?>
        <!-- End Sidebar -->
        <div id="main" class="layout-navbar navbar-fixed">
            <!-- Start Header -->
            <?php require("./layout/header.php") ?>
            <!-- End Header -->
            <div id="main-content">
                <?php require("./function/menu.php") ?>
            </div>
            <!-- Start Footer -->
            <?php require("./layout/footer.php") ?>
            <!-- End Footer -->
        </div>
    </div>
    <script src="./assets/static/js/components/dark.js"></script>
    <script src="./assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="./assets/compiled/js/app.js"></script>
    <script src="./assets/static/js/pages/sweetalert2.js"></script>
</body>

</html>