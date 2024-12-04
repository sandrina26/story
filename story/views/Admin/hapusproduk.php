<?php
include '../../database/configdb.php';

// Ambil ID produk dari URL
$id_produk = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_produk <= 0) {
    die("ID produk tidak valid.");
}

// Query untuk mendapatkan data produk yang akan dihapus
$sql = "SELECT foto FROM produk WHERE id_produk = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    die("Produk tidak ditemukan.");
}

$data = $result->fetch_assoc();
$foto_produk = $data['foto'];

// Jika produk memiliki foto, hapus foto tersebut dari server
if (!empty($foto_produk)) {
    $foto_path = "../../images/" . $foto_produk;
    if (file_exists($foto_path)) {
        unlink($foto_path); // Menghapus foto dari server
    }
}

// Query untuk menghapus produk dari database
$sql_delete = "DELETE FROM produk WHERE id_produk = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id_produk);

if ($stmt_delete->execute()) {
    // Redirect ke halaman utama setelah penghapusan
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $stmt_delete->error;
}

$conn->close();
?>
