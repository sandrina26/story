<?php
// Pastikan session aktif
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    die("Access denied. Please log in first.");
}

// Koneksi ke database
include '../../database/configdb.php';

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];

// Ambil produk yang ada dalam wishlist
$sql = "SELECT p.id_produk, p.nama_produk, p.harga, p.stok, p.foto 
        FROM wishlist w
        JOIN produk p ON w.id_produk = p.id_produk
        WHERE w.id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css?ver=1.0">
</head>
<body>
    <!-- Nav -->
    <?php include '../components/navUser.php'; ?>
    

<!-- Wishlist Section -->
<div class="container mt-5">
    <h2>My Wishlist</h2>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-3 mb-4">
                    <div class="card position-relative">
                        <!-- Menampilkan gambar produk -->
                        <?php 
                            if (!empty($row['foto'])) {
                                $imagePath = '../../images/' . htmlspecialchars($row['foto']); 
                                echo '<img src="' . $imagePath . '" class="card-img-top" alt="' . htmlspecialchars($row['nama_produk']) . '">';
                            } else {
                                echo '<img src="../../images/default-placeholder.png" class="card-img-top" alt="Produk Tanpa Gambar">';
                            }
                        ?>

                        <!-- Ikon Love untuk Wishlist -->
                        <div class="position-absolute" style="top: 10px; right: 10px;">
                            <!-- Ikon Love merah untuk menghapus produk dari wishlist -->
                            <a href="remove_from_wishlist.php?id_produk=<?php echo $row['id_produk']; ?>">
                                <i class="bi bi-heart-fill" style="font-size: 1.5rem; color: red;"></i>
                            </a>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
                            <p class="card-text">IDR <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                            <p>Stok Tersedia: <?php echo $row['stok']; ?> item</p>
                            <a href="add_to_cart.php?id_produk=<?php echo $row['id_produk']; ?>" class="btn btn-primary" style="background-color: #0a5b5c; color: white; border: none; outline: none;">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada produk di wishlist.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>