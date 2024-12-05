<?php
session_start();

// Cek apakah user sudah login dan apakah role adalah admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    // Jika bukan admin atau belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog and Recommendations</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css">
    <link rel="stylesheet" href="../../CSS/style.css">
    <!-- <style>
            /* Style for the Blog Section */
    .blog-section {
        padding: 30px 15px;
    }

    .blog-card {
        text-decoration: none;
        color: inherit;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-section {
        background-color: #f5f5f5;
        padding: 30px 0;
        text-align: center;
    }
    .hero-section img {
        max-width: 100%;
        height: auto;
    }

    .blog-card img {
        width: 100%;
        height: 200px; /* Anda dapat sesuaikan tinggi jika perlu */
        object-fit: contain; /* Mengubah dari cover menjadi contain */
        border-radius: 10px 10px 0 0;
        background-color: #f8f9fa; /* Opsional: memberikan latar belakang abu-abu terang jika gambar tidak memenuhi area */
    }


    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .card-body {
        padding: 15px;
    }

    .blog-title {
        font-size: 1rem;
        font-weight: bold;
        margin-top: 10px;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .navbar {
        font-size: 16px;
    }

    .navbar-brand img {
        height: 50px;
    }

    .nav-link.active {
        font-weight: bold;
        color: #007bff !important;
    }
    </style> -->
</head>
<body>
    <!-- Navbar -->
    <?php include '../components/navAdmin.php'; ?>
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../../images/logo.png" alt="Story Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="homeadmin.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Products</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="#" class="btn btn-outline-secondary ms-2"><i class="bi bi-person"></i></i></a>
                        <a href="#" class="btn btn-outline-secondary ms-2"><i class="bi bi-chat-dots"></i></a>
                        <a href="../../images/logout.php" class="btn btn-outline-danger ms-2"><i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> -->
    <div class="hero-section">
        <div class="col-12">
            <img src="../../images/homeadmin.jpg" alt="Traditional Costumes" class="img-fluid rounded shadow" width="1100">
        </div>
    </div>
    <!-- Blog Section -->
    <div class="container blog-section mt-4">
        <h3 class="text-left mb-4">Blog and Recommended Reading</h3>
        <div class="row g-4">
            <!-- Blog Card 1 -->
            <div class="col-md-4">
                <a href="https://www.ecwid.com/blog/how-to-create-an-online-store-using-mobile.html?utm_source=endashboard" class="blog-card d-block">
                    <div class="card border-0 shadow-sm text-center">
                        <img src="../../images/adatlampung.jpg" class="card-img-top" alt="How to Create and Manage an Online Store">
                        <div class="card-body">
                            <h5 class="blog-title">How to Create, Manage, and Grow an Online Store</h5>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Blog Card 2 -->
            <div class="col-md-4">
                <a href="https://www.ecwid.com/blog/how-to-create-an-online-store-using-mobile.html?utm_source=endashboard" class="blog-card d-block">
                    <div class="card border-0 shadow-sm text-center">
                        <img src="../../images/adatsunda.jpg" class="card-img-top" alt="What to Do Before Launching Your Store">
                        <div class="card-body">
                            <h5 class="blog-title">What to Do Before Launching Your E-Commerce Store</h5>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Blog Card 3 -->
            <div class="col-md-4">
                <a href="https://www.shopify.com/blog/15460013-how-to-drive-targeted-traffic-to-your-online-store-video" class="blog-card d-block">
                    <div class="card border-0 shadow-sm text-center">
                        <img src="../../images/adatbali.jpg" class="card-img-top" alt="How to Attract Customers">
                        <div class="card-body">
                            <h5 class="blog-title">How to Attract Customers to Your Online Store</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>