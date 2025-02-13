<?php
include 'db-config.php';

$sql = "SELECT * FROM paket";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_paket']}</td>
                <td>{$row['nama_paket']}</td>
                <td>{$row['harga']}</td>
                <td>{$row['status']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
}

$conn->close();
?>
