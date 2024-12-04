<?php
// Pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    die("Access denied. Please log in first.");
}

// Koneksi ke database
include '../../database/configdb.php';

// Pastikan parameter `order_id` tersedia
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $id_user = $_SESSION['id_user'];

    // Query untuk menghapus data berdasarkan `order_id` dan `id_user`
    $sql = "DELETE FROM keranjang WHERE id = ? AND id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $id_user);

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, redirect kembali ke halaman My Order
        header("Location: myorder.php?status=success&message=Order deleted successfully");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        header("Location: myorder.php?status=error&message=Failed to delete order");
        exit();
    }
} else {
    // Jika `order_id` tidak disediakan
    header("Location: myorder.php?status=error&message=Invalid request");
    exit();
}
?>
