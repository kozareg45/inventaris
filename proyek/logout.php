<?php
session_start();
session_destroy(); // Menghancurkan sesi
header("Location: auth.php"); // Arahkan kembali ke halaman login
exit;
?>
