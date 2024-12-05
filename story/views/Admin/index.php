<?php
include '../../database/configdb.php';

// Ambil kata kunci pencarian dari form
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data produk, dengan pencarian berdasarkan nama produk
$sql = "SELECT * FROM produk WHERE nama_produk LIKE ?";

// Persiapkan statement
$stmt = $conn->prepare($sql);
$search_param = "%" . $search . "%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css">
    <link rel="stylesheet" href="../../CSS/style.css">
    <style>
        .product-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .product-item {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
        }
    </style>
</head>
<body>
<?php include '../components/navAdmin.php'; ?>
    <div class="container mt-4">
        <header class="d-flex justify-content-between align-items-center">
            <h1>Products</h1>
            <a href="tambahproduk.php" class="btn btn-primary">+ New Product</a>
        </header>

        <!-- Form Pencarian -->
        <form class="mt-3" method="get" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search for products" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <div class="product-list mt-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <?php 
                            // Menampilkan gambar dari path
                            $imagePath = $row['foto']; // Pastikan kolom foto berisi nama file gambar saja (misal: adatlampung.jpg)

                            if (!empty($imagePath)) {
                                // Menampilkan gambar menggunakan path yang benar
                                echo '<img src="../../images/' . htmlspecialchars($imagePath) . '" alt="Product" class="img-fluid">';
                            } else {
                                // Menampilkan gambar placeholder jika tidak ada gambar
                                echo '<img src="../../images/adatbali.jpg" alt="Produk Tanpa Gambar" class="img-fluid">';
                            }
                            ?>
                            <div class="ms-3">
                                <h5 class="mb-1"><?php echo htmlspecialchars($row['nama_produk'] ?? 'Produk Tanpa Nama'); ?></h5>
                                <p class="mb-0 text-muted">
                                    IDR <?php echo isset($row['harga']) ? number_format($row['harga'], 0, ',', '.') : '0'; ?> / Day
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span class="badge bg-success">Stock</span>
                                <input type="checkbox" class="form-check-input ms-2" checked>
                            </div>
                            <a href="editproduk.php?id=<?php echo htmlspecialchars($row['id_produk']); ?>" class="btn btn-outline-primary me-2">Edit Product</a>
                            <a href="hapusproduk.php?id=<?php echo htmlspecialchars($row['id_produk']); ?>" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Delete Product</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">Tidak ada produk yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>