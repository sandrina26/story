<?php
// Memulai sesi
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php?redirect=homeuser.php"); // Mengirimkan halaman yang dituju setelah login
    exit();
}
$username = $_SESSION['username'];
$role = $_SESSION['role'];
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

        <!-- Recommendation Section -->
        <div class="col-md-12 text-center">
            <h3 class="mb-4">Recommendation</h3>
            <div class="row justify-content-center">
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <a href="detailproduk.php">
                            <img src="../../images/adatlampung.jpg" class="card-img-top" alt="Women's wedding dress Lampung">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">Women's wedding dress Lampung customs</h5>
                            <p class="card-text">IDR 300.000 / Day</p>
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="product_id" value="1">
                                <button class="btn btn-primary" type="submit">+ Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                            <img src="../../images/adatbali.jpg" class="card-img-top" alt="Couple's wedding dress Balinese">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">Couple's wedding dress Balinese customs</h5>
                            <p class="card-text">IDR 800.000 / Day</p>
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="product_id" value="1">
                                <button class="btn btn-primary" type="submit">+ Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                            <img src="../../images/adatsunda.jpg" class="card-img-top" alt="Women's wedding dress Sundanese">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">Women's wedding dress Sundanese customs</h5>
                            <p class="card-text">IDR 250.000 / Day</p>
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="product_id" value="1">
                                <button class="btn btn-primary" type="submit">+ Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                            <img src="../../images/adatdayakkids.jpg" class="card-img-top" alt="Girls' clothes Dayak">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">Girls' clothes Dayak customs</h5>
                            <p class="card-text">IDR 350.000 / Day</p>
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="product_id" value="1">
                                <button class="btn btn-primary" type="submit">+ Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
