<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_story";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menambahkan produk baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    
    // Handle gambar upload
    $foto = $_FILES['foto'];
    $foto_name = $foto['name'];
    $foto_tmp = $foto['tmp_name'];
    $foto_size = $foto['size'];
    $foto_error = $foto['error'];
    
    // Tentukan direktori penyimpanan (folder images)
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/story1/story/views/Admin/images/'; // Path ke folder images

    // Cek apakah folder images ada, jika belum buat
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);  // Membuat folder jika belum ada
    }

    $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
    $foto_new_name = uniqid('', true) . '.' . $foto_ext;
    $foto_path = $upload_dir . $foto_new_name;

    // Cek apakah gambar valid
    $valid_extensions = array("jpg", "jpeg", "png", "gif");

    if (in_array($foto_ext, $valid_extensions) && $foto_size < 5000000 && $foto_error === 0) {
        // Pindahkan gambar ke direktori
        if (move_uploaded_file($foto_tmp, $foto_path)) {
            // Simpan data produk ke database
            $sql = "INSERT INTO produk (nama_produk, kategori, harga, deskripsi, stok, foto, username) 
                    VALUES (?, ?, ?, ?, ?, ?, 'admin')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdssi", $nama_produk, $kategori, $harga, $deskripsi, $stok, $foto_new_name);

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
                <input type="text" class="form-control" id="kategori" name="kategori" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
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
