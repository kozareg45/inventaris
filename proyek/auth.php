<?php
session_start();
include 'db-config.php'; // Koneksi ke database

// Redirect jika sudah login
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}

// Menentukan apakah user ingin login atau register
$action = isset($_GET['action']) && $_GET['action'] == 'register' ? 'register' : 'login';

// Proses LOGIN
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk cek user
    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Cek apakah password cocok tanpa hash
    if ($user && $password == $user['password']) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['Role']; // Simpan role ke session
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}

// Proses REGISTER
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) && ($_POST['role'] == 'admin' || $_POST['role'] == 'user') ? $_POST['role'] : 'user';

    // Cek apakah username sudah dipakai
    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $error = "Username sudah digunakan!";
    } else {
        // Simpan user baru dengan role yang dipilih
        $stmt = $conn->prepare("INSERT INTO pengguna (username, password, Role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Gagal mendaftar!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $action == 'register' ? 'Register' : 'Login' ?> | Website</title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            background-image:url(asphalt.jpg);
        }
        .container {
            width: 350px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
        .switch {
            margin-top: 15px;
        }
        .switch a {
            color: #007bff;
            text-decoration: none;
        }
        .switch a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><?= $action == 'register' ? 'Register' : 'Login' ?></h2>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <?php if ($action == 'register'): ?>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        <?php endif; ?>

        <button type="submit" name="<?= $action ?>" class="btn">
            <?= $action == 'register' ? 'Daftar' : 'Masuk' ?>
        </button>
    </form>

    <p class="switch">
        <?= $action == 'register' ? 'Sudah punya akun? <a href="auth.php">Login</a>' : 'Belum punya akun? <a href="auth.php?action=register">Register</a>' ?>
    </p>
</div>

</body>
</html>

