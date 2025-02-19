<?php
include "header.php";
?>

<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar-wrapper" class="border-right" style="width: 250px; min-height: 100vh; padding: 15px; background: #343a40;">
        <h4 class="text-white text-center">Admin Panel</h4>
        <ul class="list-group">
            <li class="list-group-item bg-transparent border-0"><a href="index.php" class="text-white text-decoration-none">Dashboard</a></li>
            <li class="list-group-item bg-transparent border-0"><a href="data_pengguna.php" class="text-white text-decoration-none">Data Pengguna</a></li>
            <li class="list-group-item bg-transparent border-0"><a href="data_barang.php" class="text-white text-decoration-none">Data Barang</a></li>
            <li class="list-group-item bg-transparent border-0"><a href="pembelian.php" class="text-white text-decoration-none">Data Pembelian</a></li>
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
                            <th>Nama Petugas</th>
                            <th>Username</th>
                            <th>Akses Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        include '../koneksi.php';
                        $no = 1;
                        $data = mysqli_query($koneksi,"select * from petugas");
                        while($d = mysqli_fetch_array($data)){
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $d['nama_petugas']; ?></td>
                                <td><?php echo $d['username']; ?></td>
                                <td>
                                    <?php 
                                    if ($d['level'] == '1') { ?>
                                        Administrator
                                    <?php } else { ?>
                                        Petugas
                                    <?php } ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?php echo $d['id_petugas']; ?>">
                                        Edit
                                    </button>
                                    <?php 
                                    if ($d['level'] == $_SESSION['level']) { ?>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?php echo $d['id_petugas']; ?>">
                                            Hapus
                                        </button>
                                    <?php } ?>
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
