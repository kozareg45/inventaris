<?php
session_start();
include 'db-config.php'; // Koneksi database

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

// Hapus sales
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    $check = $conn->prepare("SELECT * FROM sales WHERE Id_sales = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        header("Location: manage_sales.php?error=notfound");
        exit;
    }
    $check->close();

    $stmt = $conn->prepare("DELETE FROM sales WHERE Id_sales = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: manage_sales.php?status=deleted");
        exit;
    } else {
        die("Error saat menghapus sales.");
    }
}

// Tambah sales baru
$add_sales_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_sales'])) {
    $nama_sales = trim($_POST['nama_sales']);
    $tanggal_bergabung = $_POST['tanggal_bergabung'];

    if (!empty($nama_sales) && !empty($tanggal_bergabung)) {
        $stmt = $conn->prepare("INSERT INTO sales (nama_sales, tanggal_bergabung) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama_sales, $tanggal_bergabung);
        
        if ($stmt->execute()) {
            $add_sales_message = "Sales berhasil ditambahkan!";
        } else {
            $add_sales_message = "Gagal menambahkan sales.";
        }
    } else {
        $add_sales_message = "Semua kolom harus diisi!";
    }
}

// Ambil daftar sales
$result = $conn->query("SELECT * FROM sales");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sales | Admin</title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #eef2f7;
            background-image: url('download (16).jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
        .navbar {
            background: linear-gradient(45deg, rgb(0, 0, 0), rgb(2, 123, 253));
            padding: 15px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-right: 15px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .container {
            width: 90%;
            max-width: 800px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 50px auto;
        }
        h2 {
            color: #343a40;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        input[type="text"], input[type="date"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }
        .btn {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            margin-top: 10px;
        }
        .btn-delete {
            background: #dc3545;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        .btn-add {
            background: #28a745;
            padding: 10px 15px;
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }
        .btn-add:hover {
            background: #218838;
        }
        .message {
            margin-top: 10px;
            font-weight: bold;
            color: green;
        }
        @media screen and (max-width: 600px) {
            table {
                font-size: 12px;
            }
            th, td {
                padding: 8px;
            }
            .btn {
                font-size: 12px;
                padding: 5px 8px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div><strong>Admin Panel</strong></div>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_user.php">Kelola Pengguna</a>
        <a href="manage_sales.php">Kelola Sales</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<!-- Container -->
<div class="container">
    <h2>Kelola Sales</h2>

    <!-- Notifikasi -->
    <?php if (isset($_GET['error']) && $_GET['error'] == 'notfound'): ?>
        <p style="color: red; font-weight: bold;">❌ ID sales tidak ditemukan.</p>
    <?php endif; ?>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
        <p style="color: green; font-weight: bold;">✅ Sales berhasil dihapus.</p>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama Sales</th>
            <th>Tanggal Bergabung</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_sales'] ?></td>
                <td><?= $row['nama_sales'] ?></td>
                <td><?= $row['tanggal_bergabung'] ?></td>
                <td>
                    <a href="?delete=<?= $row['id_sales'] ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Form Tambah Sales -->
    <h2>Tambah Sales</h2>
    <form method="POST">
        <input type="text" name="nama_sales" placeholder="Nama Sales" required>
        <input type="date" name="tanggal_bergabung" required>
        <button type="submit" name="add_sales" class="btn btn-add">Tambah Sales</button>
    </form>

    <div class="message"><?= $add_sales_message; ?></div>
</div>

</body>
</html>
