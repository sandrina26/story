<?php
session_start();
include '../../database/configdb.php'; // Koneksi database

// Ambil product_id dari POST
$id_produk = $_POST['id_produk'] ?? null;

// Cek jika user_id ada dalam session
$id_user = $_SESSION['id_user'] ?? null;

if ($id_produk && $id_user) {
    // Query untuk menambahkan ke tabel keranjang
    $sql = "INSERT INTO keranjang (id_user, id_produk, tanggal_sewa) VALUES (?, ?, ?)";
    $tanggal_sewa = date('Y-m-d'); // Ambil tanggal saat ini

    // Persiapkan statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iis", $id_user, $id_produk, $tanggal_sewa);

        if ($stmt->execute()) {
            header("Location: myorder.php"); // Redirect ke halaman my order
            exit();
        } else {
            die("Error: " . $stmt->error); // Menampilkan kesalahan pada eksekusi
        }
    } else {
        die("Prepare failed: " . $conn->error);
    }
}

$conn->close();
?>