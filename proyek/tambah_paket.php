<?php
session_start();
include 'db-config.php';

if (!isset($_SESSION['username'])) {
    header("Location: auth.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    
    // Validasi input
    if (empty($nama_paket) || empty($harga) || empty($status)) {
        echo "<script>alert('Semua kolom harus diisi!'); window.location.href='dashboard.php';</script>";
        exit;
    }

    // Query untuk menambahkan paket baru
    $sql = "INSERT INTO paket (nama_paket, harga, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $nama_paket, $harga, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Paket berhasil ditambahkan!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan paket.'); window.location.href='dashboard.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: dashboard.php");
    exit;
}
