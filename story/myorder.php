<?php
// Mulai sesi
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Mulai sesi jika belum dimulai
}

// Pastikan id_user ada dalam sesi
$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    die("User ID is not set in session.");
}

// Koneksi database
include '../../database/configdb.php';

// Ambil data pesanan
$sql = "SELECT k.id AS id_order, p.nama_produk, p.harga, k.tanggal_sewa, k.tanggal_kembali, k.durasi_sewa, p.foto 
        FROM keranjang k 
        JOIN produk p ON k.id_produk = p.id_produk 
        WHERE k.id_user = ?";
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
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css?ver=1.0">
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

        .card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .btn-group form {
            margin-right: 10px;
        }

        .select-all-container {
            margin-bottom: 10px;
        }

        .modal-body {
            font-size: 0.9rem;
        }

        .badge {
            font-size: 0.8rem;
            border-radius: 0.3rem;
        }
    </style>
</head>
<body>
    <?php include '../components/navUser.php'; ?>

    <div class="container my-4">
        <div class="select-all-container">
            <input type="checkbox" id="select-all"> <strong>Select All</strong>
        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">My Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Packed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sent</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Canceled</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Return</a>
            </li>
        </ul>

        <h3 class="my-4">My Orders</h3>

        <div class="product-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-item d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <?php 
                        // Menampilkan gambar produk
                        $imagePath = $row['foto'];
                        if (!empty($imagePath)) {
                            echo '<img src="../../images/' . htmlspecialchars($imagePath) . '" alt="Product" class="img-fluid">';
                        } else {
                            echo '<img src="../../images/adatbali.jpg" alt="Produk Tanpa Gambar" class="img-fluid">';
                        }
                        ?>
                        <div class="ms-3">
                            <h5 class="mb-1"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
                            <p class="mb-0 text-muted">
                                Harga: IDR <?php echo number_format($row['harga'], 0, ',', '.'); ?> / Hari
                            </p>
                            <p class="mb-0 text-muted">Tanggal Sewa: <?php echo $row['tanggal_sewa']; ?></p>
                            <p class="mb-0 text-muted">
                                Tanggal Kembali: <?php echo isset($row['tanggal_kembali']) ? htmlspecialchars($row['tanggal_kembali']) : '-'; ?>
                            </p>
                            <p class="mb-0 text-muted">
                                Durasi Sewa: <?php 
                                    $durasi_sewa = isset($row['durasi_sewa']) && $row['durasi_sewa'] > 0 
                                        ? htmlspecialchars($row['durasi_sewa']) . ' Hari' 
                                        : 'Belum ditentukan';
                                    echo $durasi_sewa;
                                ?>
                            </p>
                        </div>
                    </div>

                    <div class="btn-group">
                        <form method="GET" action="editorder.php" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id_order']); ?>">
                            <button type="submit" class="btn btn-secondary">Edit</button>
                        </form>
                        <form method="POST" action="deleteorder.php" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id_order']); ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

                <!-- Rincian Pembayaran dan Checkout -->
                <div class="d-flex justify-content-between align-items-center">
                    <?php 
                        $total_harga = $row['harga'] * $row['durasi_sewa']; // Harga x durasi sewa
                    ?>
                    <div>
                        <h5>Total Harga: IDR <?php echo number_format($total_harga, 0, ',', '.'); ?></h5>
                    </div>

                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal<?php echo $row['id_order']; ?>">Checkout</button>
                    </div>
                </div>

                <!-- Modal Checkout -->
                <div class="modal fade" id="checkoutModal<?php echo $row['id_order']; ?>" tabindex="-1" aria-labelledby="checkoutModalLabel<?php echo $row['id_order']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="checkoutModalLabel<?php echo $row['id_order']; ?>">Checkout Summary</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="checkout.php">
                                    <p>Harga Produk: IDR <?php echo number_format($total_harga, 0, ',', '.'); ?></p>
                                    <p>Durasi Sewa: <?php echo $row['durasi_sewa']; ?> Hari</p>
                                    <div class="mb-3">
                                        <label for="delivery" class="form-label">Pilih Pengiriman:</label>
                                        <select id="delivery" name="delivery" class="form-select">
                                            <option value="instant">Pengiriman Instan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="payment" class="form-label">Metode Pembayaran:</label>
                                        <select id="payment" name="payment" class="form-select">
                                            <option value="virtual_account">Virtual Account</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Confirm Checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>