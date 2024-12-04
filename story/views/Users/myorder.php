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
            display: flex;
            align-items: center;
        }

        .product-item input[type="checkbox"] {
            margin-right: 15px; /* Menambahkan jarak antara checkbox dan gambar */
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
            margin-left: 10px; /* Memberikan jarak ke kiri tombol */
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

        .select-all-container input {
            margin-right: 10px;
        }

        /* Style untuk tombol checkout dan edit/delete */
        .checkout-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .total-price-container {
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-group form {
            margin-left: 0; /* Menghilangkan margin kiri untuk tombol edit dan delete */
        }

        /* Penataan tombol edit dan delete agar sejajar dengan checkout */
        .product-item .action-buttons {
            margin-left: auto; /* Memastikan tombol berada di sebelah kanan */
        }

        .checkout-container .action-buttons {
            margin-left: 20px; /* Memberikan jarak antara total harga dan tombol */
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
            <?php $total_harga_selected = 0; // Variabel untuk total harga produk yang dipilih ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-item mb-3">
                    <!-- Checkbox ditempatkan sebelum gambar -->
                    <input type="checkbox" class="order-checkbox" data-price="<?php echo $row['harga']; ?>" data-duration="<?php echo $row['durasi_sewa']; ?>" data-order-id="<?php echo $row['id_order']; ?>">

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

                    <div class="action-buttons">
                        <form method="GET" action="editorder.php">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id_order']); ?>">
                            <button type="submit" class="btn btn-secondary">Edit</button>
                        </form>
                        <form method="POST" action="deleteorder.php">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id_order']); ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

                <?php 
                    // Menghitung harga total dari produk yang dipilih
                    if (isset($_POST['select_product']) && in_array($row['id_order'], $_POST['selected_products'])) {
                        $total_harga_selected += $row['harga'] * $row['durasi_sewa'];
                    }
                ?>

            <?php endwhile; ?>
        </div>

        <div class="checkout-container">
            <!-- Total harga dan tombol checkout di sebelah kanan -->
            <div class="total-price-container">
                <h4>Total Harga Produk yang Dipilih: IDR <span id="total-harga"><?php echo number_format($total_harga_selected, 0, ',', '.'); ?></span></h4>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
        </div>

        <!-- Modal Checkout -->
        <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda yakin ingin melanjutkan ke checkout dengan total harga berikut?</p>
                        <h4>Total Harga: IDR <span id="modal-total-harga"><?php echo number_format($total_harga_selected, 0, ',', '.'); ?></span></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <a href="checkout.php" class="btn btn-primary">Lanjutkan</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const selectAllCheckbox = document.getElementById('select-all');
            const orderCheckboxes = document.querySelectorAll('.order-checkbox');
            const totalHargaElement = document.getElementById('total-harga');
            const modalTotalHarga = document.getElementById('modal-total-harga');

            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = selectAllCheckbox.checked;
                let totalHarga = 0;

                orderCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;

                    // Hitung total harga produk yang dipilih
                    if (isChecked) {
                        totalHarga += parseInt(checkbox.getAttribute('data-price')) * parseInt(checkbox.getAttribute('data-duration'));
                    }
                });

                totalHargaElement.innerText = new Intl.NumberFormat().format(totalHarga);
                modalTotalHarga.innerText = new Intl.NumberFormat().format(totalHarga);
            });

            orderCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let totalHarga = 0;
                    let selectedCount = 0;

                    orderCheckboxes.forEach(function(checkbox) {
                        if (checkbox.checked) {
                            totalHarga += parseInt(checkbox.getAttribute('data-price')) * parseInt(checkbox.getAttribute('data-duration'));
                            selectedCount++;
                        }
                    });

                    // Perbarui total harga dan toggle checkbox "Select All"
                    totalHargaElement.innerText = new Intl.NumberFormat().format(totalHarga);
                    modalTotalHarga.innerText = new Intl.NumberFormat().format(totalHarga);
                    selectAllCheckbox.checked = selectedCount === orderCheckboxes.length;
                });
            });
        </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>