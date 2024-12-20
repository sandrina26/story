<?php
session_start();
include '../../database/configdb.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    die("Access denied. Please log in first.");
}

$id_user = $_SESSION['id_user'];

// Ambil produk yang tersedia
$sql = "SELECT * FROM produk";
$result = $conn->query($sql);

// Cek produk yang sudah ada di wishlist
$wishlist_sql = "SELECT id_produk FROM wishlist WHERE id_user = ?";
$stmt = $conn->prepare($wishlist_sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$wishlist_result = $stmt->get_result();
$wishlist = [];
while ($row = $wishlist_result->fetch_assoc()) {
    $wishlist[] = $row['id_produk']; // Menyimpan id_produk yang ada di wishlist
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Story Tradition Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css?ver=1.0">
</head>
<body>
    <!-- Nav -->
    <?php include '../components/navUser.php'; ?>
    
    <!-- Banner Section with Carousel -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../../images/baner.jpg" class="d-block w-100" alt="Traditional Costumes">
                        </div>
                        <div class="carousel-item">
                            <img src="../../images/baner.jpg" class="d-block w-100" alt="Wedding Dresses">
                        </div>
                        <div class="carousel-item">
                            <img src="../../images/baner.jpg" class="d-block w-100" alt="Cultural Clothing">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Category Section Above Recommendation -->
        <div class="row mt-4">
            <div class="col-md-12 mb-4">
                <div class="btn-group w-100" role="group" aria-label="Category Buttons">
                    <button class="btn btn-outline-secondary w-20 mb-2">
                        <img src="../../images/grup.png" alt="Group Category" class="category-icon">
                        Group
                    </button>
                    <button class="btn btn-outline-secondary w-20 mb-2">
                        <img src="../../images/kids.png" alt="Kids Category" class="category-icon">
                        Kids
                    </button>
                    <button class="btn btn-outline-secondary w-20 mb-2">
                        <img src="../../images/couple.png" alt="Couple Category" class="category-icon">
                        Couple
                    </button>
                    <button class="btn btn-outline-secondary w-20 mb-2">
                        <img src="../../images/women.png" alt="Women Category" class="category-icon">
                        Women
                    </button>
                    <button class="btn btn-outline-secondary w-20 mb-2">
                        <img src="../../images/men.png" alt="Men Category" class="category-icon">
                        Men
                    </button>
                </div>
            </div>
        </div>

<!-- Products Section -->
<div class="container">
    <h2>Our Products</h2>
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
                            <a href="add_to_wishlist.php?id_produk=<?php echo $row['id_produk']; ?>">
                                <i class="bi bi-heart<?php echo in_array($row['id_produk'], $wishlist) ? '-fill' : ''; ?>" 
                                   style="font-size: 1.5rem; color: <?php echo in_array($row['id_produk'], $wishlist) ? 'red' : 'gray'; ?>;">
                                </i>
                            </a>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
                            <p class="card-text">IDR <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                            <p>Stok Tersedia: <?php echo $row['stok']; ?> item</p>
                            <button type="button" class="btn" style="background-color: #0a5b5c; color: white;" data-bs-toggle="modal" data-bs-target="#dateModal<?php echo $row['id_produk']; ?>">
                             Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Modal untuk memilih tanggal mulai dan tanggal akhir -->
                    <div class="modal fade" id="dateModal<?php echo $row['id_produk']; ?>" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="dateModalLabel">Pilih Tanggal Penyewaan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="add_to_cart.php" method="POST">
                                        <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">

                                        <div class="mb-3">
                                            <label for="tanggal_sewa<?php echo $row['id_produk']; ?>" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tanggal_sewa<?php echo $row['id_produk']; ?>" name="tanggal_sewa" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_kembali<?php echo $row['id_produk']; ?>" class="form-label">Tanggal Akhir</label>
                                            <input type="date" class="form-control" id="tanggal_kembali<?php echo $row['id_produk']; ?>" name="tanggal_kembali" required>
                                        </div>

                                        <button type="submit" class="btn" style="background-color: #0a5b5c; color: white;">Add to Orders</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada produk yang tersedia.</p>
        <?php endif; ?>
    </div>
</div>


<!-- Bootstrap JS (untuk modal dan navbar) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
