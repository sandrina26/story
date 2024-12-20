<?php
session_start();
include '../../database/configdb.php'; // Koneksi database

// Ambil data dari POST
$id_produk = $_POST['id_produk'] ?? null;
$tanggal_sewa = $_POST['tanggal_sewa'] ?? null;
$tanggal_kembali = $_POST['tanggal_kembali'] ?? null;
$id_user = $_SESSION['id_user'] ?? null;

// Periksa apakah data yang diperlukan ada
if ($id_produk && $id_user && $tanggal_sewa && $tanggal_kembali) {
    // Validasi tanggal
    if ($tanggal_kembali < $tanggal_sewa) {
        die("Tanggal kembali tidak boleh lebih awal dari tanggal sewa.");
    }

    // Hitung durasi sewa (dalam hari)
    $datetime1 = new DateTime($tanggal_sewa);
    $datetime2 = new DateTime($tanggal_kembali);
    $interval = $datetime1->diff($datetime2);
    $durasi_sewa = $interval->days;

    // Query untuk menambahkan ke tabel keranjang
    $sql = "INSERT INTO keranjang (id_user, id_produk, tanggal_sewa, tanggal_kembali, durasi_sewa) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iissi", $id_user, $id_produk, $tanggal_sewa, $tanggal_kembali, $durasi_sewa);
        if ($stmt->execute()) {
            // Update stok produk, kurangi 1
            $sql_stok = "UPDATE produk SET stok = stok - 1 WHERE id_produk = ?";
            $stmt_stok = $conn->prepare($sql_stok);
            $stmt_stok->bind_param("i", $id_produk);
            $stmt_stok->execute();

            // Redirect ke halaman my order
            header("Location: myorder.php");
            exit();
        } else {
            die("Error: " . $stmt->error); // Menampilkan kesalahan pada eksekusi
        }
    } else {
        die("Prepare failed: " . $conn->error);
    }
} else {
    echo "Data tidak lengkap.";
}

$conn->close();
?>
