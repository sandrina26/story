<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php?redirect=homeuser.php");
    exit();
}

// Mengambil username dari session jika ada
$username = isset($_SESSION['username']) ? $_SESSION['username'] : ''; 

include '../../database/configdb.php'; // Koneksi database

$sql = "SELECT * FROM produk";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}

// echo '<pre>';
// print_r($row['foto']);
// echo '</pre>';

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
    <!-- <link rel="stylesheet" href="../../CSS/style.css"> -->
</head>
<body>
    <!-- Nav -->
    <?php include '../components/navUser.php'; ?>
    <!-- Banner Section with Carousel -->
    <div class="container mt-5">
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

        <div class="container mt-5">
        <h2>Our Products</h2>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                    <?php 
                            // Menampilkan gambar dari path yang disimpan di database
                            if (!empty($row['foto'])) {
                                $imagePath = '../../images/' . htmlspecialchars($row['foto']); // Gabungkan dengan folder images
                                echo '<img src="' . $imagePath . '" class="card-img-top" alt="' . htmlspecialchars($row['nama_produk']) . '">';
                            } else {
                                // Jika path gambar kosong, tampilkan placeholder default
                                echo '<img src="../../images/default-placeholder.png" class="card-img-top" alt="Produk Tanpa Gambar">';
                            }
                        ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
                            <p class="card-text">IDR <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                            <form method="POST" action="add_to_cart.php"> 
                                <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">
                                <button type="submit" class="btn btn-primary">+ Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <footer class="bg-dark text-white p-2 mt-4">
        <div class="row">
            <div class="col text-center">
                Created by Story @2024
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
