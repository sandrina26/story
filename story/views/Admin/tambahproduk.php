<?php
include '../../database/configdb.php';
session_start(); // Pastikan session dimulai

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];  // Misalnya, id_user disimpan di session saat login

// Menambahkan produk baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    
    // Validasi harga
    if ($harga < 0) {
        echo "<script>alert('Harga tidak boleh negatif.');</script>";
        exit(); // Hentikan proses jika harga negatif
    }
    
    // Handle gambar upload
    $foto = $_FILES['foto'];
    $foto_name = $_FILES['foto']['name'];  // Ambil nama asli file
    $foto_tmp = $_FILES['foto']['tmp_name'];  // Path sementara file
    $foto_size = $_FILES['foto']['size'];  // Ukuran file
    $foto_error = $_FILES['foto']['error'];  // Error upload file
    
    // Tentukan folder upload
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/story1/story/views/Admin/images/'; // Path ke folder images
    $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));  // Ambil ekstensi file (misal: jpg, png)
    
    // Cek ekstensi file apakah valid
    $valid_extensions = array("jpg", "jpeg", "png", "gif");

    if (in_array($foto_ext, $valid_extensions) && $foto_size < 5000000 && $foto_error === 0) {
        // Tentukan path file baru
        $foto_path = $upload_dir . $foto_name;  // Menyimpan dengan nama asli file

        // Cek apakah file sudah ada, jika ada beri nama baru dengan menambahkan angka di belakang
        $i = 1;
        while (file_exists($foto_path)) {
            $foto_name = pathinfo($foto_name, PATHINFO_FILENAME) . "($i)." . $foto_ext;
            $foto_path = $upload_dir . $foto_name;
            $i++;
        }

        // Pindahkan file gambar ke folder upload
        if (move_uploaded_file($foto_tmp, $foto_path)) {
            // Simpan nama file gambar ke database
            $sql = "INSERT INTO produk (nama_produk, kategori, harga, deskripsi, stok, foto, id_user) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdsssi", $nama_produk, $kategori, $harga, $deskripsi, $stok, $foto_name, $id_user);    

            if ($stmt->execute()) {
                echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan produk: " . $stmt->error . "');</script>";
            }
        } else {
            echo "<script>alert('Gagal mengunggah foto.');</script>";
        }
    } else {
        echo "<script>alert('Foto tidak valid atau terlalu besar.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Tambah Produk Baru</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="women">Women</option>
                    <option value="men">Men</option>
                    <option value="kids">Kids</option>
                    <option value="couple">Couple</option>
                    <option value="group">Group</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" min=0 required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Produk</label>
                <input type="file" class="form-control" id="foto" name="foto" required>
            </div>
            <div class="mt-4">
                <a href="index.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
