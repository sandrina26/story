<?php
// Pastikan sesi hanya dimulai sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mendapatkan halaman saat ini
$current_page = basename($_SERVER['SCRIPT_NAME']);

// Periksa apakah username sudah ada di session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../../images/logo.png" alt="Story Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Home link -->
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'homeuser.php' ? 'active' : ''; ?>" href="/webpro2024-1/story1/story/views/Users/homeuser.php" style="<?php echo $current_page === 'homeuser.php' ? 'color: #0a5b5c;' : ''; ?>">Home</a>
                </li>

                <!-- Wishlist and My Order links for logged-in users -->
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'wishlist.php' ? 'active' : ''; ?>" href="/webpro2024-1/story1/story/views/Users/wishlist.php" style="<?php echo $current_page === 'wishlist.php' ? 'color: #0a5b5c;' : ''; ?>">Wishlist</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'myorder.php' ? 'active' : ''; ?>" href="/webpro2024-1/story1/story/views/Users/myorder.php" style="<?php echo $current_page === 'myorder.php' ? 'color: #0a5b5c;' : ''; ?>">My Order</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php?redirect=wishlist.php" style="<?php echo $current_page === 'wishlist.php' ? 'color: #0a5b5c;' : ''; ?>">Wishlist</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php?redirect=myorder.php" style="<?php echo $current_page === 'myorder.php' ? 'color: #0a5b5c;' : ''; ?>">My Order</a></li>
                <?php endif; ?>

                <!-- Sale, Style, Shop links -->
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'sale.php' ? 'active' : ''; ?>" href="sale.php" style="<?php echo $current_page === 'sale.php' ? 'color: #0a5b5c;' : ''; ?>">Sale</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'style.php' ? 'active' : ''; ?>" href="style.php" style="<?php echo $current_page === 'style.php' ? 'color: #0a5b5c;' : ''; ?>">Style</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'shop.php' ? 'active' : ''; ?>" href="shop.php" style="<?php echo $current_page === 'shop.php' ? 'color: #0a5b5c;' : ''; ?>">Shop</a>
                </li>

            </ul>

            <!-- Search form -->
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search entire store here...">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <!-- Profile, Chat, and Logout links -->
            <a href="profile.php" class="btn btn-outline-secondary ms-2"><i class="bi bi-person"></i> <?= htmlspecialchars($username) ?></a>
            <a href="chat.php" class="btn btn-outline-secondary ms-2"><i class="bi bi-chat-dots"></i></a>
            <a href="../../../story/views/components/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
        </div>
    </div>
</nav>
