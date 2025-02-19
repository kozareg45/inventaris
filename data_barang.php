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
        <div class="card mt-2">
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-data">
                    Tambah Data
                </button>
            </div>
            <div class="card-body">
                <?php 
                if(isset($_GET['pesan'])){
                    if($_GET['pesan']=="simpan"){?>
                        <div class="alert alert-success" role="alert">
                            Data Berhasil Di Simpan
                        </div>
                    <?php } ?>
                    <?php if($_GET['pesan']=="update"){?>
                        <div class="alert alert-success" role="alert">
                            Data Berhasil Di Update
                        </div>
                    <?php } ?>
                    <?php if($_GET['pesan']=="hapus"){?>
                        <div class="alert alert-success" role="alert">
                            Data Berhasil Di Hapus
                        </div>
                    <?php } ?>
                <?php }
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        include '../koneksi.php';
                        $no = 1;
                        $data = mysqli_query($koneksi,"select * from produk");
                        while($d = mysqli_fetch_array($data)){
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $d['NamaProduk']; ?></td>
                                <td>Rp. <?php echo $d['Harga']; ?></td>
                                <td><?php echo $d['Stok']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?php echo $d['ProdukID']; ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?php echo $d['ProdukID']; ?>">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
