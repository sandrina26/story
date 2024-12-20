<!-- nav.php -->
<?php
$current_page = basename($_SERVER['SCRIPT_NAME']);
// var_dump($current_page);   
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../../images/logo.png" alt="Story Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Highlight the active page -->
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'homeadmin.php' ? 'active' : ''; ?>" href="/webpro2024-1/story1/story/views/Admin/homeadmin.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'index.php' ? 'active' : ''; ?>" href="/webpro2024-1/story1/story/views/Admin/index.php">Products</a>
                </li>
                <!-- Menambahkan menu untuk melihat produk yang sedang disewa -->
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'rented_products.php' ? 'active' : ''; ?>" href="/webpro2024-1/story1/story/views/Admin/rented_products.php">Rented Products</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <!-- User-related buttons -->
                    <a href="#" class="btn btn-outline-secondary ms-2"><i class="bi bi-person"></i></a>
                    <a href="#" class="btn btn-outline-secondary ms-2"><i class="bi bi-chat-dots"></i></a>
                    <a href="../../../story/views/components/logout.php" class="btn btn-outline-danger ms-2"><i class="bi bi-box-arrow-right"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>