<?php
session_start();
include '../../database/configdb.php';

if (isset($_SESSION['id_user']) && isset($_GET['id_produk'])) {
    $id_user = $_SESSION['id_user'];
    $id_produk = $_GET['id_produk'];

    // Hapus produk dari wishlist
    $delete_sql = "DELETE FROM wishlist WHERE id_user = ? AND id_produk = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("ii", $id_user, $id_produk);
    $stmt->execute();

    // Redirect kembali ke halaman wishlist
    header("Location: wishlist.php");
    exit();
} else {
    echo "Invalid request!";
}
?>
