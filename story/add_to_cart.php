<?php
session_start();

// Memeriksa apakah ada ID produk yang dikirim
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Memastikan keranjang pesanan sudah ada dalam sesi
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Menambahkan produk ke keranjang (menggunakan ID produk sebagai kunci)
    if (!in_array($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $product_id;
    }
    
    // Mengalihkan kembali ke halaman home setelah menambahkan produk
    header("Location: homeuser.php");
    exit();
}
?>
