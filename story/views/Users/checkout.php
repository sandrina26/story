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

// Mendapatkan parameter selected_ids dari URL
$selected_ids = $_GET['selected_ids'] ?? '';

if (empty($selected_ids)) {
    die("No products selected.");
}

// Mengambil data produk yang dipilih
$selected_ids_array = explode(',', $selected_ids);
$placeholders = implode(',', array_fill(0, count($selected_ids_array), '?'));
$sql = "SELECT k.id AS id_order, p.id_produk, p.nama_produk, p.harga, k.tanggal_sewa, k.tanggal_kembali, k.durasi_sewa, p.foto 
        FROM keranjang k 
        JOIN produk p ON k.id_produk = p.id_produk 
        WHERE k.id_user = ? AND k.id IN ($placeholders)";

$stmt = $conn->prepare($sql);

// Menggabungkan id_user dengan selected_ids untuk query
$params = array_merge([$id_user], $selected_ids_array);
$stmt->bind_param(str_repeat('i', count($params)), ...$params);

$stmt->execute();
$result = $stmt->get_result();

// Mengambil data alamat, nama, dan no_tlp dari profil pengguna
$sql_user = "SELECT username, no_telp, alamat FROM user WHERE id_user = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param('i', $id_user);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_info = $result_user->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css?ver=1.0">
</head>
<body>
    <?php include '../components/navUser.php'; ?>

    <div class="container my-4">
        <h3 class="my-4">Checkout</h3>

        <!-- Alamat dan Informasi Pengguna -->
        <div class="address-info mb-4">
            <h5>Alamat Pengiriman</h5>
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($user_info['username']); ?></p>
            <p><strong>Nomor Telepon:</strong> <?php echo htmlspecialchars($user_info['no_telp']); ?></p>
            <p><strong>Alamat:</strong> <?php echo nl2br(htmlspecialchars($user_info['alamat'])); ?></p>
        </div>

        <div class="product-list">
            <?php $total_harga = 0; ?>
            <?php $id_order = null; ?> <!-- Inisialisasi id_order -->
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-item mb-3">
                    <div class="d-flex align-items-center">
                        <?php 
                        $imagePath = $row['foto'];
                        if (!empty($imagePath)) {
                            echo '<img src="../../images/' . htmlspecialchars($imagePath) . '" alt="Product" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">';
                        } else {
                            echo '<img src="../../images/adatbali.jpg" alt="Produk Tanpa Gambar" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">';
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
                </div>
                <?php
                $total_harga += $row['harga'] * $row['durasi_sewa'];
                $id_order = $row['id_order']; // Menyimpan id_order
                ?>
            <?php endwhile; ?>
        </div>

        <!-- Deposit dan Diskon -->
        <?php
        $deposit = 150000; // Deposit yang harus dibayar
        $diskon = 0.4; // Diskon 40%

        // Total harga setelah diskon dan deposit
        $total_harga_after_deposit = $total_harga + $deposit;
        $total_harga_after_discount = $total_harga_after_deposit - ($total_harga_after_deposit * $diskon);
        ?>

        <div class="checkout-container">
            <h4>Total Harga Sebelum Diskon dan Deposit: IDR <?php echo number_format($total_harga_after_deposit, 0, ',', '.'); ?></h4>
            <p>Diskon 40%: IDR <?php echo number_format($total_harga_after_deposit * $diskon, 0, ',', '.'); ?></p>
            <h4>Total Harga Setelah Diskon: IDR <?php echo number_format($total_harga_after_discount, 0, ',', '.'); ?></h4>
            <div class="d-flex justify-content-between mt-3">
                <a href="myorder.php" class="btn btn-secondary">Kembali ke Pesanan</a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal" style="background-color: #0a5b5c; color: white; border: none; outline: none;">Konfirmasi Pembayaran</button>
            </div>
        </div>

        <!-- Modal Konfirmasi Pembayaran -->
        <div id="confirmationModal" class="modal fade" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin melanjutkan ke pembayaran dengan total harga berikut?</p>
                        <h4>Total Harga Setelah Diskon: IDR <span id="modal-total-harga"><?php echo number_format($total_harga_after_discount, 0, ',', '.'); ?></span></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <!-- Link untuk lanjut ke pembayaran -->
                        <a id="confirm-checkout" 
                           href="payment.php?id_order=<?php echo $id_order; ?>&total_price=<?php echo $total_harga_after_discount; ?>&virtual_account=<?php echo '4986808749'; ?>" 
                           class="btn btn-primary" style="background-color: #0a5b5c; color: white; border: none; outline: none;">Ya, Lanjutkan Pembayaran</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
