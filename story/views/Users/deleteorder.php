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

    // Ambil ID produk dan stok terkait dari order yang akan dihapus
    $sql = "SELECT k.id_produk, p.stok 
            FROM keranjang k 
            JOIN produk p ON k.id_produk = p.id_produk 
            WHERE k.id = ? AND k.id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika produk ditemukan di keranjang
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_produk = $row['id_produk'];
        $stok_sekarang = $row['stok'];

        // Kembalikan stok produk yang telah dihapus dari keranjang
        $stok_baru = $stok_sekarang + 1; // Menambah stok
        $update_stok = "UPDATE produk SET stok = ? WHERE id_produk = ?";
        $stmt_update = $conn->prepare($update_stok);
        $stmt_update->bind_param("ii", $stok_baru, $id_produk);
        $stmt_update->execute();

        // Setelah stok dikembalikan, hapus produk dari keranjang
        $sql_delete = "DELETE FROM keranjang WHERE id = ? AND id_user = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("ii", $order_id, $id_user);

        // Eksekusi penghapusan
        if ($stmt_delete->execute()) {
            // Redirect ke halaman My Order dengan status sukses
            header("Location: myorder.php?status=success&message=Order deleted successfully");
            exit();
        } else {
            // Jika gagal menghapus, tampilkan pesan error
            header("Location: myorder.php?status=error&message=Failed to delete order");
            exit();
        }
    } else {
        // Jika order_id tidak ditemukan
        header("Location: myorder.php?status=error&message=Order not found");
        exit();
    }
} else {
    // Jika `order_id` tidak disediakan dalam request
    header("Location: myorder.php?status=error&message=Invalid request");
    exit();
}
?>
