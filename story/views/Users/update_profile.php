<?php
session_start();
include '../../database/configdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirimkan melalui form
    $id_user = $_SESSION['id_user'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp']; // Ambil nomor telepon
    $birthday = $_POST['birthday']; // Ambil tanggal lahir

    // Update data pengguna di database
    $sql_update = "UPDATE user SET username = ?, email = ?, alamat = ?, no_telp = ?, birthday = ? WHERE id_user = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssi", $username, $email, $alamat, $no_telp, $birthday, $id_user);
    
    if ($stmt_update->execute()) {
        // Redirect setelah berhasil memperbarui
        header("Location: profil.php?update=success");
    } else {
        echo "Error: " . $stmt_update->error;
    }
}
?>
