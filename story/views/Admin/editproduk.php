<?php
include '../../database/configdb.php';

// Cek apakah ada data yang dikirim melalui form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_produk = intval($_POST['id_produk']);
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $foto = $_FILES['foto']['name'];

    // Upload foto jika ada file yang diunggah
    if (!empty($foto)) {
        $target_dir = "../../images/";
        $target_file = $target_dir . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    } else {
        $foto = $_POST['foto_lama'];
    }

    // Query update data
    $sql = "UPDATE produk SET nama_produk = ?, kategori = ?, harga = ?, deskripsi = ?, stok = ?, foto = ? WHERE id_produk = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssi", $nama_produk, $kategori, $harga, $deskripsi, $stok, $foto, $id_produk);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Ambil ID produk dari URL
$id_produk = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_produk <= 0) {
    die("ID produk tidak valid.");
}

// Query untuk mendapatkan data produk
$sql = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    die("Produk tidak ditemukan.");
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Edit Produk</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_produk" value="<?php echo htmlspecialchars($data['id_produk']); ?>">

            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" 
                       value="<?php echo htmlspecialchars($data['nama_produk']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="women" <?php echo ($data['kategori'] == 'women') ? 'selected' : ''; ?>>Women</option>
                    <option value="men" <?php echo ($data['kategori'] == 'men') ? 'selected' : ''; ?>>Men</option>
                    <option value="kids" <?php echo ($data['kategori'] == 'kids') ? 'selected' : ''; ?>>Kids</option>
                    <option value="couple" <?php echo ($data['kategori'] == 'couple') ? 'selected' : ''; ?>>Couple</option>
                    <option value="group" <?php echo ($data['kategori'] == 'group') ? 'selected' : ''; ?>>Group</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" 
                       value="<?php echo htmlspecialchars($data['harga']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" 
                       value="<?php echo htmlspecialchars($data['stok']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto">
                
                <input type="hidden" name="foto_lama" value="<?php echo htmlspecialchars($data['foto']); ?>">

                <?php if (!empty($data['foto'])): ?>
                    <div class="mt-3">
                        <label>Foto Saat Ini:</label><br>
                        <img src="../../images/<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto Produk" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                    </div>
                <?php else: ?>
                    <p class="mt-2 text-muted">Belum ada foto yang diunggah.</p>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
