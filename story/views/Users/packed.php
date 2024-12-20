<?php
// Memulai session
session_start();

// Pastikan id_user ada dalam sesi
$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    die("User ID is not set in session.");
}

// Koneksi database
include '../../database/configdb.php';

// Query untuk mendapatkan pesanan dengan status "packed"
$sql = "
    SELECT 
        p.id_order,
        pr.nama_produk,
        pr.foto,
        pr.harga,
        k.tanggal_sewa,
        k.tanggal_kembali,
        k.durasi_sewa
    FROM pesanan p
    JOIN keranjang k ON p.id_order = k.id
    JOIN produk pr ON k.id_produk = pr.id_produk
    WHERE p.id_user = ? AND p.status = 'packed'
";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Packed - Story</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css?ver=1.0">
</head>
<body>
    <?php include '../components/navUser.php'; ?>

    <div class="container my-4">
        <div class="select-all-container">
        </div>

        <!-- Tab Navigasi dengan Link -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="my-orders-tab" href="myorder.php" role="tab" style="color: #0a5b5c;">My Orders</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="packed-tab" href="packed.php" role="tab" style="color: black;">Packed</a>
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

    <div class="container my-4">
        <h3 class="mb-4">Packed</h3>

        <?php if ($result->num_rows > 0): ?>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="../../uploads/<?= htmlspecialchars($row['foto']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['nama_produk']) ?></h5>
                            <p class="card-text">
                                Harga: Rp <?= number_format($row['harga'], 0, ',', '.') ?><br>
                                Tanggal Sewa: <?= htmlspecialchars($row['tanggal_sewa']) ?><br>
                                Tanggal Kembali: <?= htmlspecialchars($row['tanggal_kembali']) ?><br>
                                Durasi: <?= htmlspecialchars($row['durasi_sewa']) ?> hari
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Tidak ada pesanan dengan status <strong>Packed</strong>.</div>
    <?php endif; ?>

    <a href="homeuser.php" class="btn btn-primary" style="background-color: #0a5b5c; color: white; border: none; outline: none;">Kembali ke Halaman Utama</a>
</div>

</body>
</html>