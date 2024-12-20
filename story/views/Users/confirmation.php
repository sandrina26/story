<?php
// Memulai session
session_start();

// Pastikan id_user ada dalam sesi
$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    die("User ID is not set in session.");
}

// Koneksi database
include '../../database/configdb.php';

// Mendapatkan parameter id_order dan status dari URL
$id_order = $_GET['id_order'] ?? null;
$status = $_GET['status'] ?? null;

if (!$id_order || !$status) {
    die("Invalid request. Missing order or status.");
}

// Proses update status pesanan menjadi "Packed" jika status pembayaran adalah "Lunas"
if ($status === 'Lunas') {
    // Update status pesanan menjadi 'Packed'
    $sql_update = "UPDATE pesanan SET status = 'Packed' WHERE id_order = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('i', $id_order);
    $stmt_update->execute();

    // Cek apakah pembaruan berhasil
    if ($stmt_update->affected_rows > 0) {
        $update_message = "Pesanan Anda telah diproses dan statusnya kini 'Packed'.";
    } else {
        $update_message = "Terjadi kesalahan dalam memperbarui status pesanan.";
    }
} else {
    $update_message = "Pembayaran gagal atau belum dikonfirmasi.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - Story</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css?ver=1.0">
</head>
<body>

    <div class="container my-4">
        <h3>Konfirmasi Pembayaran</h3>

        <?php if ($status === 'Lunas'): ?>
            <div class="alert alert-success">
                Pembayaran Anda telah dikonfirmasi dan pesanan Anda sedang diproses. Status pesanan: <strong>Packed</strong>.
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                Pembayaran gagal atau belum dikonfirmasi.
            </div>
        <?php endif; ?>

        <a href="packed.php" class="btn btn-primary" style="background-color: #0a5b5c; color: white; border: none; outline: none;">Kembali ke Pesanan</a>
    </div>

</body>
</html>
