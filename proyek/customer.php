<?php
session_start();
include 'db-config.php'; // Hubungkan ke database

// Mengecek jika user belum login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke login jika belum login
    exit;
}

// Ambil data customer
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembeli</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            color: #343a40;
            text-align: center;
            margin-top: 20px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
            background-color: #007bff;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .button {
            background-color: #007bff;
            color: white;
            padding: 10px 3px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            display: block;
            width: 100%;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .logout {
            display: inline-block;
            margin-top: 20px;
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
        }

        .logout:hover {
            background-color: #c82333;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Data Pembeli</h1>
        <a href="logout.php" class="logout">Logout</a>

        <h2>Daftar Pembeli</h2>
        <table>
            <tr>
                <th>ID Pembeli</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_customer']; ?></td>
                    <td><?php echo $row['nama_customer']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['telepon']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td>
                        <a href="edit_customer.php?id_customer=<?php echo $row['id_customer']; ?>">Edit</a> |
                        <a href="customer.php?hapus=<?php echo $row['id_customer']; ?>" onclick="return confirm('Hapus data ini?');">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="dashboard.php" class="button">Kembali ke Dashboard</a>
    </div>
</body>
</html>
