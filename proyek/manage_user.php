<?php
session_start();
include 'db-config.php'; // Koneksi database

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

// Hapus pengguna
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Cek apakah ID yang akan dihapus ada di database
    $check = $conn->prepare("SELECT * FROM pengguna WHERE id_pengguna = ?");
    if (!$check) {
        die("Query gagal: " . $conn->error);
    }
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        // Redirect jika ID tidak ditemukan
        header("Location: manage_user.php?error=notfound");
        exit;
    }
    $check->close();

    // Lanjutkan proses penghapusan jika ID ditemukan
    $stmt = $conn->prepare("DELETE FROM pengguna WHERE id_pengguna = ?");
    if (!$stmt) {
        die("Query gagal: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Redirect jika berhasil dihapus
        header("Location: manage_user.php?status=deleted");
        exit;
    } else {
        die("Error saat menghapus pengguna.");
    }
}





// Update role pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_role']) && $_POST['update_role'] == "1") {
    $id = $_POST['id'];
    $role = $_POST['role'];

    if ($role == 'user') {
        $role = 'pengguna';
    }

    $stmt = $conn->prepare("UPDATE pengguna SET Role = ? WHERE id_pengguna = ?");
    $stmt->bind_param("si", $role, $id);
    $stmt->execute();
    header("Location: manage_user.php");
    exit;
}

// Tambah pengguna baru
$add_user_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $new_username = trim($_POST['new_username']);
    $new_password = trim($_POST['new_password']);
    $new_role = $_POST['new_role'];
    $new_role = isset($_POST['new_role']) ? $_POST['new_role'] : 'pengguna';

    if (!empty($new_username) && !empty($new_password)) {
        // Menyimpan password langsung tanpa hashing
        $stmt = $conn->prepare("INSERT INTO pengguna (username, password, Role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $new_username, $new_password, $new_role);
        
        if ($stmt->execute()) {
            $add_user_message = "Pengguna berhasil ditambahkan!";
        } else {
            $add_user_message = "Gagal menambahkan pengguna.";
        }
    } else {
        $add_user_message = "Username dan password tidak boleh kosong!";
    }
}


// Ambil daftar pengguna
$result = $conn->query("SELECT * FROM pengguna");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Admin</title>
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
        select, input[type="text"], input[type="password"] {
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

        .logout-btn {
    background-color: red; /* Warna merah */
    color: white;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    border-radius: 5px;
}
.logout-btn:hover {
    background-color: darkred;
}


        .navbar .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
}

         .navbar .logout-btn:hover {
            background: #c82333;
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
        <a href="dashboard.php" class="dashboard-">Dashboard</a>
        <a href="logout.php" class="logout-btn">Logout</a>w
    </div>
</div>

<!-- Container -->
<div class="container">
    <h2>Kelola Pengguna</h2>

    <!-- Container -->
<div class="container">
    <h2>Kelola Pengguna</h2>

    <!-- Notifikasi -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'notfound'): ?>
    <p style="color: red; font-weight: bold;">❌ ID pengguna tidak ditemukan.</p>
<?php endif; ?>

<?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
    <p style="color: green; font-weight: bold;">✅ Pengguna berhasil dihapus.</p>
<?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_pengguna'] ?></td>
                <td><?= $row['username'] ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['id_pengguna'] ?>">
                        <select name="role" onchange="this.form.submit()">
                            <option value="user" <?= $row['Role'] == 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $row['Role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                        <input type="hidden" name="update_role" value="1">
                    </form>
                </td>
                <td>
                    <a href="?delete=<?= $row['id_pengguna'] ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Form Tambah Pengguna -->
    <h2>Tambah Pengguna</h2>
    <form method="POST">
        <input type="text" name="new_username" placeholder="Username" required>
        <input type="password" name="new_password" placeholder="Password" required>
        <select name="new_role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="add_user" class="btn btn-add">Tambah Pengguna</button>
    </form>

    <div class="message"><?= $add_user_message; ?></div>
</div>

</body>
</html>
