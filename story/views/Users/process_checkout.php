<?php
// Memastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memulai sesi jika belum dimulai
}

// Pastikan id_user ada dalam sesi
$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    die("User ID is not set in session.");
}

// Koneksi database
include '../../database/configdb.php';

// Ambil data dari form
$order_id = $_POST['order_id'] ?? 0;
$deposit = $_POST['deposit'] ?? 0;
$pengiriman = $_POST['pengiriman'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';

// Validasi data
if ($order_id == 0 || empty($deposit) || empty($pengiriman) || empty($payment_method)) {
    die("Data checkout tidak lengkap.");
}

// Update status checkout di tabel pesanan atau tabel pembayaran sesuai kebutuhan
$sql = "UPDATE pesanan 
        SET status_pembayaran = 'Diterima', metode_pembayaran = ?, deposit = ?, pengiriman = ? 
        WHERE id = ? AND id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisii", $payment_method, $deposit, $pengiriman, $order_id, $id_user);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Checkout berhasil diproses.";
} else {
    die("Gagal memproses checkout.");
}
?>
