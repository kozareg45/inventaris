<?php
session_start();
include 'db-config.php';

// Mengecek jika user belum login
if (!isset($_SESSION['username'])) {
    header("Location: auth.php");
    exit;
}

// **Fitur Tambah Paket**
if (isset($_POST['tambah'])) {
    $nama_paket = trim($_POST['nama_paket']);
    $harga = intval($_POST['harga']);
    $status = trim($_POST['status']);

    if (!empty($nama_paket) && !empty($harga) && !empty($status)) {
        $sql_tambah = "INSERT INTO paket (nama_paket, harga, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_tambah);
        $stmt->bind_param("sis", $nama_paket, $harga, $status);
        
        if ($stmt->execute()) {
            echo "<script>alert('Paket berhasil ditambahkan!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan paket!');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Semua kolom harus diisi!');</script>";
    }
}

// **Fitur Hapus Paket**
if (isset($_GET['hapus'])) {
    $id_paket = intval($_GET['hapus']); // Pastikan ID berupa angka

    $sql_hapus = "DELETE FROM paket WHERE id_paket = ?";
    $stmt = $conn->prepare($sql_hapus);
    $stmt->bind_param("i", $id_paket);

    if ($stmt->execute()) {
        echo "<script>alert('Paket berhasil dihapus!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus paket!');</script>";
    }
    $stmt->close();
}

// Ambil data paket
$sql = "SELECT * FROM paket";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Koza Database</title>
    <link href="https://fonts.googleapis.com/css2?family=Darumadrop+One&display=swap" rel="stylesheet">
    <script>
        function printTable() {
            window.print(); // Langsung munculin dialog print
        }
    </script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            background-image: url('download (16).jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: linear-gradient(45deg,rgb(0, 0, 0),rgb(2, 123, 253));
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 20px;
            font-weight: bold;
            font-family: 'Darumadrop One', sans-serif;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar-left a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .navbar-left a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .logout {
            background-color: #dc3545;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease-in-out;
        }

        .logout:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .container {
            width: 80%;
            margin: 80px auto 20px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color:rgb(9, 61, 117);
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .btn-edit, .btn-delete {
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease-in-out;
        }

        .btn-edit {
            background-color: #ffc107;
            color: black;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .form-container {
            text-align: center;
            margin-top: 20px;
        }

        .form-container input {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 300px;
        }

        .form-container button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #218838;
        }
        /* CSS Print - Hanya Cetak Tabel */
        @media print {
            body * {
                visibility: hidden; /* Sembunyikan semua elemen */
            }
            #printArea, #printArea * {
                visibility: visible; /* Hanya tampilkan tabel */
            }
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none; /* Sembunyikan tombol print */
            }
        }
    </style>
</head>
<body>

<div class="no-print">
    <h2>Navbar (Tidak akan dicetak)</h2>
    <button onclick="printTable()">🖨️ Print</button>
</div>

    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-left">
            <h1>Koza Database</h1>
            <a href="customer.php">Pembeli</a>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="manage_user.php">Kelola Pengguna</a>
            <?php endif; ?>
            <a href="manage_sales.php">Kelola Sales</a>


        </div>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <h2>Data Paket</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_paket']; ?></td>
                    <td><?php echo $row['nama_paket']; ?></td>
                    <td><?php echo 'Rp.  '. number_format($row['harga'], 0, ',' , '.'); ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <a href="dashboard.php?hapus=<?php echo $row['id_paket']; ?>" class="btn-delete" onclick="return confirm('Hapus data ini?');">Hapus</a>
                        <a href="edit.php?id=<?php echo $row['id_paket']; ?>" class="btn-edit">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Tambah Paket</h2>
        <div class="form-container">
            <form method="post">
                <input type="text" name="nama_paket" placeholder="Nama Paket" required>
                <input type="number" name="harga" placeholder="Harga" required>
                <input type="text" name="status" placeholder="Status" required>
                <button type="submit" name="tambah">Tambah Paket</button>
            </form>
        </div>
    </div>


    <div id="printArea">
    <h2>Data Barang</h2>
    <table>
        <tr>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
        <?php
        include 'db-config.php';
        $query = "SELECT * FROM barang45";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id_paket']}</td>
                    <td>{$row['nama_paket']}</td>
                    <td>Rp" . number_format($row['harga']) . "</td>
                    <td>{$row['status']}</td>
                  </tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
