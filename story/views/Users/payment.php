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

// Mendapatkan parameter id_order dan total_price dari URL
$id_order = $_GET['id_order'] ?? null;
$total_price = $_GET['total_price'] ?? null;

if (!$id_order || !$total_price) {
    die("Invalid request. Missing order or price.");
}

// Mengambil data order berdasarkan id_order
$sql_order = "SELECT o.id_order, o.id_user, o.total_pembayaran, o.status_pembayaran, o.bukti_pembayaran 
              FROM pembayaran o WHERE o.id_order = ? AND o.id_user = ?";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param('ii', $id_order, $id_user);
$stmt_order->execute();
$result_order = $stmt_order->get_result();

if ($result_order->num_rows > 0) {
    $order = $result_order->fetch_assoc();
    $existing_payment = true;
    $total_pembayaran = $order['total_pembayaran'];
    $status_pembayaran = $order['status_pembayaran'];
    $bukti_pembayaran = $order['bukti_pembayaran'];
} else {
    $existing_payment = false;
    $total_pembayaran = $total_price;
    $status_pembayaran = 'Menunggu Pembayaran';
    $bukti_pembayaran = null;
}

// Proses pembaruan pembayaran setelah konfirmasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulasikan pembayaran menggunakan virtual account
    $virtual_account = 'VA-' . strtoupper(uniqid()); // Virtual account ID yang di-generate
    $status = 'Lunas'; // Misalnya status pembayaran berhasil

    // Validasi file upload
    if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['bukti_pembayaran']['tmp_name'];
        $file_name = basename($_FILES['bukti_pembayaran']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!in_array($file_ext, $allowed_ext)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and PDF files are allowed.");
        }

        $upload_dir = '../../uploads/bukti_pembayaran/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $new_file_name = uniqid('bukti_') . '.' . $file_ext;
        $file_dest = $upload_dir . $new_file_name;

        if (!move_uploaded_file($file_tmp, $file_dest)) {
            die("Failed to upload the file.");
        }

        // Simpan data pembayaran ke database
        $sql_update = "UPDATE pembayaran SET virtual_account = ?, status_pembayaran = ?, bukti_pembayaran = ? WHERE id_order = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param('sssi', $virtual_account, $status, $new_file_name, $id_order);
        $stmt_update->execute();

        // Perbarui status pesanan menjadi 'Packed' setelah pembayaran berhasil
        $sql_update_status = "UPDATE pesanan SET status = 'Packed' WHERE id_order = ?";
        $stmt_update_status = $conn->prepare($sql_update_status);
        $stmt_update_status->bind_param('i', $id_order);
        $stmt_update_status->execute();

        // Redirect ke halaman konfirmasi setelah pembayaran berhasil
        header("Location: confirmation.php?id_order=$id_order&status=$status");
        exit();
    } else {
        die("Please upload a valid payment proof file.");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Story</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/stylehome.css?ver=1.0">
</head>
<body>

    <?php include '../components/navUser.php'; ?>

    <div class="container my-4">
        <h3 class="my-4">Halaman Pembayaran</h3>

        <!-- Informasi Pembayaran -->
        <div class="payment-info mb-4">
            <h5>Informasi Pembayaran</h5>
            <p><strong>ID Pesanan:</strong> <?php echo htmlspecialchars($id_order); ?></p>
            <p><strong>Total Pembayaran:</strong> IDR <?php echo number_format($total_pembayaran, 0, ',', '.'); ?></p>
            <p><strong>Status Pembayaran:</strong> <?php echo htmlspecialchars($status_pembayaran); ?></p>
            <?php if ($bukti_pembayaran): ?>
                <p><strong>Bukti Pembayaran:</strong> <a href="../../uploads/bukti_pembayaran/<?php echo htmlspecialchars($bukti_pembayaran); ?>" target="_blank">Lihat Bukti</a></p>
            <?php endif; ?>
        </div>

        <?php if ($existing_payment && $status_pembayaran === 'Lunas'): ?>
            <div class="alert alert-success">
                Pembayaran Anda telah lunas. Terima kasih!
            </div>
        <?php else: ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="virtual-account" class="form-label">Virtual Account</label>
                    <input type="text" class="form-control" id="virtual-account" value="VA-<?php echo strtoupper(uniqid()); ?>" disabled>
                    <small class="form-text text-muted">Silakan lakukan pembayaran melalui virtual account di atas.</small>
                </div>

                <div class="mb-3">
                    <label for="bukti_pembayaran" class="form-label">Unggah Bukti Pembayaran</label>
                    <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" required>
                    <small class="form-text text-muted">Unggah file dalam format JPG, JPEG, PNG, atau PDF.</small>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="myorder.php" class="btn btn-secondary">Kembali ke Pesanan</a>
                    <button type="submit" class="btn btn-primary" style="background-color: #0a5b5c; color: white; border: none; outline: none;">Konfirmasi Pembayaran</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
