<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }

        h2 {
            color: #343a40;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
        }

        table th {
            background-color: #007BFF;
            color: white;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e9ecef;
            transition: 0.3s;
        }

        table td {
            border: 1px solid #dee2e6;
        }

        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Mengecek jika user belum login
    if (!isset($_SESSION['username'])) {
        header("Location: login.php"); // Arahkan ke login jika belum login
        exit;
    }

    include 'db-config.php'; // Hubungkan ke file konfigurasi database
    $sql = "SELECT * FROM paket";
    $result = $conn->query($sql);
    ?>

    <div class="container">
        <h2>Data paket</h2>

        <!-- Menampilkan tabel data dari barang45 -->
        <table>
            <tr>
                <th>ID Paket</th>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
            <?php
            // Menampilkan data barang45 dalam tabel
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_paket']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_paket']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['harga']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='no-data'>Tidak ada data barang.</td></tr>";
            }
            ?>
        </table>

        <a href="dashboard.php" class="btn">Kembali ke Dashboard</a>
    </div>

</body>

</html>
