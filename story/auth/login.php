<?php
include "../database/configdb.php"; // Koneksi ke database

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil data user berdasarkan username
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Menyisipkan parameter username
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa apakah user ditemukan
    if ($result->num_rows > 0) {
        // Ambil data user
        $user = $result->fetch_assoc();

        // Memeriksa apakah password cocok dengan MD5
        if (md5($password) === $user['password']) {
            // Menyimpan session login
            session_start();
            $_SESSION['username'] = $user['username']; // Menggunakan 'username'
            $_SESSION['role'] = $user['role']; // Jika ada kolom 'role' untuk menentukan apakah admin atau user biasa

            // Redirect berdasarkan peran user
            if ($user['role'] == 'admin') {
                header("Location: ../views/Admin/homeadmin.php"); // Halaman khusus admin
            } else {
                header("Location: ../views/Users/homeuser.php"); // Halaman home untuk user biasa
            }
            exit();
        } else {
            $error_message = "Password yang Anda masukkan salah.";
        }
    } else {
        $error_message = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../CSS/stylelogin.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <img src="../images/logo.png" alt="Story Logo" class="logo">
            <h1>Welcome back</h1>

            <!-- Google Login Button with Link or JavaScript Function -->
            <button class="google-login" onclick="loginWithGoogle()">
                <img src="../images/icongoogle.webp" alt="Google icon" class="google-icon"> Log in with Google
            </button>

            <!-- Divider Text for Login Options -->
            <p class="or-divider">Or Log in With Username</p>

            <!-- Username Login Form -->
            <form action="login.php" method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>

                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>

                <div class="form-links">
                    <a href="register.php" class="signup-link">Sign up</a>
                    <a href="lupapassword.php" class="forgot-password-link">Forgot Password?</a>
                </div>

                <button type="submit" class="login-button">Log in</button>
            </form>

            <?php
            // Menampilkan pesan error jika login gagal
            if (isset($error_message)) {
                echo "<p style='color:red;'>$error_message</p>";
            }
            ?>
        </div>
        <div class="illustration">
            <img src="../images/gambarlogo.png" alt="Illustration" width="1000" height="600">
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
