<?php
$current_page = basename($_SERVER['SCRIPT_NAME']);
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
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'homeuser.php' ? 'active' : ''; ?>" href="/story/views/Users/homeuser.php">Home</a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item"><a class="nav-link" href="wishlist.php">Wishlist</a></li>
                    <li class="nav-item"><a class="nav-link" href="myorder.php">My Order</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php?redirect=wishlist.php">Wishlist</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php?redirect=myorder.php">My Order</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="sale.php">Sale</a></li>
                <li class="nav-item"><a class="nav-link" href="style.php">Style</a></li>
                <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search entire store here...">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <!-- Menampilkan profil dan tombol logout -->
            <a href="profile.php" class="btn btn-outline-secondary ms-2"><i class="bi bi-person"></i> <?= $username ?></a>
            <a href="chat.php" class="btn btn-outline-secondary ms-2"><i class="bi bi-chat-dots"></i></a>
            <a href="../../../story/views/components/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
        </div>
    </div>
</nav>