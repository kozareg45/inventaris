<?php
include "header.php";
?>

<style>
    #sidebar-wrapper {
        width: 250px;
        min-height: 100vh;
        padding: 15px;
        background: #343a40;
    }
    #sidebar-wrapper h4 {
        color: #fff;
        text-align: center;
    }
    .list-group-item {
        background: transparent;
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }
    .list-group-item:hover {
        background: #495057;
        padding-left: 10px;
    }
    .list-group-item a {
        color: #fff;
        text-decoration: none;
        display: block;
    }
    .list-group-item a:hover {
        color: #f8f9fa;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease-in-out;
        position: relative;
        background: linear-gradient(135deg, #ff9a9e, #fad0c4);
    }
    .card:hover {
        transform: scale(1.05);
    }
    .dashboard-title {
        font-size: 24px;
        font-weight: bold;
        color: #343a40;
        text-align: center;
        margin-bottom: 20px;
    }
    .row {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 20px;
    }
</style>

<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar-wrapper" class="border-right">
        <h4>Admin Panel</h4>
        <ul class="list-group">
            <li class="list-group-item"><a href="index.php">Dashboard</a></li>
            <li class="list-group-item"><a href="data_barang.php">Data Barang</a></li>
            <li class="list-group-item"><a href="pembelian.php">Data Pembelian</a></li>
            <li class="list-group-item"><a href="data_pengguna.php">Data Pengguna</a></li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="container-fluid p-4" style="flex-grow: 1;">
        <div class="dashboard-title">Dashboard Administrator</div>
        <div class="row">
            <div class="col-sm-4">
                <div class="card text-center p-3">
                    <div class="card-body">
                        <h5 class="card-title">Data Barang</h5>
                        <?php
                        include '../koneksi.php';
                        $data_produk = mysqli_query($koneksi, "SELECT * FROM produk");
                        $jumlah_produk = mysqli_num_rows($data_produk);
                        ?>
                        <h3><?php echo $jumlah_produk; ?></h3>
                        <a href="data_barang.php" class="btn btn-light btn-sm">Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center p-3">
                    <div class="card-body">
                        <h5 class="card-title">Data Pembelian</h5>
                        <?php
                        $data_penjualan = mysqli_query($koneksi, "SELECT * FROM penjualan");
                        $jumlah_penjualan = mysqli_num_rows($data_penjualan);
                        ?>
                        <h3><?php echo $jumlah_penjualan; ?></h3>
                        <a href="pembelian.php" class="btn btn-light btn-sm">Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center p-3">
                    <div class="card-body">
                        <h5 class="card-title">Data Pengguna</h5>
                        <?php
                        $data_petugas = mysqli_query($koneksi, "SELECT * FROM petugas");
                        $jumlah_petugas = mysqli_num_rows($data_petugas);
                        ?>
                        <h3><?php echo $jumlah_petugas; ?></h3>
                        <a href="data_pengguna.php" class="btn btn-light btn-sm">Detail</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body text-center">
                <p class="mb-0">Selamat datang di halaman administrator, silakan akses fitur yang tersedia.</p>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
