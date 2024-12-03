<?php
// Mulai sesi
session_start();

// Menghapus semua data sesi
session_unset();

// Menghancurkan sesi
session_destroy();

// Mengarahkan ke halaman homeuser setelah logout
header("Location: ../../auth/login.php");
exit();
?>
