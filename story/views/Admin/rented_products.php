<?php
// Memulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan admin yang login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. Only admin can access this page.");
}

// Koneksi ke database
include '../../database/configdb.php';

// Mendapatkan semua pesanan yang belum "Packed"
$sql_orders = "SELECT o.id_order, o.total_pembayaran, o.status_pembayaran, p.status AS order_status 
               FROM pembayaran o
               JOIN pesanan p ON o.id_order = p.id_order
               WHERE o.status_pembayaran = 'Lunas' AND p.status != 'Packed'";
$result_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Orders - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css">
    <link rel="stylesheet" href="../../CSS/style.css">
</head>
<body>
    <?php include '../components/navAdmin.php'; ?>
    <div class="container my-4">
        <h3>Konfirmasi Pesanan</h3>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama User</th>
                    <th>Total Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_orders->num_rows > 0): ?>
                    <?php while ($order = $result_orders->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id_order']); ?></td>
                            <td><?php echo htmlspecialchars($order['username']); ?></td>
                            <td>IDR <?php echo number_format($order['total_pembayaran'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($order['status_pembayaran']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id_order" value="<?php echo htmlspecialchars($order['id_order']); ?>">
                                    <button type="submit" name="confirm" class="btn btn-success btn-sm">Konfirmasi</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada pesanan untuk dikonfirmasi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    // Proses konfirmasi status pesanan menjadi "Packed"
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
        $id_order = $_POST['id_order'];

        // Update status pesanan
        $sql_update_status = "UPDATE pesanan SET status = 'Packed' WHERE id_order = ?";
        $stmt_update_status = $conn->prepare($sql_update_status);
        $stmt_update_status->bind_param('i', $id_order);

        if ($stmt_update_status->execute()) {
            echo "<div class='alert alert-success'>Pesanan $id_order telah dikonfirmasi menjadi 'Packed'.</div>";
            header("Refresh:0");
        } else {
            echo "<div class='alert alert-danger'>Gagal mengubah status pesanan.</div>";
        }
    }
    ?>
</body>
</html>
