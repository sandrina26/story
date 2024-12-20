<?php
// Memulai session
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
$sql = "SELECT k.id AS id_order, p.id_produk, p.nama_produk, p.harga, k.tanggal_sewa, k.tanggal_kembali, k.durasi_sewa, p.foto, o.status 
        FROM keranjang k 
        JOIN produk p ON k.id_produk = p.id_produk
        LEFT JOIN pesanan o ON o.id_order = k.id 
        WHERE k.id_user = ? AND o.status IS NULL"; // Hanya pesanan yang belum dikonfirmasi
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
            margin-right: 15px;
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
            margin-left: 10px;
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
            margin-left: 0;
        }

        .product-item .action-buttons {
            margin-left: auto;
        }

        .checkout-container .action-buttons {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <?php include '../components/navUser.php'; ?>

    <div class="container my-4">
        <div class="select-all-container">
            <input type="checkbox" id="select-all"> <strong>Select All</strong>
        </div>

        <!-- Tab Navigasi dengan Link -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="my-orders-tab" href="myorder.php" role="tab" style="color: black;">My Orders</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="packed-tab" href="packed.php" role="tab" style="color: #0a5b5c;">Packed</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="sent-tab" href="sent.php" role="tab" style="color: #0a5b5c;">Sent</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="canceled-tab" href="canceled.php" role="tab" style="color: #0a5b5c;">Canceled</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="return-tab" href="return.php" role="tab" style="color: #0a5b5c;">Return</a>
            </li>
        </ul>


        <h3 class="my-4">My Orders</h3>

        <div class="product-list">
            <?php $total_harga_selected = 0; ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-item mb-3">
                    <input type="checkbox" class="order-checkbox" data-price="<?php echo $row['harga']; ?>" data-duration="<?php echo $row['durasi_sewa']; ?>" data-name="<?php echo $row['nama_produk']; ?>" data-order-id="<?php echo $row['id_order']; ?>">

                    <div class="d-flex align-items-center">
                        <?php 
                        $imagePath = $row['foto'];
                        if (!empty($imagePath)) {
                            echo '<img src="../../images/' . htmlspecialchars($imagePath) . '" alt="Product" class="img-fluid">';
                        } else {
                            echo '<img src="../../images/adatbali.jpg" alt="Produk Tanpa Gambar" class="img-fluid">';
                        }
                        ?>
                        <div class="ms-3">
                            <h5 class="mb-1"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
                            <p class="mb-0 text-muted">Harga: IDR <?php echo number_format($row['harga'], 0, ',', '.'); ?> / Hari</p>
                            <p class="mb-0 text-muted">Tanggal Sewa: <?php echo $row['tanggal_sewa']; ?></p>
                            <p class="mb-0 text-muted">Tanggal Kembali: <?php echo isset($row['tanggal_kembali']) ? htmlspecialchars($row['tanggal_kembali']) : '-'; ?></p>
                            <p class="mb-0 text-muted">Durasi Sewa: <?php echo $row['durasi_sewa'] . ' Hari'; ?></p>
                            <p class="mb-0 text-muted">Subtotal: IDR <?php echo number_format($row['harga'] * $row['durasi_sewa'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <form method="GET" action="editorder.php">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id_order']); ?>">
                            <button type="submit" class="btn btn-secondary">Edit</button>
                        </form>
                        <form method="POST" action="deleteorder.php">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id_order']); ?>">
                            <button type="submit" class="btn btn-danger" style="background-color: #0a5b5c; color: white; border: none; outline: none;">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="checkout-container">
            <div class="total-price-container">
                <h4>Total Produk: IDR <span id="total-harga"><?php echo number_format($total_harga_selected, 0, ',', '.'); ?></span></h4>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal" style="background-color: #0a5b5c; color: white; border: none; outline: none;">Checkout</button>
        </div>

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
                        <div id="selected-products-list"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <a id="continue-checkout" class="btn btn-primary" href="#" style="background-color: #0a5b5c; color: white; border: none; outline: none;">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Mengambil semua checkbox produk dan checkbox select all
            const orderCheckboxes = document.querySelectorAll('.order-checkbox');
            const selectAllCheckbox = document.getElementById('select-all');
            const totalHargaElement = document.getElementById('total-harga');
            const selectedProductsList = document.getElementById('selected-products-list');
            const modalTotalHarga = document.getElementById('modal-total-harga'); // Menambahkan elemen modal total harga
            let selectedProducts = [];

            // Fungsi untuk menghitung total harga dan produk yang dipilih
            function updateTotal() {
                let total = 0;
                selectedProducts = [];

                orderCheckboxes.forEach((checkbox) => {
                    if (checkbox.checked) {
                        const price = parseInt(checkbox.getAttribute('data-price'));
                        const duration = parseInt(checkbox.getAttribute('data-duration'));
                        const name = checkbox.getAttribute('data-name');
                        const orderId = checkbox.getAttribute('data-order-id');

                        total += price * duration;
                        selectedProducts.push({ name, price, duration, orderId });
                    }
                });

                totalHargaElement.textContent = total.toLocaleString();
                modalTotalHarga.textContent = total.toLocaleString(); // Update total harga di modal
                updateSelectedProductsList();
            }

            // Menampilkan produk yang dipilih
            function updateSelectedProductsList() {
                selectedProductsList.innerHTML = '';
                selectedProducts.forEach((product) => {
                    const li = document.createElement('li');
                    li.textContent = `${product.name} - IDR ${product.price * product.duration} (${product.duration} Hari)`;
                    selectedProductsList.appendChild(li);
                });
            }

            // Mengatur checkbox Select All
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = selectAllCheckbox.checked;
                orderCheckboxes.forEach((checkbox) => {
                    checkbox.checked = isChecked;
                });
                updateTotal(); // Memperbarui total harga setelah memilih semua
            });

            // Event listener untuk setiap checkbox
            orderCheckboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', updateTotal);
            });

            // Inisialisasi total harga saat halaman dimuat
            updateTotal();

            // Event listener untuk checkout
            document.getElementById('continue-checkout').addEventListener('click', function() {
                const selectedIds = selectedProducts.map(product => product.orderId).join(',');

                if (!selectedIds) {
                    alert('Silakan pilih produk terlebih dahulu.');
                    return;
                }

                // Menyusun URL dengan benar
                const checkoutUrl = `checkout.php?selected_ids=${encodeURIComponent(selectedIds)}`;
                window.location.href = checkoutUrl;
            });
        </script>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
