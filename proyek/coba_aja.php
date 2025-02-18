<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>

    <!-- Panggil Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Dashboard Kasir</h2>
        <div class="row">
            <!-- Card Produk -->
            <div class="col-md-4">
                <div class="card shadow-sm" onclick="location.href='produk.php';">
                    <div class="card-body text-center">
                        <h5 class="card-title">📦 Produk</h5>
                        <p class="card-text">Kelola daftar produk.</p>
                    </div>
                </div>
            </div>

            <!-- Card Transaksi -->
            <div class="col-md-4">
                <div class="card shadow-sm" onclick="location.href='transaksi.php';">
                    <div class="card-body text-center">
                        <h5 class="card-title">💰 Transaksi</h5>
                        <p class="card-text">Proses pembelian dan pembayaran.</p>
                    </div>
                </div>
            </div>

            <!-- Card Riwayat -->
            <div class="col-md-4">
                <div class="card shadow-sm" onclick="location.href='riwayat.php';">
                    <div class="card-body text-center">
                        <h5 class="card-title">📜 Riwayat</h5>
                        <p class="card-text">Lihat riwayat transaksi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panggil Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
