<?php
session_start();
include 'db-config.php'; // Hubungkan ke database

// Mengecek jika user belum login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke login jika belum login
    exit;
}

// Menangani proses update data
if (isset($_POST['update'])) {
    $id_paket = $_POST['id_paket']; // ID paket yang akan diupdate
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $sql = "UPDATE paket SET nama_paket='$nama_paket', harga='$harga', status='$status' WHERE id_paket='$id_paket'";
    if ($conn->query($sql)) {
        header("Location: dashboard.php"); // Kembali ke dashboard setelah update
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Ambil data paket berdasarkan ID
if (isset($_GET['id'])) {
    $id_paket = $_GET['id'];
    $sql = "SELECT * FROM paket WHERE id_paket='$id_paket'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
} else {
    echo "ID paket tidak tersedia!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paket</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .form-container input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            background-color:rgb(12, 190, 196);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color:rgb(17, 150, 184);
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Edit Paket</h1>
        <form method="post" class="form-container">
            <input type="hidden" name="id_paket" value="<?php echo $row['id_paket']; ?>">
            <input type="text" name="nama_paket" value="<?php echo $row['nama_paket']; ?>" placeholder="Nama Paket" required>
            <input type="number" name="harga" value="<?php echo $row['harga'], 0, ',' , '.'; ?>" placeholder="Harga" required>
            <input type="text" name="status" value="<?php echo $row['status']; ?>" placeholder="Status" required>
            <button type="submit" name="update">Update Paket</button>
        </form>
    </div>

</body>
</html>
