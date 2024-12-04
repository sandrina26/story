<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memastikan session sudah dimulai
}

include '../../database/configdb.php';

// Ambil order_id dari GET atau POST
$order_id = $_GET['order_id'] ?? $_POST['order_id'] ?? null;

// Pastikan order_id valid
if (!$order_id || !is_numeric($order_id)) {
    die("Invalid request. Order ID not received.");
}

$id_user = $_SESSION['id_user'] ?? null;

// Periksa apakah user login
if (!$id_user) {
    die("You must be logged in to edit an order.");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil detail pesanan berdasarkan order_id
    $sql = "SELECT k.id AS id_order, p.nama_produk, k.tanggal_sewa, k.tanggal_kembali 
            FROM keranjang k 
            JOIN produk p ON k.id_produk = p.id_produk 
            WHERE k.id = ? AND k.id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if (!$order) {
        die("Order not found.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses pembaruan data
    $tanggal_sewa = $_POST['tanggal_sewa'] ?? null;
    $tanggal_kembali = $_POST['tanggal_kembali'] ?? null;

    // Validasi input
    if (!$tanggal_sewa || !$tanggal_kembali) {
        die("Both dates are required.");
    }

    if ($tanggal_kembali < $tanggal_sewa) {
        die("Return date cannot be earlier than rental date.");
    }

    // Hitung jumlah hari
    $datetime1 = new DateTime($tanggal_sewa);
    $datetime2 = new DateTime($tanggal_kembali);
    $interval = $datetime1->diff($datetime2);
    $days = $interval->days;

    // Update data ke database
    $sql = "UPDATE keranjang SET tanggal_sewa = ?, tanggal_kembali = ?, durasi_sewa = ? WHERE id = ? AND id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $tanggal_sewa, $tanggal_kembali, $days, $order_id, $id_user);

    if ($stmt->execute()) {
        echo "<script>alert('Order updated successfully!'); window.location.href = 'myorder.php';</script>";
        exit;
    } else {
        die("Failed to update order: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Order</h2>
    <form method="POST" action="editorder.php">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">

        <div class="mb-3">
            <label for="nama_produk" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="nama_produk" value="<?php echo htmlspecialchars($order['nama_produk']); ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="tanggal_sewa" class="form-label">Rental Start Date</label>
            <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" value="<?php echo htmlspecialchars($order['tanggal_sewa']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_kembali" class="form-label">Rental End Date</label>
            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="<?php echo htmlspecialchars($order['tanggal_kembali'] ?? ''); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="myorder.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
