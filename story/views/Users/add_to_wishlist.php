<?php
session_start();
include '../../database/configdb.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    die("Access denied. Please log in first.");
}

$id_user = $_SESSION['id_user'];

// Mendapatkan id_produk dari URL
if (isset($_GET['id_produk'])) {
    $id_produk = $_GET['id_produk'];

    // Cek apakah produk sudah ada di wishlist
    $check_sql = "SELECT id_produk FROM wishlist WHERE id_user = ? AND id_produk = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $id_user, $id_produk);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Jika sudah ada di wishlist, hapus produk dari wishlist
        $delete_sql = "DELETE FROM wishlist WHERE id_user = ? AND id_produk = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("ii", $id_user, $id_produk);
        $delete_stmt->execute();
    } else {
        // Jika belum ada, tambahkan produk ke wishlist
        $insert_sql = "INSERT INTO wishlist (id_user, id_produk) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $id_user, $id_produk);
        $insert_stmt->execute();
    }
}

// Redirect kembali ke halaman homeuser setelah proses
header("Location: homeuser.php");
exit();
?>
