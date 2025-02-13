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
    $id_customer = $_POST['id_customer'];
    $nama = $_POST['nama']; // Menggunakan 'nama' sesuai input form
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE customer SET nama_customer='$nama', email='$email', telepon='$telepon', alamat='$alamat' WHERE id_customer='$id_customer'";
    if ($conn->query($sql)) {
        header("Location: customer.php"); // Kembali ke halaman customer setelah update
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Ambil data customer berdasarkan ID
if (isset($_GET['id_customer'])) {
    $id_customer = $_GET['id_customer'];
    $sql = "SELECT * FROM customer WHERE id_customer='$id_customer'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
} else {
    echo "ID customer tidak tersedia!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
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

        .container {
            width: 60%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px 0;
        }

        .back-button:hover {
            background-color: #c82333;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Edit Customer</h1>

        <form method="POST" class="form-container">
            <input type="hidden" name="id_customer" value="<?php echo $row['id_customer']; ?>">
            <input type="text" name="nama" value="<?php echo $row['nama_customer']; ?>" placeholder="Nama" required>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Email" required>
            <input type="tel" name="telepon" value="<?php echo $row['telepon']; ?>" placeholder="Telepon" required>
            <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>" placeholder="Alamat" required>
            <button type="submit" name="update">Update Customer</button>
        </form>

        <a href="customer.php" class="back-button">Kembali ke Data Pembeli</a>
    </div>

</body>
</html>
